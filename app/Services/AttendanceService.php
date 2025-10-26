<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Pengajuan;
use App\Models\AttendanceLocation;
use App\Traits\LocationValidationTrait;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttendanceService
{
    use LocationValidationTrait;

    public $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    /**
     * Ambil semua data absensi dengan filter
     */
    public function getAttendances($filters = [])
    {
        $query = Attendance::with(['user' => fn($q) => $q->select('id', 'name')]);

        if (!empty($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }
        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        return [
            'attendances' => $attendances,
            'totalData'   => $query->count()
        ];
    }

    /**
     * Buat absensi manual (admin)
     */
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
     * Update absensi
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
     * Hapus absensi by ID
     */
    public function deleteAttendance($id): array
    {
        $attendance = Attendance::find($id);

        if (!$attendance) {
            return ['success' => false, 'message' => 'Data absensi tidak ditemukan'];
        }

        // Hapus foto jika ada
        if ($attendance->photo_path && Storage::disk('public')->exists($attendance->photo_path)) {
            Storage::disk('public')->delete($attendance->photo_path);
        }

        $attendance->delete();

        return [
            'success' => true,
            'message' => 'Absensi berhasil dihapus',
        ];
    }

    /**
     * Ambil absensi berdasarkan ID
     */
    public function getAttendanceById($id): ?Attendance
    {
        return Attendance::with('user')->find($id);
    }

    /**
     * Data dashboard pegawai
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
     * Hitung absensi hari ini
     */
    public function getTodayAttendanceCount(): int
    {
        return Attendance::whereDate('date', today())->count();
    }

    /**
     * Hitung jumlah schedule
     */
    public function getScheduleCount(): int
    {
        return Schedule::count();
    }

    /**
     * Tentukan status absensi berdasarkan keterlambatan
     */
    protected function determineAttendanceStatus($lateMinutes, $isCamera = false): string
    {
        if ($isCamera) {
            if ($lateMinutes < 15) {
                return 'Hadir';
            } elseif ($lateMinutes >= 15 && $lateMinutes <= 30) {
                return 'Terlambat';
            } else {
                return 'Absen';
            }
        }
        return 'Hadir'; // Default untuk absensi non-kamera
    }

    public function handleCameraAttendance(Request $request)
    {
        try {
            $user = $request->user()->load(['department', 'schedules.shift']);
            $today = Carbon::now()->toDateString();
            $now = Carbon::now();
            $dayNumber = $now->dayOfWeekIso; // 1 = Senin ... 7 = Minggu

            // ===== CEK LIBUR =====
            if (Holiday::whereDate('date', $today)->exists()) {
                return ['success' => false, 'message' => 'Hari ini libur nasional.', 'status' => 422];
            }

            // ===== CEK JADWAL HARI INI =====
            $schedule = $user->schedules()
                ->whereJsonContains('day', $dayNumber)
                ->first();

            // Jika tidak ada jadwal, cek apakah user punya jadwal shift aktif
            if (!$schedule) {
                $schedule = $user->schedules()
                    ->where('is_fulltime', false)
                    ->whereHas('shift', function ($q) use ($now) {
                        $q->whereTime('start_time', '<=', $now->format('H:i:s'))
                            ->whereTime('end_time', '>=', $now->format('H:i:s'));
                    })
                    ->first();
            }

            // Jika tetap tidak ada jadwal
            if (!$schedule) {
                if (isset($user->shift_type) && strtolower($user->shift_type) === 'fulltime') {
                    // fallback default untuk fulltime
                    $schedule = (object)[
                        'id' => null,
                        'start_time' => '07:00:00',
                        'end_time' => '16:00:00',
                        'is_fulltime' => true,
                    ];
                } else {
                    return ['success' => false, 'message' => 'Tidak ada jadwal untuk hari ini.', 'status' => 422];
                }
            }

            // ===== VALIDASI FOTO & LOKASI =====
            $validator = Validator::make($request->all(), [
                'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'accuracy' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return ['success' => false, 'message' => $validator->errors()->first(), 'status' => 422];
            }

            // ===== CEK SUDAH ABSEN =====
            if (Attendance::where('user_id', $user->id)->whereDate('date', $today)->exists()) {
                return ['success' => false, 'message' => 'Anda sudah absen hari ini.', 'status' => 422];
            }

            // ===== CEK LOKASI TERDAFTAR (attendance_locations) =====
            $latitude = $request->latitude;
            $longitude = $request->longitude;

            $locations = AttendanceLocation::all();
            $foundLocation = null;

            foreach ($locations as $loc) {
                $distance = $this->calculateDistance($latitude, $longitude, $loc->latitude, $loc->longitude);
                if ($distance <= $loc->radius) {
                    $foundLocation = $loc;
                    break;
                }
            }

            if (!$foundLocation) {
                return [
                    'success' => false,
                    'message' => 'Anda berada di luar area lokasi absen yang diizinkan.',
                    'status' => 422,
                ];
            }

            // ===== SIMPAN FOTO =====
            $photoPath = $request->file('photo')->store('attendance_photos', 'public');

            // ===== LOGIKA JAM MASUK DAN STATUS =====
            $start = Carbon::parse($schedule->start_time);
            $end = Carbon::parse($schedule->end_time);
            $lateMinutes = $start->diffInMinutes($now, false);
            $status = $lateMinutes > 10 ? 'Terlambat' : 'Hadir';

            // ===== SIMPAN ABSENSI =====
            $attendance = Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'check_in' => $now->format('H:i:s'),
                'check_out' => null,
                'status' => $status,
                'photo_path' => $photoPath,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'accuracy' => $request->accuracy,
                'schedule_id' => $schedule->id,
                'attendance_location_id' => $foundLocation->id, // SIMPAN lokasi terdeteksi
            ]);

            Log::info('ABSEN KAMERA BERHASIL', [
                'user_id' => $user->id,
                'status' => $status,
                'hari' => $dayNumber,
                'lokasi' => $foundLocation->name,
                'schedule' => $schedule,
            ]);

            return [
                'success' => true,
                'message' => 'Absensi berhasil disimpan di lokasi: ' . $foundLocation->name . ' (Status: ' . $status . ')',
                'attendance' => $attendance,
            ];
        } catch (\Exception $e) {
            Log::error('Error absensi kamera: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return ['success' => false, 'message' => 'Kesalahan sistem: ' . $e->getMessage(), 'status' => 500];
        }
    }

    /**
     * Hitung jarak antar dua titik koordinat (dalam meter)
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $earthRadius * $angle;
    }
    /**
     * Ambil jadwal user untuk hari ini dengan berbagai format
     */
    protected function getUserScheduleForToday($user)
    {
        $now = Carbon::now();
        $dayOfWeekIso = $now->dayOfWeekIso; // 1=Senin, 7=Minggu
        $dayNameIndonesia = $this->getDayNameIndonesia($now);
        $dayNameEnglish = $now->format('l'); // Monday, Tuesday, etc.

        Log::info('Mencari jadwal dengan berbagai format', [
            'user_id' => $user->id,
            'dayOfWeekIso' => $dayOfWeekIso,
            'dayNameIndonesia' => $dayNameIndonesia,
            'dayNameEnglish' => $dayNameEnglish,
        ]);

        $schedules = $user->schedules ?? collect();

        // Coba berbagai format
        $schedule = $schedules->first(function ($sch) use ($dayOfWeekIso, $dayNameIndonesia, $dayNameEnglish) {
            // Format 1: field day berisi angka (1-7)
            if (is_numeric($sch->day) && $sch->day == $dayOfWeekIso) {
                return true;
            }

            // Format 2: field day berisi nama hari Indonesia
            if (is_string($sch->day) && strtolower($sch->day) === strtolower($dayNameIndonesia)) {
                return true;
            }

            // Format 3: field day berisi nama hari English
            if (is_string($sch->day) && strtolower($sch->day) === strtolower($dayNameEnglish)) {
                return true;
            }

            // Format 4: field day berisi array JSON
            if (is_array($sch->day)) {
                return in_array($dayNameIndonesia, $sch->day) ||
                    in_array($dayNameEnglish, $sch->day) ||
                    in_array($dayOfWeekIso, $sch->day);
            }

            // Format 5: field day berisi JSON string
            if (is_string($sch->day) && $this->isJson($sch->day)) {
                $dayArray = json_decode($sch->day, true);
                return in_array($dayNameIndonesia, $dayArray) ||
                    in_array($dayNameEnglish, $dayArray) ||
                    in_array($dayOfWeekIso, $dayArray);
            }

            return false;
        });

        if ($schedule) {
            Log::info('Jadwal ditemukan', [
                'schedule_id' => $schedule->id,
                'day_value' => $schedule->day,
            ]);
        }

        return $schedule;
    }

    /**
     * Konversi Carbon ke nama hari dalam Bahasa Indonesia
     */
    protected function getDayNameIndonesia($date)
    {
        $mapHari = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $mapHari[$date->format('l')] ?? null;
    }

    /**
     * Check if string is valid JSON
     */
    protected function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Cek hari libur
     */
    public function isHoliday($date)
    {
        $carbonDate = Carbon::parse($date);

        // Cek libur mingguan (misalnya setiap Jumat, Sabtu, Minggu)
        $isWeeklyHoliday = Holiday::where('day_of_week', $carbonDate->dayOfWeekIso)->exists();

        // Cek libur berdasarkan tanggal tertentu (misal 17 Agustus, 1 Januari)
        $isDateHoliday = Holiday::whereDate('date', $carbonDate->toDateString())->exists();

        return $isWeeklyHoliday || $isDateHoliday;
    }

    /**
     * Validate attendance location using consolidated method
     */
    public function validateAttendanceLocation($latitude, $longitude, $accuracy)
    {
        $locations = $this->locationService->getCachedLocations();
        return $this->validateLocation($latitude, $longitude, $accuracy, $locations);
    }

    /**
     * Get attendance statistics
     */
    public function getAttendanceStatistics($userId = null, $dateRange = null)
    {
        $query = Attendance::query();

        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($dateRange && isset($dateRange['start'], $dateRange['end'])) {
            $query->whereBetween('date', [$dateRange['start'], $dateRange['end']]);
        }

        $total = $query->count();
        $hadir = $query->where('status', 'Hadir')->count();
        $terlambat = $query->where('status', 'Terlambat')->count();
        $absen = $query->where('status', 'Absen')->count();
        $wfh = $query->where('status', 'WFH')->count();

        return [
            'total' => $total,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'absen' => $absen,
            'wfh' => $wfh,
            'percentage' => [
                'hadir' => $total > 0 ? round(($hadir / $total) * 100, 2) : 0,
                'terlambat' => $total > 0 ? round(($terlambat / $total) * 100, 2) : 0,
                'absen' => $total > 0 ? round(($absen / $total) * 100, 2) : 0,
                'wfh' => $total > 0 ? round(($wfh / $total) * 100, 2) : 0,
            ]
        ];
    }

    /**
     * Get recent attendances for user
     */
    public function getRecentAttendances($userId, $limit = 10)
    {
        return Attendance::with(['user', 'schedule'])
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->orderBy('check_in', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($attendance) {
                return [
                    'id' => $attendance->id,
                    'date' => $attendance->date,
                    'check_in' => $attendance->check_in,
                    'status' => $attendance->status,
                    'location' => $attendance->location,
                    'notes' => $attendance->notes,
                    'photo_url' => $attendance->photo_path ? Storage::url($attendance->photo_path) : null,
                ];
            });
    }

    /**
     * Bulk create attendances (for admin)
     */
    public function bulkCreateAttendances($attendancesData)
    {
        try {
            $created = [];
            $errors = [];

            foreach ($attendancesData as $index => $data) {
                $validator = Validator::make($data, [
                    'user_id' => 'required|exists:users,id',
                    'date' => 'required|date',
                    'status' => 'required|in:Hadir,Terlambat,Absen,WFH',
                    'notes' => 'nullable|string|max:255',
                ]);

                if ($validator->fails()) {
                    $errors[] = [
                        'index' => $index,
                        'data' => $data,
                        'errors' => $validator->errors()
                    ];
                    continue;
                }

                // Check if attendance already exists
                $existing = Attendance::where('user_id', $data['user_id'])
                    ->whereDate('date', $data['date'])
                    ->first();

                if ($existing) {
                    $errors[] = [
                        'index' => $index,
                        'data' => $data,
                        'errors' => ['duplicate' => 'Attendance already exists for this user on this date']
                    ];
                    continue;
                }

                $attendance = Attendance::create($validator->validated());
                $created[] = $attendance;
            }

            return [
                'success' => true,
                'created' => count($created),
                'errors' => count($errors),
                'created_attendances' => $created,
                'error_details' => $errors,
                'message' => count($created) . ' attendances created successfully' .
                    (count($errors) > 0 ? ', ' . count($errors) . ' failed' : '')
            ];
        } catch (\Exception $e) {
            Log::error('Bulk attendance creation error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error creating bulk attendances: ' . $e->getMessage()
            ];
        }
    }
}
