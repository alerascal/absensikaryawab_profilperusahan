<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use App\Traits\LocationValidationTrait;
use App\Http\Resources\AttendanceResource;
use App\Events\AttendanceCreated;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AttendanceService
{
    use LocationValidationTrait;

    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Ambil semua data absensi.
     */
    public function getAttendances($filters = [])
    {
        $query = Attendance::with('user');

        if (!empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Ganti ->get() menjadi ->paginate()
        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        return [
            'attendances' => $attendances,
            'totalData'   => $query->count() // total seluruh data sesuai filter
        ];
    }

    public function createManualAttendance(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
            'date'      => 'required|date',
            'status'    => 'required|in:Hadir,Terlambat,Absen,WFH',
            'notes'     => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors'  => $validator->errors(),
                'message' => 'Validasi gagal',
            ];
        }

        $attendance = Attendance::create($validator->validated());

        return [
            'success' => true,
            'data'    => $attendance,
            'message' => 'Absensi manual berhasil ditambahkan',
        ];
    }

    /**
     * Update absensi.
     */
    public function updateAttendance(Request $request, $id): array
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return ['success' => false, 'message' => 'Data absensi tidak ditemukan'];
        }

        $attendance->update($request->only(['status', 'notes', 'date']));

        return [
            'success' => true,
            'data'    => $attendance,
            'message' => 'Absensi berhasil diperbarui',
        ];
    }

    /**
     * Hapus absensi by ID.
     */
    public function deleteAttendance($id): array
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return ['success' => false, 'message' => 'Data absensi tidak ditemukan'];
        }

        $attendance->delete();

        return [
            'success' => true,
            'message' => 'Absensi berhasil dihapus',
        ];
    }

    /**
     * Hapus semua absensi.
     */
    public function destroyAllAttendances(Request $request): array
    {
        Attendance::truncate();

        return [
            'success' => true,
            'type'    => 'success',
            'message' => 'Semua data absensi berhasil dihapus',
        ];
    }

    /**
     * Ambil absensi berdasarkan ID.
     */
    public function getAttendanceById($id): ?Attendance
    {
        return Attendance::with('user')->find($id);
    }

    public function showAttendancePhoto($id)
    {
        $attendance = Attendance::find($id);

        if (!$attendance || !$attendance->photo) {
            abort(404, 'Foto absensi tidak ditemukan.');
        }

        return response()->file(storage_path('app/public/' . $attendance->photo));
    }

    /**
     * Data dashboard pegawai (statistik absensi user).
     */
    public function getPegawaiDashboardData(User $user): array
    {
        $today = Carbon::today();

        $total = $user->attendances()->count();
        $hadir = $user->attendances()->where('status', 'Hadir')->count();
        $terlambat = $user->attendances()->where('status', 'Terlambat')->count();
        $absen = $user->attendances()->where('status', 'Absen')->count();
        $todayStatus = $user->attendances()->whereDate('date', $today)->first();

        return [
            'total'        => $total,
            'hadir'        => $hadir,
            'terlambat'    => $terlambat,
            'absen'        => $absen,
            'todayStatus'  => $todayStatus?->status ?? 'Belum Absen',
        ];
    }

    /**
     * Ambil daftar absensi milik user.
     */
    public function getUserAttendances(Request $request, User $user): array
    {
        $attendances = $user->attendances()
            ->latest()
            ->paginate(10);

        return [
            'attendances' => $attendances,
        ];
    }

    /**
     * Ambil daftar semua user.
     */
    public function getUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        return $query->paginate(10);
    }

    /**
     * Hitung absensi hari ini.
     */
    public function getTodayAttendanceCount(): int
    {
        return Attendance::whereDate('date', today())->count();
    }

    /**
     * Hitung jumlah schedule.
     */
    public function getScheduleCount(): int
    {
        return Schedule::count();
    }

/**
 * Handle absensi via kamera + lokasi dengan GPS accuracy yang lebih baik.
 */
