<?php

namespace App\Services;

use App\Models\AttendanceLocation;
use App\Models\Attendance;
use App\Traits\LocationValidationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class LocationService
{
    use LocationValidationTrait;

    public function getCachedLocations()
    {
        return Cache::remember('attendance_locations', 3600, function () {
            return AttendanceLocation::all();
        });
    }
    public function checkLocation($latitude, $longitude, $accuracy, $locations)
    {
        return $this->validateLocation($latitude, $longitude, $accuracy, $locations);
    }

    public function getLocations(Request $request)
    {
        $query = AttendanceLocation::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $locations = $query->paginate(10)->withQueryString();

        return compact('locations');
    }

    public function getLocationById($id)
    {
        $location = AttendanceLocation::findOrFail($id);
        $location->maps_link = "https://www.google.com/maps/@{$location->latitude},{$location->longitude},15z";
        return $location;
    }

    public function createLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attendance_locations,name',
            'maps_link' => 'required|url',
            'radius' => 'nullable|integer|min:50|max:1000',
        ], [
            'name.required' => 'Nama lokasi wajib diisi.',
            'name.unique' => 'Nama lokasi sudah digunakan.',
            'maps_link.required' => 'Link Google Maps wajib diisi.',
            'maps_link.url' => 'Link Google Maps tidak valid.',
            'radius.min' => 'Radius minimal 50 meter untuk akurasi GPS.',
            'radius.max' => 'Radius maksimal 1000 meter.',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $coordinates = $this->extractCoordinatesFromUrl($request->maps_link);
        if (!$coordinates) {
            return [
                'success' => false,
                'errors' => [
                    'maps_link' => 'Tidak dapat mengekstrak koordinat dari link Google Maps. Pastikan link valid dan mengandung koordinat.'
                ]
            ];
        }

        $existingLocation = AttendanceLocation::where(function ($query) use ($coordinates) {
            $query->whereBetween('latitude', [$coordinates['latitude'] - 0.0001, $coordinates['latitude'] + 0.0001])
                ->whereBetween('longitude', [$coordinates['longitude'] - 0.0001, $coordinates['longitude'] + 0.0001]);
        })->first();

        if ($existingLocation) {
            return [
                'success' => false,
                'errors' => [
                    'maps_link' => 'Sudah ada lokasi yang sangat dekat dengan koordinat ini: ' . $existingLocation->name
                ]
            ];
        }

        try {
            $location = AttendanceLocation::create([
                'name' => $request->name,
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
                'radius' => $request->radius ?? 200,
            ]);

            Cache::forget('attendance_locations');
            Log::info("Lokasi absensi baru ditambahkan: {$location->name} pada koordinat ({$coordinates['latitude']}, {$coordinates['longitude']})");

            return [
                'success' => true,
                'message' => 'Lokasi absensi berhasil ditambahkan!'
            ];
        } catch (\Exception $e) {
            Log::error('Error creating attendance location: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['error' => 'Gagal menambahkan lokasi. Silakan coba lagi.']
            ];
        }
    }

    public function updateLocation(Request $request, $id)
    {
        $location = AttendanceLocation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attendance_locations,name,' . $id,
            'maps_link' => 'required|url',
            'radius' => 'required|numeric|min:50|max:1000',
        ], [
            'name.required' => 'Nama lokasi wajib diisi.',
            'name.unique' => 'Nama lokasi sudah digunakan.',
            'maps_link.required' => 'Link Google Maps wajib diisi.',
            'maps_link.url' => 'Link Google Maps tidak valid.',
            'radius.required' => 'Radius wajib diisi.',
            'radius.min' => 'Radius minimal 50 meter untuk akurasi GPS.',
            'radius.max' => 'Radius maksimal 1000 meter.',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $coordinates = $this->extractCoordinatesFromUrl($request->maps_link);
        if (!$coordinates) {
            return [
                'success' => false,
                'errors' => [
                    'maps_link' => 'Tidak dapat mengekstrak koordinat dari link Google Maps. Pastikan link valid dan mengandung koordinat.'
                ]
            ];
        }

        $existingLocation = AttendanceLocation::where('id', '!=', $id)
            ->where(function ($query) use ($coordinates) {
                $query->whereBetween('latitude', [$coordinates['latitude'] - 0.0001, $coordinates['latitude'] + 0.0001])
                    ->whereBetween('longitude', [$coordinates['longitude'] - 0.0001, $coordinates['longitude'] + 0.0001]);
            })->first();

        if ($existingLocation) {
            return [
                'success' => false,
                'errors' => [
                    'maps_link' => 'Sudah ada lokasi yang sangat dekat dengan koordinat ini: ' . $existingLocation->name
                ]
            ];
        }

        try {
            $location->update([
                'name' => $request->name,
                'latitude' => $coordinates['latitude'],
                'longitude' => $coordinates['longitude'],
                'radius' => $request->radius,
            ]);

            Cache::forget('attendance_locations');
            Log::info("Lokasi absensi diperbarui: {$location->name} pada koordinat ({$coordinates['latitude']}, {$coordinates['longitude']})");

            return [
                'success' => true,
                'message' => 'Lokasi berhasil diperbarui.'
            ];
        } catch (\Exception $e) {
            Log::error('Error updating attendance location: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['error' => 'Gagal memperbarui lokasi. Silakan coba lagi.']
            ];
        }
    }

    public function deleteLocation($id)
    {
        try {
            $location = AttendanceLocation::findOrFail($id);
            $attendanceCount = Attendance::where('location', $location->name)->count();

            if ($attendanceCount > 0) {
                return [
                    'success' => false,
                    'type' => 'warning',
                    'message' => "Tidak dapat menghapus lokasi '{$location->name}' karena masih digunakan dalam {$attendanceCount} record absensi."
                ];
            }

            $locationName = $location->name;
            $location->delete();
            Cache::forget('attendance_locations');
            Log::info("Lokasi absensi dihapus: {$locationName}");

            return [
                'success' => true,
                'type' => 'success',
                'message' => "Lokasi '{$locationName}' berhasil dihapus!"
            ];
        } catch (\Exception $e) {
            Log::error('Error deleting attendance location: ' . $e->getMessage());
            return [
                'success' => false,
                'type' => 'error',
                'message' => 'Gagal menghapus lokasi. Silakan coba lagi.'
            ];
        }
    }

    public function getLocationDetails($id)
    {
        $location = AttendanceLocation::findOrFail($id);
        $stats = [
            'total_attendances' => Attendance::where('location', $location->name)->count(),
            'this_month' => Attendance::where('location', $location->name)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count(),
            'this_week' => Attendance::where('location', $location->name)
                ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'today' => Attendance::where('location', $location->name)
                ->whereDate('date', now()->toDateString())
                ->count(),
        ];

        $recentAttendances = Attendance::with(['user' => fn($q) => $q->select('id', 'name')])
            ->where('location', $location->name)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return compact('location', 'stats', 'recentAttendances');
    }

    public function getLocationsApi()
    {
        $locations = Cache::remember('attendance_locations_api', 3600, function () {
            return AttendanceLocation::select('id', 'name', 'latitude', 'longitude', 'radius')
                ->get()
                ->map(function ($location) {
                    return [
                        'id' => $location->id,
                        'name' => $location->name,
                        'latitude' => (float) $location->latitude,
                        'longitude' => (float) $location->longitude,
                        'radius' => $location->radius,
                        'maps_url' => "https://www.google.com/maps/@{$location->latitude},{$location->longitude},15z"
                    ];
                });
        });

        return ['success' => true, 'data' => $locations];
    }

    public function importLocations(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        try {
            // Excel::import(new LocationImport, $request->file('file'));
            Cache::forget('attendance_locations');
            return [
                'success' => true,
                'message' => 'Lokasi berhasil diimpor!'
            ];
        } catch (\Exception $e) {
            Log::error('Error importing locations: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['error' => 'Gagal mengimpor lokasi. Silakan periksa format file.']
            ];
        }
    }

    public function testLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $accuracy = $request->accuracy ?? 50;

        $locations = AttendanceLocation::all();
        $testResults = [];

        foreach ($locations as $location) {
            $distance = $this->calculateDistance(
                $request->latitude,
                $request->longitude,
                $location->latitude,
                $location->longitude
            );

            // radius dinamis: radius asli + accuracy (supaya fleksibel)
            $dynamicRadius = $location->radius + $accuracy;

            $isInRange = $distance <= $location->radius;
            $isInDynamicRange = $distance <= $dynamicRadius;

            $testResults[] = [
                'location' => $location->name,
                'distance' => round($distance, 2),
                'radius' => $location->radius,
                'accuracy' => round($accuracy, 2),
                'dynamic_radius' => round($dynamicRadius, 2),
                'is_in_range' => $isInRange,
                'is_in_dynamic_range' => $isInDynamicRange,
                'status' => $isInDynamicRange ? 'VALID' : 'OUT_OF_RANGE'
            ];
        }

        return [
            'success' => true,
            'test_coordinates' => [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'accuracy' => $accuracy
            ],
            'results' => $testResults
        ];
    }
    /**
 * Check location with dynamic radius based on GPS accuracy
 */
