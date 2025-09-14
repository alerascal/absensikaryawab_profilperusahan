<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AttendanceExport;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        // Ambil jadwal aktif user (berdasarkan start_time & end_time hari ini)
        $schedule = $user->schedules()
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->with('shift')
            ->first();

        // Tentukan jam masuk & jam pulang
        if ($schedule && $schedule->shift) {
            // User shift
            $jamMasuk = Carbon::parse($schedule->shift->start_time)->format('H:i');
            $jamPulang = Carbon::parse($schedule->shift->end_time)->format('H:i');
        } elseif ($schedule) {
            // User fulltime (tidak ada shift)
            $jamMasuk = Carbon::parse($schedule->start_time)->format('H:i');
            $jamPulang = Carbon::parse($schedule->end_time)->format('H:i');
        } else {
            // Tidak ada jadwal
            $jamMasuk = '-';
            $jamPulang = '-';
        }

        // Status sistem
        $statusSistem = 'Online';

        // Karyawan aktif
        $karyawanAktif = User::where('is_active', 1)->count();

        // Total semua karyawan
        $totalUsers = User::count();

        // Statistik hari ini
        $hadirHariIni = Attendance::where('status', 'Hadir')->whereDate('date', $today)->count();
        $terlambat = Attendance::where('status', 'Terlambat')->whereDate('date', $today)->count();
        $absenHariIni = Attendance::where('status', 'Absen')->whereDate('date', $today)->count();

        // Get month from request or default to current month
        $month = $request->input('month', now()->month);
        $month = max(1, min(12, (int) $month));
        $year = now()->year;
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;

        $monthlyLabels = [];
        $monthlyHadir = [];
        $monthlyTerlambat = [];
        $monthlyAbsen = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day)->toDateString();
            $monthlyLabels[] = $day;

            $monthlyHadir[] = Attendance::where('status', 'Hadir')->whereDate('date', $date)->count();
            $monthlyTerlambat[] = Attendance::where('status', 'Terlambat')->whereDate('date', $date)->count();
            $monthlyAbsen[] = Attendance::where('status', 'Absen')->whereDate('date', $date)->count();
        }

        // Departemen terbaik (berdasarkan persentase hadir)
        $departments = Department::withCount(['users as hadir_count' => function ($q) use ($year, $month) {
            $q->whereHas('attendances', function ($q2) use ($year, $month) {
                $q2->where('status', 'Hadir')
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month);
            });
        }])->get()->map(function ($d) {
            $totalUsers = $d->users()->count();
            $d->persen = $totalUsers ? round($d->hadir_count / $totalUsers * 100) : 0;
            return $d;
        })->sortByDesc('persen');

        // Daftar karyawan terlambat hari ini
        $terlambatHariIni = Attendance::with('user')
            ->where('status', 'Terlambat')
            ->whereDate('date', $today)
            ->get()
            ->map(function ($att) {
                return (object) [
                    'name' => $att->user->name ?? '-',
                    'attendance' => $att,
                ];
            });

        // Daftar bulan untuk filter
        $months = collect(range(1, 12))->map(function ($m) {
            return [
                'value' => $m,
                'name' => Carbon::create(null, $m, 1)->translatedFormat('F'),
            ];
        });

        return view('dashboard-admin', compact(
            'jamMasuk',
            'jamPulang',
            'statusSistem',
            'karyawanAktif',
            'totalUsers',
            'hadirHariIni',
            'terlambat',
            'absenHariIni',
            'monthlyLabels',
            'monthlyHadir',
            'monthlyTerlambat',
            'monthlyAbsen',
            'departments',
            'terlambatHariIni',
            'month',
            'months'
        ));
    }

    public function exportData()
    {
        return Excel::download(new AttendanceExport, 'attendance.xlsx');
    }
}