public function handleCameraAttendance(Request $request)
{
    try {
        // ==============================
        // 1. VALIDASI REQUEST
        // ==============================
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
            'photo'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy'  => 'required|numeric|min:0|max:10000',
        ]);

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ];
        }

        // ==============================
        // 2. SIMPAN FOTO
        // ==============================
        $file     = $request->file('photo');
        $filename = 'attendance_' . $request->user_id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('attendance/' . date('Y/m'), $filename, 'public');

        // ==============================
        // 3. PERSIAPAN DATA GPS
        // ==============================
        $latitude   = $request->latitude;
        $longitude  = $request->longitude;
        $accuracy   = $request->accuracy;
        $gpsQuality = $this->evaluateGpsQuality($accuracy);

        // ==============================
        // 4. CEK ABSENSI SEBELUMNYA
        // ==============================
        $today = Carbon::now()->toDateString();
        $existingAttendance = Attendance::where('user_id', $request->user_id)
            ->whereDate('date', $today)
            ->first();

        if ($existingAttendance) {
            return [
                'success' => false,
                'message' => 'Anda sudah melakukan absensi hari ini.',
            ];
        }

        // ==============================
        // 5. CEK LOKASI ABSENSI
        // ==============================
        $locations = $this->getCachedLocations();
        $validation = $this->locationService->checkLocationWithDynamicRadius(
            $latitude,
            $longitude,
            $locations,
            $accuracy
        );

        if (!$validation['success']) {
            return [
                'success' => false,
                'message' => 'Lokasi absensi tidak valid.',
                'tips'    => [
                    "Pindah ke area terbuka agar GPS lebih stabil",
                    "Aktifkan mode 'High Accuracy' di pengaturan lokasi",
                    "Refresh GPS atau tunggu beberapa detik sebelum mencoba lagi"
                ],
                'details' => $this->generateEnhancedLocationErrorMessage($validation, $accuracy),
            ];
        }

        // ==============================
        // 6. SIMPAN ABSENSI
        // ==============================
        $attendance = Attendance::create([
            'user_id'     => $request->user_id,
            'schedule_id' => $validation['schedule_id'] ?? null,
            'date'        => $today,
            'check_in'    => Carbon::now()->format('H:i:s'),
            'status'      => $validation['status'],
            'location_id' => $validation['best_match']->id ?? null,
            'location'    => $validation['best_match']->name ?? 'Unknown',
            'latitude'    => $latitude,
            'longitude'   => $longitude,
            'accuracy'    => $accuracy,
            'photo'       => $path,
        ]);

        // Trigger event untuk notifikasi/real-time
        event(new AttendanceCreated($attendance));

        return [
            'success'     => true,
            'message'     => 'Absensi berhasil dicatat.',
            'data'        => $attendance,
            'gps_quality' => $gpsQuality,
        ];
    } catch (\Exception $e) {
        Log::error('Camera attendance error', [
            'error'        => $e->getMessage(),
            'stack_trace'  => $e->getTraceAsString(),
            'request_data' => $request->all(),
        ]);

        return [
            'success' => false,
            'message' => 'Terjadi kesalahan saat memproses absensi.',
            'error'   => $e->getMessage(),
        ];
    }
}

/**
 * Evaluasi kualitas GPS berdasarkan akurasi
 */
private function evaluateGpsQuality($accuracy)
{
    if ($accuracy <= 5) {
        return ['level' => 'excellent', 'description' => 'Sangat Akurat', 'color' => 'green'];
    } elseif ($accuracy <= 10) {
        return ['level' => 'very_good', 'description' => 'Sangat Baik', 'color' => 'green'];
    } elseif ($accuracy <= 20) {
        return ['level' => 'good', 'description' => 'Baik', 'color' => 'blue'];
    } elseif ($accuracy <= 50) {
        return ['level' => 'fair', 'description' => 'Cukup', 'color' => 'yellow'];
    } elseif ($accuracy <= 100) {
        return ['level' => 'poor', 'description' => 'Kurang', 'color' => 'orange'];
    } else {
        return ['level' => 'very_poor', 'description' => 'Sangat Kurang', 'color' => 'red'];
    }
}

/**
 * Generate catatan GPS yang detail
 */
private function generateGpsNotes($accuracy, $locationValidation, $request)
{
    $gpsQuality = $this->evaluateGpsQuality($accuracy);
    $notes = "GPS: {$gpsQuality['description']} (±{$accuracy}m)";
    
    if ($locationValidation['best_match']) {
        $distance = round($locationValidation['min_distance'], 1);
        $notes .= " | Lokasi: {$locationValidation['best_match']->name} ({$distance}m)";
    }
    
    if ($request->altitude) {
        $notes .= " | Alt: " . round($request->altitude, 1) . "m";
    }
    
    return $notes;
}

/**
 * Generate pesan error lokasi yang lebih informatif
 */
private function generateEnhancedLocationErrorMessage($validation, $gpsAccuracy)
{
    $gpsQuality = $this->evaluateGpsQuality($gpsAccuracy);
    
    $message = "Anda berada di luar area absensi yang diizinkan.";
    
    if ($gpsAccuracy > 100) {
        $message .= " GPS Anda kurang akurat (±{$gpsAccuracy}m), coba pindah ke area terbuka.";
    }
    
    // Cari lokasi terdekat
    $nearestLocation = null;
    $minDistance = PHP_FLOAT_MAX;
    
    foreach ($validation['results'] as $result) {
        if ($result['distance'] < $minDistance) {
            $minDistance = $result['distance'];
            $nearestLocation = $result['location'];
        }
    }
    
    if ($nearestLocation && $minDistance <= 2000) { // dalam radius 2km
        $distanceKm = $minDistance > 1000 ? round($minDistance / 1000, 1) . "km" : round($minDistance) . "m";
        $message .= " Lokasi terdekat: {$nearestLocation->name} berjarak {$distanceKm} dari posisi Anda.";
    }
    
    return $message;
}
    /**
     * Generate pesan error lokasi.
     */
    private function generateLocationErrorMessage($validation)
    {
        $message = 'Anda berada di luar area absensi!';
        $nearbyLocations = array_filter($validation['results'], fn($result) => $result['distance'] <= ($result['base_radius'] + 1000));

        if (!empty($nearbyLocations)) {
            $nearest = array_reduce($nearbyLocations, fn($min, $loc) => $min === null || $loc['distance'] < $min['distance'] ? $loc : $min);
            $message .= " Lokasi terdekat: {$nearest['location']->name} ({$nearest['distance']}m dari Anda)";
        }

        return $message;
    }
}
