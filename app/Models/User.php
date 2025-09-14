<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'is_active',
        'employee_id',
        'position',
        'employment_status',
        'join_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'join_date' => 'date',
    ];

    // Relasi ke Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Relasi ke Schedules (pivot table: schedule_user)
    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_user');
    }

    // Relasi ke Attendances
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    // Relasi ke Pengajuan (menggantikan atau melengkapi Leave)
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'user_id');
    }

    // Cek apakah user memiliki role tertentu
    public function hasRole($role)
    {
        return $this->role === $role;
    }
}