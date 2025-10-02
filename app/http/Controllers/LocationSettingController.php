<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;
    protected $startDate;
    protected $endDate;

    public function __construct($userId = null, $startDate = null, $endDate = null)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return Attendance::with('user')
            ->when($this->userId, function($query) {
                $query->where('user_id', $this->userId);
            })
            ->when($this->startDate, function($query) {
                $query->whereDate('attendance_time', '>=', $this->startDate);
            })
            ->when($this->endDate, function($query) {
                $query->whereDate('attendance_time', '<=', $this->endDate);
            })
            ->orderBy('attendance_time', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Nama Guru',
            'NIP',
            'Tipe',
            'Waktu Absensi',
            'Latitude',
            'Longitude',
            'Status Lokasi',
            'Jarak (meter)',
            'Tanggal Input'
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->user->name,
            $attendance->user->nip,
            $attendance->type == 'in' ? 'Masuk' : 'Pulang',
            $attendance->attendance_time->format('Y-m-d H:i:s'),
            $attendance->latitude,
            $attendance->longitude,
            $attendance->location_status == 'valid' ? 'Valid' : 'Tidak Valid',
            $attendance->distance,
            $attendance->created_at->format('Y-m-d H:i:s')
        ];
    }
}