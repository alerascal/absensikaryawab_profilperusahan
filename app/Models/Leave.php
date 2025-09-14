<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'date',
        'status',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}