<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'latitude',
        'longitude',
        'radius',
        'created_by'
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'radius' => 'integer'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}