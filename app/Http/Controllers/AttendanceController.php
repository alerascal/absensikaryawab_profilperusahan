<?php

namespace App\Http\Controllers;

use App\Models\{
    Attendance,
    AttendanceLocation,
    Schedule,
    Pengajuan,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Storage,
    Log
};
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\AttendanceService;

class AttendanceController extends Controller
{
    protected AttendanceService $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
        $this->middleware('auth');

        $this->middleware('role:admin')->only([
            'index',
            'destroy',
            'export',
            'download'
        ]);

        $this->middleware('throttle:60,1')->only('cameraAttendance');
    }

    /* =====================================================
     |  HALAMAN KAMERA
     ===================================================== */
    public function attendanceCameraPage()
    {
        $attendanceLocations = AttendanceLocation::where('is_active', true)->get();

        if ($attendanceLocations->isEmpty()) {
            return back()->with('error', 'Lokasi absensi belum tersedia.');
        }

        return view('camera', compact('attendanceLocations'));
    }

    /* =====================================================
 |  ABSENSI VIA KAMERA (CORE SYSTEM) - VERSI FINAL
 ===================================================== */
    public function cameraAttendance(Request $request)
    {
        $request->validate([
            'photo'       => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
            'accuracy'    => 'nullable|numeric',
            'location_id' => 'required|exists:attendance_locations,id',
        ]);

        $user  = Auth::user();
        $today = today(); // Carbon date (2026-01-05 untuk contoh)
        $now   = Carbon::now();

        // ===== 1. CEK SUDAH ABSEN HARI INI =====
        if (Attendance::where('user_id', $user->id)->whereDate('date', $today)->exists()) {
            throw ValidationException::withMessages([
                'attendance' => 'Anda sudah melakukan absensi hari ini.'
            ]);
        }

        // ===== 2. CEK PENGAJUAN IZIN / SAKIT YANG SUDAH DIAPPROVE =====
        $pengajuan = Pengajuan::where('user_id', $user->id)
            ->whereDate('date', $today) // pastikan kolom 'date' sudah ada di tabel pengajuans
            ->where('status', 'approved')
            ->first();

        if ($pengajuan) {
            $attendance = Attendance::create([
                'user_id'               => $user->id,
                'schedule_id'           => $this->getTodaySchedule($user)?->id, // optional: isi jadwal jika ada
                'attendance_location_id' => null,
                'date'                  => $today,
                'check_in'              => null,
                'check_out'             => null,
                'status'                => ucfirst($pengajuan->type), // Izin atau Sakit
                'notes'                 => $pengajuan->description . ' (' . ucfirst($pengajuan->type) . ' disetujui)',
                'photo_path'            => null,
                'latitude'              => null,
                'longitude'             => null,
                'accuracy'              => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absensi otomatis tercatat sebagai ' . ucfirst($pengajuan->type),
                'attendance' => [
                    'status' => $attendance->status,
                ]
            ]);
        }

        // ===== 3. AMBIL JADWAL HARI INI =====
        $schedule = $this->getTodaySchedule($user);

        if (!$schedule) {
            throw ValidationException::withMessages([
                'schedule' => 'Tidak ada jadwal kerja hari ini.'
            ]);
        }

        // ===== 4. HITUNG KETERLAMBATAN =====
        $startTime    = Carbon::parse($schedule->start_time);
        $lateMinutes  = $startTime->diffInMinutes($now, false); // positif jika terlambat

        // Terlambat >30 menit → otomatis Alpha
        if ($lateMinutes > 30) {
            $attendance = Attendance::create([
                'user_id'               => $user->id,
                'schedule_id'           => $schedule->id,
                'attendance_location_id' => $request->location_id,
                'date'                  => $today,
                'check_in'              => $now,
                'status'                => 'Alpha',
                'notes'                 => 'Terlambat lebih dari 30 menit',
                'photo_path'            => null,
                'latitude'              => $request->latitude,
                'longitude'             => $request->longitude,
                'accuracy'              => $request->accuracy,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Terlambat lebih dari 30 menit. Absensi tercatat sebagai Alpha.',
                'attendance' => [
                    'status' => 'Alpha',
                ]
            ]);
        }

        // Status normal: Hadir atau Terlambat (21-30 menit)
        $status = $lateMinutes > 20 ? 'Terlambat' : 'Hadir';

        // ===== 5. SIMPAN FOTO =====
        $photoPath = $request->file('photo')->store('attendance', 'public');

        // ===== 6. SIMPAN ABSENSI NORMAL =====
        $attendance = Attendance::create([
            'user_id'               => $user->id,
            'schedule_id'           => $schedule->id,
            'attendance_location_id' => $request->location_id,
            'date'                  => $today,
            'check_in'              => $now,
            'check_out'             => null,
            'status'                => $status,
            'notes'                 => $lateMinutes > 20 ? 'Terlambat ' . $lateMinutes . ' menit' : null,
            'photo_path'            => $photoPath,
            'latitude'              => $request->latitude,
            'longitude'             => $request->longitude,
            'accuracy'              => $request->accuracy,
        ]);

        // ===== 7. RESPONSE FINAL (konsisten untuk semua kasus) =====
        return response()->json([
            'success' => true,
            'message' => 'Absensi berhasil! Status: ' . $status,
            'attendance' => [
                'status' => $attendance->status,
            ]
        ]);
    }
    /* =====================================================
 |  CEK JADWAL HARI INI (AJAX)
 ===================================================== */
    public function checkSchedule()
    {
        $user = Auth::user();
        $today = today();

        // Sudah absen?
        if (Attendance::where('user_id', $user->id)->whereDate('date', $today)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah melakukan absensi hari ini'
            ]);
        }

        // Pengajuan approved hari ini?
        $pengajuan = Pengajuan::where('user_id', $user->id)
            ->whereDate('date', $today)  // pastikan field date di pengajuan benar
            ->where('status', 'approved')
            ->first();

        if ($pengajuan) {
            return response()->json([
                'success' => false,
                'message' => 'Anda memiliki pengajuan ' . ucfirst($pengajuan->type)
            ]);
        }

        // Jadwal?
        $schedule = $this->getTodaySchedule($user);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada jadwal kerja hari ini'
            ]);
        }

        return response()->json([
            'success' => true,
            'schedule' => [
                'start_time' => $schedule->start_time,
                'end_time'   => $schedule->end_time ?? null,
                'is_fulltime' => $schedule->is_fulltime ?? false,
            ]
        ]);
    }

    /* =====================================================
     |  HELPER JADWAL
     ===================================================== */
    private function getTodaySchedule(User $user)
    {
        $day = now()->dayOfWeekIso; // 1 - 7

        return $user->schedules()
            ->whereJsonContains('day', $day)
            ->first();
    }

    /* =====================================================
     |  ADMIN AREA
     ===================================================== */
    public function index(Request $request)
    {
        $filters = $request->only(['date', 'user_id', 'status']);
        $data = $this->attendanceService->getAttendances($filters);

        return view('admin.attendance.index', [
            'attendances' => $data['attendances'],
            'users' => User::select('id', 'name')->get(),
        ]);
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);

        if ($attendance->photo_path) {
            Storage::disk('public')->delete($attendance->photo_path);
        }

        $attendance->delete();

        return back()->with('success', 'Absensi berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new \App\Exports\AttendanceExport, 'attendance.xlsx');
    }

    public function download($date)
    {
        $attendances = Attendance::with('user.department')
            ->whereDate('date', $date)
            ->orderBy('check_in')
            ->get();

        $pdf = Pdf::loadView('reports.attendance_pdf', compact('attendances', 'date'));

        return $pdf->download("attendance_{$date}.pdf");
    }
    /**
     * Halaman riwayat absensi karyawan sendiri
     */
    public function myAttendance(Request $request)
    {
        $user = Auth::user();

        // Query absensi user yang login
        $query = Attendance::with('schedule', 'attendanceLocation')
            ->where('user_id', $user->id)
            ->orderByDesc('date');

        // Filter tanggal jika ada
        if ($request->filled('month')) {
            $query->whereMonth('date', substr($request->month, 5, 2))
                ->whereYear('date', substr($request->month, 0, 4));
        }

        $attendances = $query->paginate(15);

        // Hitung statistik bulan ini
        $currentMonth = now()->format('Y-m');
        $stats = Attendance::where('user_id', $user->id)
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('my', compact('attendances', 'stats'));
    }
    public function locations()
    {
        $locations = AttendanceLocation::paginate(10);

        return view('admin.locations.index', compact('locations'));
    }
}
