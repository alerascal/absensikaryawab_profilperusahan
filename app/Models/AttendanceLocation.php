<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendance_locations';

    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'radius',
    ];

    // Relasi: Satu lokasi bisa memiliki banyak absensi
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'attendance_location_id');
    }
}