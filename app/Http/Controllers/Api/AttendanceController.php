<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;

class AttendanceController extends Controller {
    private $center = ['lat' => -7.675, 'lon' => 109.657, 'radius' => 500];

    public function checkin(Request $req){
        if(!$this->inside($req->lat,$req->lon)) return ['error'=>'outside geofence'];
        Attendance::create([
            'user_id'=>$req->user_id,
            'lat'=>$req->lat,
            'lon'=>$req->lon,
            'type'=>'checkin',
            'time'=>now()
        ]);
        return ['success'=>true];
    }
    public function checkout(Request $req){
        if(!$this->inside($req->lat,$req->lon)) return ['error'=>'outside geofence'];
        Attendance::create([
            'user_id'=>$req->user_id,
            'lat'=>$req->lat,
            'lon'=>$req->lon,
            'type'=>'checkout',
            'time'=>now()
        ]);
        return ['success'=>true];
    }
    public function list(){
        return Attendance::all();
    }
    private function inside($lat,$lon){
        $d = $this->distance($lat,$lon,$this->center['lat'],$this->center['lon']);
        return $d <= $this->center['radius'];
    }
    private function distance($lat1,$lon1,$lat2,$lon2){
        $R=6371000;
        $dLat=deg2rad($lat2-$lat1);
        $dLon=deg2rad($lon2-$lon1);
        $a=sin($dLat/2)*sin($dLat/2)+cos(deg2rad($lat1))*cos(deg2rad($lat2))*sin($dLon/2)*sin($dLon/2);
        $c=2*atan2(sqrt($a),sqrt(1-$a));
        return $R*$c;
    }
}
