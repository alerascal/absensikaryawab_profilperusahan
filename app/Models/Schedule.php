<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'days',        // [1,2,3,4,5]
        'start_time',
        'end_time',
        'is_fulltime',
        'shift_id',
    ];

    protected $casts = [
        'days' => 'array',
        'is_fulltime' => 'boolean',
    ];

    // ================= RELATIONS =================
    public function users()
    {
        return $this->belongsToMany(User::class, 'schedule_user');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }
}