public function checkLocationWithDynamicRadius($latitude, $longitude, $accuracy, $locations)
{
    Log::info('Checking location with dynamic radius:', [
        'user_coords' => [$latitude, $longitude],
        'accuracy' => $accuracy,
        'total_locations' => $locations->count()
    ]);

    $validationResults = [];
    $isValid = false;
    $bestMatch = null;
    $minDistance = PHP_FLOAT_MAX;
    $nearestLocation = null;

    // Faktor dinamis berdasarkan akurasi GPS
    $accuracyFactor = $this->calculateAccuracyFactor($accuracy);
    
    foreach ($locations as $location) {
        $distance = $this->calculateDistance(
            (float)$latitude,
            (float)$longitude,
            (float)$location->latitude,
            (float)$location->longitude
        );

        // Radius dinamis: radius dasar + buffer akurasi
        $baseRadius = $location->radius;
        $accuracyBuffer = min($accuracy * $accuracyFactor, 500); // max 500m buffer
        $dynamicRadius = $baseRadius + $accuracyBuffer;

        // Simpan lokasi terdekat untuk referensi
        if ($distance < $minDistance) {
            $minDistance = $distance;
            $nearestLocation = $location;
        }

        $isInRadius = $distance <= $dynamicRadius;

        // Jika valid dan lebih dekat dari sebelumnya
        if ($isInRadius && ($bestMatch === null || $distance < 
            $this->calculateDistance($latitude, $longitude, $bestMatch->latitude, $bestMatch->longitude))) {
            $bestMatch = $location;
            $isValid = true;
        }

        $validationResults[] = [
            'location' => $location,
            'distance' => $distance,
            'base_radius' => $baseRadius,
            'accuracy_buffer' => $accuracyBuffer,
            'dynamic_radius' => $dynamicRadius,
            'is_valid' => $isInRadius,
            'accuracy_factor' => $accuracyFactor
        ];

        Log::info('Location check result:', [
            'location' => $location->name,
            'distance' => $distance,
            'base_radius' => $baseRadius,
            'dynamic_radius' => $dynamicRadius,
            'is_valid' => $isInRadius
        ]);
    }

    Log::info('Final location validation result:', [
        'is_valid' => $isValid,
        'best_match' => $bestMatch?->name,
        'min_distance' => $minDistance,
        'nearest_location' => $nearestLocation?->name
    ]);

    return [
        'is_valid' => $isValid,
        'best_match' => $bestMatch,
        'min_distance' => $bestMatch ? $this->calculateDistance(
            $latitude, $longitude, $bestMatch->latitude, $bestMatch->longitude
        ) : null,
        'nearest_location' => $nearestLocation,
        'nearest_distance' => $minDistance,
        'results' => $validationResults,
        'accuracy_factor' => $accuracyFactor,
        'message' => $isValid ? "Valid location found: {$bestMatch->name}" : "No valid location found"
    ];
}

