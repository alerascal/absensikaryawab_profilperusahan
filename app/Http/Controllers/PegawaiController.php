<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Dashboard khusus Pegawai
     */
    public function pegawaiDashboard()
    {
        $user = Auth::user();

        // Absensi hari ini
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        $todayCheckIn  = $todayAttendance?->check_in ?? '-';
        $todayCheckOut = $todayAttendance?->check_out ?? '-';
        $todayStatus   = $todayAttendance?->status ?? 'Belum Absen';

        // Total kehadiran bulan ini
        $totalAbsensi = Attendance::where('user_id', $user->id)
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->count();

        // Riwayat absensi minggu ini
        $weeklyAttendance = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [
                Carbon::now()->startOfWeek(Carbon::MONDAY),
                Carbon::now()->endOfWeek(Carbon::SUNDAY)
            ])
            ->orderBy('date', 'asc')
            ->get();

        // Data grafik kehadiran bulan ini
        $monthlyLabels = [];
        $monthlyHadir = [];

        $daysInMonth = Carbon::now()->daysInMonth;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::now()->day($day);
            $monthlyLabels[] = $date->format('d');

            $hadir = Attendance::where('user_id', $user->id)
                ->whereDate('date', $date)
                ->where('status', 'Hadir')
                ->exists();

            $monthlyHadir[] = $hadir ? 1 : 0;
        }

        return view('dashboard-pegawai', compact(
            'todayCheckIn',
            'todayCheckOut',
            'todayStatus',
            'totalAbsensi',
            'weeklyAttendance',
            'monthlyLabels',
            'monthlyHadir'
        ));
    }
}
