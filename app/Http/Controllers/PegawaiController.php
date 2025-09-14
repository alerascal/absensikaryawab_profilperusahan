<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // Dashboard khusus Pegawai
    public function pegawaiDashboard()
    {
        $user = Auth::user();

        // Data absensi hari ini
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        $todayCheckIn  = $todayAttendance->check_in  ?? null;
        $todayCheckOut = $todayAttendance->check_out ?? null;
        $todayStatus   = $todayAttendance->status ?? 'Belum Absen';

        // Total absensi bulan ini
        $totalAbsensi = Attendance::where('user_id', $user->id)
            ->whereMonth('date', Carbon::now()->month)
            ->count();

        // Riwayat absensi minggu ini
        $weeklyAttendance = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->orderBy('date', 'asc')
            ->get();

        // Grafik absensi bulan ini
        $daysInMonth = Carbon::now()->daysInMonth;
        $monthlyLabels = [];
        $monthlyHadir = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate(Carbon::now()->year, Carbon::now()->month, $day);
            $monthlyLabels[] = $date->translatedFormat('d M');

            $hadir = Attendance::where('user_id', $user->id)
                ->whereDate('date', $date)
                ->where('status', 'Hadir')
                ->count();

            $monthlyHadir[] = $hadir;
        }

        return view('pages.pegawai.dashboard-pegawai', compact(
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