/**
 * Calculate accuracy factor for dynamic radius
 */
private function calculateAccuracyFactor($accuracy)
{
    if ($accuracy <= 10) return 0.2;   // Sangat akurat
    if ($accuracy <= 50) return 0.5;   // Akurat
    if ($accuracy <= 100) return 0.8;  // Cukup
    if ($accuracy <= 500) return 1.0;  // Kurang
    if ($accuracy <= 1000) return 1.2; // Buruk
    return 1.5;                        // Sangat buruk
}


/**
 * Get GPS recommendations based on accuracy
 */
public function getGpsRecommendations($accuracy)
{
    $recommendations = [
        'accuracy' => $accuracy,
        'quality' => '',
        'suggestions' => []
    ];

    if ($accuracy <= 10) {
        $recommendations['quality'] = 'excellent';
        $recommendations['suggestions'] = ['GPS Anda sangat akurat. Tidak ada saran khusus.'];
    } elseif ($accuracy <= 30) {
        $recommendations['quality'] = 'good';
        $recommendations['suggestions'] = ['GPS Anda cukup akurat untuk absensi.'];
    } elseif ($accuracy <= 100) {
        $recommendations['quality'] = 'fair';
        $recommendations['suggestions'] = [
            'Coba pindah ke area yang lebih terbuka',
            'Pastikan tidak ada penghalang di atas kepala',
            'Tunggu beberapa detik untuk GPS lebih stabil'
        ];
    } else {
        $recommendations['quality'] = 'poor';
        $recommendations['suggestions'] = [
            'Keluar dari bangunan atau area tertutup',
            'Aktifkan "High Accuracy" di pengaturan lokasi',
            'Restart aplikasi GPS atau browser',
            'Tunggu 1-2 menit di area terbuka',
            'Pastikan koneksi internet stabil'
        ];
    }

    return $recommendations;
}

