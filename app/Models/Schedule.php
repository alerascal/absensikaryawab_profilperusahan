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
        'start_time',
        'end_time',
        'is_fulltime',
        'shift_id',
    ];

    protected $casts = [
        'is_fulltime' => 'boolean',
    ];

    // Relasi ke Users (for shift-based schedules)
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'schedule_user');
    }

    // Relasi ke Shift
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class);
    }
}