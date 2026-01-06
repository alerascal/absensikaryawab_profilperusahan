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

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'is_active' => 'boolean',
        'join_date' => 'date',
    ];

    // ================= RELATIONS =================
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_user');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class);
    }

    // ================= HELPERS =================
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
}