/**
 * Enhanced location testing with detailed feedback
 */
public function testLocationEnhanced(Request $request)
{
    $validator = Validator::make($request->all(), [
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'accuracy' => 'nullable|numeric|min:0'
    ]);

    if ($validator->fails()) {
        return ['success' => false, 'errors' => $validator->errors()];
    }

    $accuracy = $request->accuracy ?? 50;
    $locations = $this->getCachedLocations();
    
    // Test dengan sistem baru
    $validation = $this->checkLocationWithDynamicRadius(
        $request->latitude,
        $request->longitude, 
        $accuracy,
        $locations
    );

    // Get GPS recommendations
    $recommendations = $this->getGpsRecommendations($accuracy);

    return [
        'success' => true,
        'test_info' => [
            'coordinates' => [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ],
            'accuracy' => $accuracy,
            'accuracy_factor' => $validation['accuracy_factor'],
            'timestamp' => now()->toISOString()
        ],
        'validation_result' => [
            'is_valid' => $validation['is_valid'],
            'best_match' => $validation['best_match'] ? [
                'name' => $validation['best_match']->name,
                'distance' => round($validation['min_distance'], 2),
                'base_radius' => $validation['best_match']->radius
            ] : null,
            'nearest_location' => $validation['nearest_location'] ? [
                'name' => $validation['nearest_location']->name,
                'distance' => round($validation['nearest_distance'], 2)
            ] : null
        ],
        'detailed_results' => array_map(function($result) {
            return [
                'location_name' => $result['location']->name,
                'distance' => round($result['distance'], 2),
                'base_radius' => $result['base_radius'],
                'dynamic_radius' => round($result['dynamic_radius'], 2),
                'accuracy_buffer' => round($result['accuracy_buffer'], 2),
                'is_valid' => $result['is_valid'],
                'status' => $result['is_valid'] ? 'VALID' : 'OUT_OF_RANGE'
            ];
        }, $validation['results']),
        'gps_recommendations' => $recommendations
    ];
}
}
