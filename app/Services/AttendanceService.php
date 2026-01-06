<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceService
{
  /**
   * Ambil data absensi (admin)
   */
  public function getAttendances(array $filters = [])
  {
    $query = Attendance::with(['user.department', 'attendanceLocation']);

    if (!empty($filters['date'])) {
      $query->whereDate('date', $filters['date']);
    }

    if (!empty($filters['user_id'])) {
      $query->where('user_id', $filters['user_id']);
    }

    if (!empty($filters['status'])) {
      $query->where('status', $filters['status']);
    }

    return [
      'attendances' => $query->orderBy('date', 'desc')->paginate(10),
    ];
  }

  /**
   * Auto Alpha (dipakai scheduler)
   */
  public function autoAlpha(Carbon $date)
  {
    $users = User::where('is_active', true)->get();

    foreach ($users as $user) {
      $exists = Attendance::where('user_id', $user->id)
        ->whereDate('date', $date)
        ->exists();

      if (!$exists) {
        Attendance::create([
          'user_id' => $user->id,
          'date' => $date,
          'status' => 'Alpha',
          'notes' => 'Tidak melakukan absensi',
        ]);
      }
    }
  }
  public function getTodayAttendanceCount(int $userId): int
  {
    return \App\Models\Attendance::where('user_id', $userId)
      ->whereDate('date', today())
      ->count();
  }
}

