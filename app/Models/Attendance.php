<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'schedule_id',
        'attendance_location_id',
        'date',
        'check_in',
        'check_out',
        'status', // Hadir, Terlambat, Alpha, Izin, Sakit
        'photo_path',
        'notes',
        'latitude',
        'longitude',
        'accuracy',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'accuracy' => 'decimal:2',
    ];

    // ================= RELATIONS =================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function attendanceLocation()
    {
        return $this->belongsTo(AttendanceLocation::class, 'attendance_location_id');
    }


    // ================= ACCESSORS =================
    public function getFormattedCheckInAttribute()
    {
        return $this->check_in ? $this->check_in->format('H:i') : '-';
    }

    public function getFormattedCheckOutAttribute()
    {
        return $this->check_out ? $this->check_out->format('H:i') : '-';
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo_path
            ? asset('storage/' . $this->photo_path)
            : null;
    }
}
