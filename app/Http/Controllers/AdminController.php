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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        // Konversi hari agar sesuai (Carbon: 0 = Minggu, 1 = Senin, dst)
        $dayOfWeek = $now->dayOfWeek === 0 ? 7 : $now->dayOfWeek;

        // Ambil jadwal user dengan shift
        $schedule = $user->schedules()
            ->whereJsonContains('day', $dayOfWeek)
            ->with('shift')
            ->first();
        if ($schedule) {
            if ($schedule->shift) {
                // Kalau ada shift
                $jamMasuk = Carbon::parse($schedule->shift->start_time)->format('H:i');
                $jamPulang = Carbon::parse($schedule->shift->end_time)->format('H:i');
            } else {
                // Kalau jadwal tanpa shift (fulltime)
                $jamMasuk = Carbon::parse($schedule->start_time)->format('H:i');
                $jamPulang = Carbon::parse($schedule->end_time)->format('H:i');
            }
        } else {
            $scheduleFull = \App\Models\Schedule::whereJsonContains('day', $dayOfWeek)
                ->where('is_fulltime', 1)
                ->first();
            if ($scheduleFull) {
                $jamMasuk = Carbon::parse($scheduleFull->start_time)->format('H:i');
                $jamPulang = Carbon::parse($scheduleFull->end_time)->format('H:i');
            } else {
                $jamMasuk = '-';
                $jamPulang = '-';
            }
        }


        // Status sistem
        $statusSistem = 'Online';

        // Karyawan aktif
        $karyawanAktif = User::where('is_active', 1)->count();

        // Total semua karyawan
        $totalUsers = User::count();

        // Statistik hari ini
        $hadirHariIni = Attendance::whereIn('status', ['present', 'Hadir'])
            ->whereDate('date', $today)->count();

        $terlambat = Attendance::whereIn('status', ['late', 'Terlambat'])
            ->whereDate('date', $today)->count();

        $absenHariIni = Attendance::whereIn('status', ['absent', 'Absen'])
            ->whereDate('date', $today)->count();

        // Statistik bulanan
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

            $monthlyHadir[] = Attendance::whereIn('status', ['present', 'Hadir'])
                ->whereDate('date', $date)->count();

            $monthlyTerlambat[] = Attendance::whereIn('status', ['late', 'Terlambat'])
                ->whereDate('date', $date)->count();

            $monthlyAbsen[] = Attendance::whereIn('status', ['absent', 'Absen'])
                ->whereDate('date', $date)->count();
        }

        // Departemen terbaik
        $departments = Department::withCount(['users as hadir_count' => function ($q) use ($year, $month) {
            $q->whereHas('attendances', function ($q2) use ($year, $month) {
                $q2->whereIn('status', ['present', 'Hadir'])
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month);
            });
        }])->get()->map(function ($d) {
            $totalUsers = $d->users()->count();
            $d->persen = $totalUsers ? round($d->hadir_count / $totalUsers * 100) : 0;
            return $d;
        })->sortByDesc('persen');

        // Karyawan terlambat hari ini
        $terlambatHariIni = Attendance::with(['user', 'user.department'])
            ->whereIn('status', ['late', 'Terlambat'])
            ->whereDate('date', $today)
            ->get()
            ->map(function ($att) {
                return (object) [
                    'name' => $att->user->name ?? '-',
                    'department' => $att->user->department ?? null,
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

        // Semua user aktif (untuk manual attendance)
        $allUsers = User::where('is_active', 1)
            ->orderBy('name')
            ->select('id', 'name', 'employee_id')
            ->get();

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
            'months',
            'allUsers'
        ));
    }
    public function manualAttendance(Request $request)
    {
        try {
            // Log request data untuk debugging
            Log::info('Manual Attendance Request Data:', $request->all());

            // Validasi input
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'date' => 'required|date',
                'type' => 'required|string|in:check_in,check_out,full_day',
                'status' => 'required|string|in:hadir,terlambat,remote',
                'check_in' => 'nullable|date_format:H:i',
                'check_out' => 'nullable|date_format:H:i',
                'notes' => 'nullable|string|max:500',
            ]);

            $userId = $validated['user_id'];
            $date = Carbon::parse($validated['date'])->format('Y-m-d');
            $type = $validated['type'];
            $status = $validated['status'];
            $notes = $validated['notes'] ?? null;

            // Cek apakah sudah ada attendance untuk user dan tanggal tersebut
            $existingAttendance = Attendance::where('user_id', $userId)
                ->whereDate('date', $date)
                ->first();

            DB::beginTransaction();

            if ($existingAttendance) {
                // Update existing attendance
                $updateData = ['status' => $status];

                if ($type === 'check_in' || $type === 'full_day') {
                    if ($validated['check_in']) {
                        $updateData['check_in'] = $validated['check_in'];
                    }
                }

                if ($type === 'check_out' || $type === 'full_day') {
                    if ($validated['check_out']) {
                        $updateData['check_out'] = $validated['check_out'];
                    }
                }

                if ($notes) {
                    $updateData['notes'] = $notes;
                }

                $existingAttendance->update($updateData);
                $attendance = $existingAttendance;
            } else {
                // Create new attendance
                $attendanceData = [
                    'user_id' => $userId,
                    'date' => $date,
                    'status' => $status,
                    'location' => 'Manual Entry by Admin',
                    'notes' => $notes,
                ];

                if ($type === 'check_in' || $type === 'full_day') {
                    if ($validated['check_in']) {
                        $attendanceData['check_in'] = $validated['check_in'];
                    }
                }

                if ($type === 'check_out' || $type === 'full_day') {
                    if ($validated['check_out']) {
                        $attendanceData['check_out'] = $validated['check_out'];
                    }
                }

                $attendance = Attendance::create($attendanceData);
            }

            DB::commit();

            Log::info('Manual Attendance Success:', [
                'attendance_id' => $attendance->id,
                'user_id' => $userId,
                'date' => $date,
                'type' => $type
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absensi manual berhasil disimpan!',
                'data' => [
                    'id' => $attendance->id,
                    'user_name' => $attendance->user->name,
                    'date' => $attendance->date,
                    'status' => $attendance->status
                ]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollback();
            Log::error('Manual Attendance Validation Error:', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Manual Attendance Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportData()
    {
        return Excel::download(new AttendanceExport, 'attendance.xlsx');
    }
}
