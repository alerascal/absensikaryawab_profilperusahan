<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendances';

    protected $fillable = [
        'user_id',
        'schedule_id',
        'attendance_location_id',
        'check_in',
        'check_out',
        'status',
        'location',
        'date',
        'photo_path',
        'notes',
        'latitude',
        'longitude',
        'accuracy',
        'altitude',
        'heading',
        'speed',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime:H:i:s',
        'check_out' => 'datetime:H:i:s',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'accuracy' => 'decimal:2',
        'altitude' => 'decimal:2',
        'heading' => 'decimal:2',
        'speed' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function attendanceLocation()
    {
        return $this->belongsTo(AttendanceLocation::class, 'attendance_location_id');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Hadir' => 'bg-green-100 text-green-800',
            'Terlambat' => 'bg-yellow-100 text-yellow-800',
            'Absen' => 'bg-red-100 text-red-800',
            'WFH' => 'bg-blue-100 text-blue-800',
            'Sakit' => 'bg-purple-100 text-purple-800',
            'Izin' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getFormattedDateAttribute()
    {
        return $this->date ? $this->date->format('d M Y') : '-';
    }

    public function getFormattedCheckInAttribute()
    {
        return $this->check_in ? Carbon::parse($this->check_in)->format('H:i') : '-';
    }

    public function getFormattedCheckOutAttribute()
    {
        return $this->check_out ? Carbon::parse($this->check_out)->format('H:i') : '-';
    }

    public function getGpsQualityAttribute()
    {
        if (!$this->accuracy) return null;
        
        if ($this->accuracy <= 10) return 'Sangat Baik';
        if ($this->accuracy <= 20) return 'Baik';
        if ($this->accuracy <= 50) return 'Cukup';
        if ($this->accuracy <= 100) return 'Kurang';
        return 'Buruk';
    }

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo_path) return null;
        return asset('storage/' . $this->photo_path);
    }

    public function getLocationInfoAttribute()
    {
        if ($this->attendanceLocation) {
            return $this->attendanceLocation->name;
        }
        
        if ($this->location) {
            return $this->location;
        }
        
        if ($this->latitude && $this->longitude) {
            return "GPS: {$this->latitude}, {$this->longitude}";
        }
        
        return 'Lokasi tidak dikenal';
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}