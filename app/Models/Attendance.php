<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'attendance_time',
        'latitude',
        'longitude',
        'location_status',
        'distance'
    ];

    protected $casts = [
        'attendance_time' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'distance' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}