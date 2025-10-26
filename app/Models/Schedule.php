<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'day',          // 1-7 (1=Senin, 7=Minggu)
        'start_time',   // format H:i
        'end_time',     // format H:i
        'is_fulltime',  // boolean
        'shift_id',     // nullable, hanya untuk non-fulltime
    ];

    protected $casts = [
        'day' => 'array',
        'is_fulltime' => 'boolean',
    ];


    /**
     * Relasi many-to-many dengan User
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'schedule_users');
    }

    /**
     * Relasi dengan Shift (hanya untuk non-fulltime)
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }

    /**
     * Relasi dengan Holiday
     */
    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    /**
     * Helper: Get day name in Indonesian
     */
    public function getDayNameAttribute(): string
    {
        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        return $days[$this->day] ?? 'Tidak diketahui';
    }

    /**
     * Scope: Filter by day
     */
    public function scopeForDay($query, int $day)
    {
        return $query->whereJsonContains('day', $day);
    }


    /**
     * Scope: Only fulltime schedules
     */
    public function scopeFulltime($query)
    {
        return $query->where('is_fulltime', true);
    }

    /**
     * Scope: Only shift schedules
     */
    public function scopeShift($query)
    {
        return $query->where('is_fulltime', false);
    }
}
