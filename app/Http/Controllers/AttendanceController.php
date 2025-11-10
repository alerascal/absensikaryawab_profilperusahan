<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceLocation;
use App\Models\Schedule;
use Illuminate\Support\Facades\Storage;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Exports\MyAttendanceExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\AttendanceService;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    protected $attendanceService;

    public function __construct(AttendanceService $attendanceService)
    {
        $this->attendanceService = $attendanceService;
        $this->middleware('auth');

        // hanya admin
        $this->middleware('role:admin')->only([
            'index',
            'store',
            'update',
            'destroy',
            'destroyAll',
            'locations',
            'createLocation',
            'storeLocation',
            'editLocation',
            'updateLocation',
            'destroyLocation',
            'export'
        ]);

        // rate limiting untuk API absensi kamera
        $this->middleware('throttle:60,1')->only('cameraAttendance');
    }

    // ================== CAMERA ==================
    public function attendanceCameraPage()
    {
        $attendanceLocations = AttendanceLocation::where('is_active', 1)->get();

        if ($attendanceLocations->isEmpty()) {
            return redirect()->back()->with('error', 'Belum ada lokasi absensi yang tersedia.');
        }

        return view('camera', compact('attendanceLocations'));
    }

    public function cameraAttendance(Request $request)
    {
        $result = $this->attendanceService->handleCameraAttendance($request);

        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 422));
    }

    // ================== ADMIN ==================
    public function index(Request $request)
    {
        $filters = $request->only(['date', 'user_id', 'status']);
        $data = $this->attendanceService->getAttendances($filters);
        $users = User::select('id', 'name')->get();

        return view('admin.attendance.index', [
            'attendances' => $data['attendances'],
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $today = now()->toDateString();
        $now = Carbon::now();

        // Cek duplikat absen
        if (Attendance::where('user_id', $user->id)->whereDate('date', $today)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah absen hari ini',
            ], 422);
        }

        // Cari jadwal
        $schedule = Schedule::whereHas('users', fn($q) => $q->where('user_id', $user->id))
            ->where('day', $now->dayOfWeekIso) // Senin = 1, Minggu = 7
            ->first();

        $status = 'Absen'; // default

        if ($request->boolean('wfh')) {
            $status = 'WFH';
        } elseif ($schedule) {
            $start = Carbon::parse($schedule->start_time);
            $end   = Carbon::parse($schedule->end_time);
            $toleransi = $start->copy()->addMinutes(15);

            if ($now->lessThanOrEqualTo($start)) {
                $status = 'Hadir';
            } elseif ($now->lessThanOrEqualTo($toleransi)) {
                $status = 'Terlambat';
            } elseif ($now->greaterThan($end)) {
                $status = 'Absen';
            }
        }

        // simpan absensi
        $attendance = Attendance::create([
            'user_id'   => $user->id,
            'schedule_id' => $schedule?->id,
            'attendance_location_id' => $request->attendance_location_id ?? null,
            'check_in'  => $now->format('H:i:s'),
            'date'      => $today,
            'status'    => $status,
            'location'  => $request->location ?? 'Tidak diketahui',
            'photo_path' => $request->photo_path ?? null,
            'latitude'  => $request->latitude ?? '0',
            'longitude' => $request->longitude ?? '0',
            'accuracy'  => $request->accuracy ?? '0',
            'gps_accuracy' => $request->gps_accuracy ?? '-',
            'distance_to_location' => $request->distance ?? '0',
            'altitude' => $request->altitude ?? '-',
            'heading'  => $request->heading ?? '-',
            'speed'    => $request->speed ?? '-',
            'notes'    => $request->notes ?? '-',
        ]);

        return response()->json([
            'success' => true,
            'message' => "Absensi berhasil dengan status: $status",
            'attendance' => $attendance,
        ]);
    }

    public function show($id)
    {
        $attendance = Attendance::with(['user', 'attendanceLocation'])->findOrFail($id);
        return view('admin.attendance.show', compact('attendance'));
    }

    public function photo($id)
    {
        $attendance = Attendance::findOrFail($id);

        if (!$attendance->photo_path || !Storage::disk('public')->exists($attendance->photo_path)) {
            abort(404, 'Foto absensi tidak ditemukan.');
        }

        return response()->file(storage_path('app/public/' . $attendance->photo_path));
    }
    public function checkSchedule(Request $request)
    {
        $user = $request->user()->load(['schedules.shift']);
        $today = now()->toDateString();
        $now = now();
        $dayOfWeek = $now->isoWeekday(); // 1 = Senin ... 7 = Minggu

        Log::info("Cek jadwal untuk user {$user->name} pada hari ke-{$dayOfWeek}");

        // ===== CEK LIBUR NASIONAL =====
        if (method_exists($this, 'attendanceService') && $this->attendanceService->isHoliday($today)) {
            return response()->json([
                'success' => false,
                'message' => 'Hari ini adalah hari libur. Absensi tidak diperlukan.',
            ]);
        }

        // ===== CEK JADWAL HARI INI =====
        $schedule = $user->schedules()
            ->whereJsonContains('day', $dayOfWeek)
            ->with('shift')
            ->first();

        // ===== Jika tidak ada jadwal untuk hari ini =====
        if (!$schedule) {
            Log::warning("Tidak ditemukan jadwal berdasarkan hari untuk {$user->name}. Coba cari jadwal shift...");

            // Coba cari jadwal shift user
            $schedule = $user->schedules()
                ->where('is_fulltime', false)
                ->whereHas('shift')
                ->with('shift')
                ->first();
        }

        // ===== Jika tetap tidak ada =====
        if (!$schedule) {
            Log::error("User {$user->name} tidak memiliki jadwal apapun.");

            // Cek apakah user fulltime (bisa pakai kolom employment_status / shift_type)
            if (strtolower($user->employment_status ?? '') === 'full-time') {
                // fallback jadwal default
                $schedule = (object) [
                    'id' => null,
                    'start_time' => '07:00:00',
                    'end_time' => '16:00:00',
                    'is_fulltime' => true,
                    'shift' => null,
                ];
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada jadwal untuk hari ini. Hubungi admin.',
                ], 422);
            }
        }

        // ===== Ambil jam kerja dari jadwal atau shift =====
        $start = $schedule->start_time
            ?? optional($schedule->shift)->start_time
            ?? '07:00:00';

        $end = $schedule->end_time
            ?? optional($schedule->shift)->end_time
            ?? '16:00:00';

        // ===== RETURN BERHASIL =====
        return response()->json([
            'success' => true,
            'message' => 'Jadwal ditemukan',
            'schedule' => [
                'id' => $schedule->id ?? null,
                'start_time' => $start,
                'end_time' => $end,
                'is_fulltime' => $schedule->is_fulltime ?? false,
                'type' => ($schedule->is_fulltime ?? false) ? 'Fulltime' : 'Shift',
                'days' => $schedule->day ?? [],
            ],
        ]);
    }
    public function myAttendance(Request $request)
    {
        $query = Attendance::with(['attendanceLocation'])
            ->where('user_id', auth()->id());

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('month')) {
            $query->whereMonth('date', \Carbon\Carbon::parse($request->month)->month)
                ->whereYear('date', \Carbon\Carbon::parse($request->month)->year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);


        return view('pegawai.attendance.index', compact('attendances'));
    }

    public function myAttendanceExport(Request $request, $type)
    {
        $query = Attendance::with(['attendanceLocation'])
            ->where('user_id', auth()->id());

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        if ($request->filled('month')) {
            $query->whereMonth('date', \Carbon\Carbon::parse($request->month)->month)
                ->whereYear('date', \Carbon\Carbon::parse($request->month)->year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->get();

        if ($type === 'pdf') {
            $pdf = Pdf::loadView('pegawai.attendance.pdf', compact('attendances'));
            return $pdf->download('riwayat_absensi.pdf');
        } elseif ($type === 'excel') {
            return Excel::download(new MyAttendanceExport($attendances), 'riwayat_absensi.xlsx');
        }

        abort(404);
    }

    // ================== LOKASI ==================
    public function locations(Request $request)
    {
        $locations = $this->attendanceService->locationService->getLocations($request)['locations'];
        return view('admin.locations.index', compact('locations'));
    }

    public function createLocation()
    {
        return view('admin.locations.create');
    }

    public function storeLocation(Request $request)
    {
        $result = $this->attendanceService->locationService->createLocation($request);

        return $result['success']
            ? redirect()->route('admin.locations.index')->with('success', $result['message'])
            : back()->withErrors($result['errors'])->withInput();
    }

    public function editLocation($id)
    {
        $location = $this->attendanceService->locationService->getLocationById($id);
        return view('admin.locations.edit', compact('location'));
    }

    public function updateLocation(Request $request, $id)
    {
        $result = $this->attendanceService->locationService->updateLocation($request, $id);

        return $result['success']
            ? redirect()->route('admin.locations.index')->with('success', $result['message'])
            : back()->withErrors($result['errors'])->withInput();
    }

    public function destroyLocation($id)
    {
        $result = $this->attendanceService->locationService->deleteLocation($id);
        return redirect()->route('admin.locations.index')->with($result['type'], $result['message']);
    }

    public function checkLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'accuracy' => 'required|numeric',
        ]);

        try {
            $locationService = app(\App\Services\LocationService::class);
            $results = $locationService->validateLocation(
                $request->latitude,
                $request->longitude,
                $request->accuracy
            );

            return response()->json([
                'success' => true,
                'results' => $results,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ================== EXPORT & DELETE ==================
    public function export()
    {
        return Excel::download(new AttendanceExport, 'attendances.xlsx');
    }

    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);

        if ($attendance->photo_path && Storage::disk('public')->exists($attendance->photo_path)) {
            Storage::disk('public')->delete($attendance->photo_path);
        }

        $attendance->delete();

        return redirect()->route('admin.attendance.index')->with('success', 'Absensi berhasil dihapus.');
    }
    public function downloadPdf($date)
    {
        return app(\App\Services\AttendanceReportService::class)->downloadAttendancePdf($date);
    }
    public function download(Request $request, $date)
    {
        // Validasi tanggal
        $validated = $request->validate([
            'date' => 'nullable|date',
        ]);

        // Gunakan tanggal yang diberikan atau default ke hari ini
        $date = $date ?? Carbon::today()->toDateString();

        // Ambil data kehadiran
        $attendances = Attendance::with('user.department')
            ->whereDate('date', $date)
            ->orderBy('check_in', 'asc')
            ->get();

        // Generate PDF
        $pdf = Pdf::loadView('reports.attendance_pdf', compact('attendances', 'date'));

        // Unduh PDF
        return $pdf->download('attendance_report_' . $date . '.pdf');
    }
}
