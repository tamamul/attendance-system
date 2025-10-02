<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\LocationSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        return $this->recordAttendance($request, 'in');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        return $this->recordAttendance($request, 'out');
    }

    private function recordAttendance(Request $request, $type)
    {
        $user = $request->user();
        $locationSetting = LocationSetting::latest()->first();
        
        if (!$locationSetting) {
            return response()->json([
                'message' => 'Location setting not configured'
            ], 400);
        }

        $distance = $this->calculateDistance(
            $locationSetting->latitude,
            $locationSetting->longitude,
            $request->latitude,
            $request->longitude
        );

        $locationStatus = $distance <= $locationSetting->radius ? 'valid' : 'invalid';

        $attendance = Attendance::create([
            'user_id' => $user->id,
            'type' => $type,
            'attendance_time' => now(),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'location_status' => $locationStatus,
            'distance' => $distance
        ]);

        return response()->json([
            'message' => "Check {$type} recorded successfully",
            'attendance' => $attendance,
            'location_status' => $locationStatus,
            'distance' => round($distance, 2)
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    public function getMyAttendances(Request $request)
    {
        $user = $request->user();
        
        $attendances = Attendance::where('user_id', $user->id)
            ->orderBy('attendance_time', 'desc')
            ->paginate(10);

        return response()->json($attendances);
    }

    public function getAllAttendances(Request $request)
    {
        $this->authorize('admin', User::class);

        $attendances = Attendance::with('user')
            ->when($request->user_id, function($query) use ($request) {
                $query->where('user_id', $request->user_id);
            })
            ->when($request->date, function($query) use ($request) {
                $query->whereDate('attendance_time', $request->date);
            })
            ->orderBy('attendance_time', 'desc')
            ->paginate(10);

        return response()->json($attendances);
    }

    public function getAttendanceReport(Request $request)
    {
        $this->authorize('admin', User::class);

        $report = User::where('role', 'guru')
            ->withCount(['attendances as total_check_in' => function($query) use ($request) {
                $query->where('type', 'in')
                    ->when($request->start_date, function($q) use ($request) {
                        $q->whereDate('attendance_time', '>=', $request->start_date);
                    })
                    ->when($request->end_date, function($q) use ($request) {
                        $q->whereDate('attendance_time', '<=', $request->end_date);
                    });
            }])
            ->withCount(['attendances as total_check_out' => function($query) use ($request) {
                $query->where('type', 'out')
                    ->when($request->start_date, function($q) use ($request) {
                        $q->whereDate('attendance_time', '>=', $request->start_date);
                    })
                    ->when($request->end_date, function($q) use ($request) {
                        $q->whereDate('attendance_time', '<=', $request->end_date);
                    });
            }])
            ->get();

        return response()->json($report);
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('admin', User::class);

        $filename = 'attendance_report_' . date('Y_m_d_His') . '.xlsx';
        
        return Excel::download(new AttendanceExport(
            $request->user_id,
            $request->start_date,
            $request->end_date
        ), $filename);
    }
}