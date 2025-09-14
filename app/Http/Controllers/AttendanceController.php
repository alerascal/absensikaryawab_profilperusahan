<?php

namespace App\Http\Controllers;

use App\Services\AttendanceService;
use App\Services\LocationService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\AttendanceLocation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $attendanceService;
    protected $locationService;

    public function __construct(
        AttendanceService $attendanceService,
        LocationService $locationService
    ) {
        $this->middleware('auth');
        $this->middleware('role:admin')->only([
            'store',
            'update',
            'destroy',
            'destroyAll',
            'locations',
            'createLocation',
            'storeLocation',
            'editLocation',
            'updateLocation',
            'destroyLocation'
        ]);

        $this->attendanceService = $attendanceService;
        $this->locationService = $locationService;
    }

    public function attendanceCameraPage()
    {
        return view('camera');
    }

    public function cameraAttendance(Request $request)
    {
        // Force JSON response
        $request->headers->set('Accept', 'application/json');

        Log::info('Camera attendance request:', [
            'user_id' => $request->user()?->id,
            'has_photo' => $request->hasFile('photo'),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,
        ]);

        // Validate user
        if (!$request->user()) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak login. Silakan login terlebih dahulu.',
            ], 401);
        }

        // Validation
        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'required|numeric|min:0|max:10000',
            'altitude' => 'nullable|numeric|between:-1000,10000',
            'heading' => 'nullable|numeric|min:0|max:360',
            'speed' => 'nullable|numeric|min:0|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Check if already attended today
            $today = Carbon::now()->toDateString();
            $existingAttendance = Attendance::where('user_id', $request->user()->id)
                ->whereDate('date', $today)
                ->first();

            if ($existingAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan absensi hari ini.',
                ], 422);
            }

            // Store photo
            $file = $request->file('photo');
            $filename = 'attendance_' . $request->user()->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $photoPath = $file->storeAs('attendance/' . date('Y/m'), $filename, 'public');

            // Check location (but allow attendance even if not in valid location)
            $locations = AttendanceLocation::all();
            $locationValidation = $this->checkLocationFlexible(
                $request->latitude,
                $request->longitude,
                $request->accuracy,
                $locations
            );

            // Determine status based on time and location
            $status = $this->determineAttendanceStatus($locationValidation['is_valid']);

            // Create attendance record
            $attendanceData = [
                'user_id' => $request->user()->id,
                'schedule_id' => null, // You can implement schedule logic here
                'attendance_location_id' => $locationValidation['best_match']?->id,
                'date' => $today,
                'check_in' => Carbon::now()->format('H:i:s'),
                'status' => $status,
                'location' => $locationValidation['best_match']?->name ?? 'Lokasi Tidak Dikenal',
                'photo_path' => $photoPath,
            ];

            $attendance = Attendance::create($attendanceData);

            // Prepare response message
            $message = 'Absensi berhasil dicatat!';
            if (!$locationValidation['is_valid']) {
                $message .= ' Catatan: Anda berada di luar area yang ditentukan.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $attendance,
                'location_info' => [
                    'is_valid_location' => $locationValidation['is_valid'],
                    'distance_to_nearest' => $locationValidation['min_distance'],
                    'accuracy' => $request->accuracy,
                    'location_name' => $locationValidation['best_match']?->name ?? 'Tidak dikenal'
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Camera attendance error:', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi error sistem. Silakan coba lagi.',
                'error_detail' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Check location but allow attendance even if not in valid area
     */
    private function checkLocationFlexible($latitude, $longitude, $accuracy, $locations)
    {
        $bestMatch = null;
        $minDistance = PHP_FLOAT_MAX;
        $isValid = false;

        foreach ($locations as $location) {
            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $location->latitude,
                $location->longitude
            );

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $bestMatch = $location;
            }

            // Check if within valid range (with accuracy buffer)
            $allowedRadius = $location->radius + ($accuracy * 0.5); // Add accuracy buffer
            if ($distance <= $allowedRadius) {
                $isValid = true;
            }
        }

        return [
            'is_valid' => $isValid,
            'best_match' => $bestMatch,
            'min_distance' => $minDistance,
        ];
    }

    /**
     * Calculate distance between two coordinates
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($dLon / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    /**
     * Determine attendance status
     */
    private function determineAttendanceStatus($isValidLocation)
    {
        $currentTime = Carbon::now();
        $workStartTime = Carbon::createFromTime(8, 0); // 08:00

        if ($currentTime->lt($workStartTime)) {
            return 'Hadir'; // Early
        } elseif ($currentTime->diffInMinutes($workStartTime) <= 15) {
            return 'Hadir'; // On time
        } elseif ($currentTime->diffInMinutes($workStartTime) <= 60) {
            return 'Terlambat'; // Late
        } else {
            return 'Absen'; // Very late or absent
        }
    }

    // Other methods remain the same...
    public function index(Request $request)
    {
        $query = Attendance::with(['user', 'attendanceLocation']);

        // Apply filters
        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(15);
        $users = User::select('id', 'name')->get();

        return view('admin.attendance.index', compact('attendances', 'users'));
    }
    public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'date'    => 'required|date',
        'status'  => 'required|string|in:Hadir,Terlambat,Absen,WFH,Sakit,Izin',
        'notes'   => 'nullable|string',
    ]);

    $attendance = Attendance::create($validated);

    return response()->json([
        'success' => true,
        'data'    => $attendance,
    ]);
}


    public function show($id)
    {
        $attendance = Attendance::with(['user', 'attendanceLocation'])->findOrFail($id);
        return view('admin.attendance.show', compact('attendance'));
    }

    public function showPhoto($id)
    {
        $attendance = Attendance::findOrFail($id);

        if (!$attendance->photo_path) {
            abort(404, 'Foto tidak ditemukan');
        }

        $path = storage_path('app/public/' . $attendance->photo_path);

        if (!file_exists($path)) {
            abort(404, 'File foto tidak ditemukan');
        }

        return response()->file($path);
    }

    public function myAttendance(Request $request)
    {
        $attendances = Attendance::with(['attendanceLocation'])
            ->where('user_id', auth()->id())
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('pegawai.attendance.index', compact('attendances'));
    }

    // Location management methods
    public function locations(Request $request)
    {
        $query = AttendanceLocation::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $locations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.locations.index', compact('locations'));
    }

    public function createLocation()
    {
        return view('admin.locations.create');
    }

    public function storeLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attendance_locations,name',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:50|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        AttendanceLocation::create($validator->validated());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil ditambahkan!');
    }

    public function editLocation($id)
    {
        $location = AttendanceLocation::findOrFail($id);
        return view('admin.locations.edit', compact('location'));
    }

    public function updateLocation(Request $request, $id)
    {
        $location = AttendanceLocation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attendance_locations,name,' . $id,
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:50|max:1000',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $location->update($validator->validated());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil diperbarui!');
    }

    public function destroyLocation($id)
    {
        $location = AttendanceLocation::findOrFail($id);

        // Check if location is used in any attendance
        $attendanceCount = Attendance::where('attendance_location_id', $id)->count();

        if ($attendanceCount > 0) {
            return redirect()->route('admin.locations.index')
                ->with('warning', "Tidak dapat menghapus lokasi '{$location->name}' karena masih digunakan dalam {$attendanceCount} record absensi.");
        }

        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi berhasil dihapus!');
    }
    public function export()
    {
        return Excel::download(new AttendanceExport, 'attendances.xlsx');
    }
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }
    public function photo($id)
    {
        $attendance = Attendance::findOrFail($id);

        if (!$attendance->photo_path || !\Storage::exists($attendance->photo_path)) {
            abort(404, 'Foto absensi tidak ditemukan.');
        }

        return response()->file(storage_path('app/' . $attendance->photo_path));
    }
}
