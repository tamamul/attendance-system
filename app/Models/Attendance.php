<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    protected $fillable = ['user_id','lat','lon','type','time'];
    public $timestamps = false;
}
