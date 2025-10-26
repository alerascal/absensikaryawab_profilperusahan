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
      // Alias supaya tidak bentrok dengan nama method di trait
    use LocationValidationTrait {
        validateLocation as protected validateLocationFromTrait;
    }

    /**
     * Get cached locations for performance
     */
    public function getCachedLocations()
    {
        return Cache::remember('attendance_locations', config('app.cache_ttl_locations', 3600), function () {
            return AttendanceLocation::all();
        });
    }

    /**
     * Get locations with pagination and search
     */
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

    /**
     * Get location by ID
     */
    public function getLocationById($id)
    {
        $location = AttendanceLocation::findOrFail($id);
        $location->maps_link = "https://www.google.com/maps/@{$location->latitude},{$location->longitude},15z";
        return $location;
    }

    /**
     * Create new location
     */
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
            'radius.min' => 'Radius minimal 50 meter.',
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

        // Check for duplicate locations within small radius (roughly 10 meters)
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
            Log::info("Lokasi absensi baru ditambahkan: {$location->name}", [
                'location_id' => $location->id,
                'coordinates' => $coordinates
            ]);

            return [
                'success' => true,
                'message' => 'Lokasi absensi berhasil ditambahkan!',
                'data' => $location
            ];
        } catch (\Exception $e) {
            Log::error('Error creating attendance location: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['error' => 'Gagal menambahkan lokasi. Silakan coba lagi.']
            ];
        }
    }
    /**
     * Update location
     */
    public function updateLocation(Request $request, $id)
    {
        $location = AttendanceLocation::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attendance_locations,name,' . $id,
            'maps_link' => 'required|url',
            'radius' => 'required|numeric|min:50|max:1000',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'errors' => $validator->errors()];
        }

        $coordinates = $this->extractCoordinatesFromUrl($request->maps_link);
        if (!$coordinates) {
            return [
                'success' => false,
                'errors' => [
                    'maps_link' => 'Tidak dapat mengekstrak koordinat dari link Google Maps.'
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
            Log::info("Lokasi absensi diperbarui: {$location->name}", [
                'location_id' => $location->id,
                'old_coordinates' => ['lat' => $location->getOriginal('latitude'), 'lng' => $location->getOriginal('longitude')],
                'new_coordinates' => $coordinates
            ]);

            return [
                'success' => true,
                'message' => 'Lokasi berhasil diperbarui.',
                'data' => $location
            ];
        } catch (\Exception $e) {
            Log::error('Error updating attendance location: ' . $e->getMessage());
            return [
                'success' => false,
                'errors' => ['error' => 'Gagal memperbarui lokasi. Silakan coba lagi.']
            ];
        }
    }

    /**
     * Delete location
     */
    public function deleteLocation($id)
    {
        try {
            $location = AttendanceLocation::findOrFail($id);
            $attendanceCount = Attendance::where('attendance_location_id', $id)->count();

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
            
            Log::info("Lokasi absensi dihapus: {$locationName}", [
                'location_id' => $id
            ]);

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

    /**
     * Validate location with dynamic radius
     * Method utama yang digunakan di AttendanceService
     */
    public function checkLocationWithDynamicRadius($latitude, $longitude, $accuracy, $locations)
    {
        // Delegate to trait method for consistency
        return $this->validateLocation($latitude, $longitude, $accuracy, $locations);
    }

    /**
     * Validate location for API endpoint
     */
  public function validateLocation($latitude, $longitude, $accuracy)
{
    $locations = $this->getCachedLocations();
    
    // ✅ panggil method trait
    $validationResult = $this->validateLocationFromTrait($latitude, $longitude, $accuracy, $locations);

    // Format hasil tetap sama
    $formattedResults = [];
    foreach ($validationResult['results'] as $result) {
        $formattedResults[] = [
            'location' => [
                'id' => $result['location']->id,
                'name' => $result['location']->name,
                'latitude' => $result['location']->latitude,
                'longitude' => $result['location']->longitude,
                'radius' => $result['location']->radius,
            ],
            'distance' => round($result['distance'], 2),
            'base_radius' => $result['base_radius'],
            'accuracy_buffer' => round($result['accuracy_buffer'], 2),
            'dynamic_radius' => round($result['dynamic_radius'], 2),
            'is_valid' => $result['is_valid']
        ];
    }

    return [
        'success' => true,
        'is_valid' => $validationResult['is_valid'],
        'best_match' => $validationResult['best_match'] ? [
            'id' => $validationResult['best_match']->id,
            'name' => $validationResult['best_match']->name,
            'distance' => round($validationResult['min_distance'], 2)
        ] : null,
        'nearest_location' => $validationResult['nearest_location'] ? [
            'id' => $validationResult['nearest_location']->id,
            'name' => $validationResult['nearest_location']->name,
            'distance' => round($validationResult['nearest_distance'], 2)
        ] : null,
        'accuracy_info' => [
            'accuracy' => $accuracy,
            'accuracy_factor' => $validationResult['accuracy_factor'],
            'quality' => $this->evaluateGpsQuality($accuracy)
        ],
        'message' => $validationResult['message'],
        'results' => $formattedResults
    ];
}

    /**
     * Get location validation info for debugging
     */
    public function getLocationValidationInfo($latitude, $longitude, $accuracy = null)
    {
        $locations = $this->getCachedLocations();
        $results = [];

        foreach ($locations as $location) {
            $distance = $this->calculateDistance(
                $latitude, 
                $longitude, 
                $location->latitude, 
                $location->longitude
            );

            $baseRadius = $location->radius;
            $accuracyBuffer = $accuracy ? min($accuracy * $this->calculateAccuracyFactor($accuracy), 500) : 0;
            $dynamicRadius = $baseRadius + $accuracyBuffer;

            $results[] = [
                'location' => $location,
                'distance' => round($distance, 2),
                'base_radius' => $baseRadius,
                'accuracy_buffer' => round($accuracyBuffer, 2),
                'dynamic_radius' => round($dynamicRadius, 2),
                'is_valid' => $distance <= $dynamicRadius,
                'maps_link' => "https://www.google.com/maps/@{$location->latitude},{$location->longitude},15z"
            ];
        }

        // Sort by distance
        usort($results, fn($a, $b) => $a['distance'] <=> $b['distance']);

        return [
            'user_location' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'accuracy' => $accuracy,
                'maps_link' => "https://www.google.com/maps/@{$latitude},{$longitude},15z"
            ],
            'locations' => $results,
            'total_locations' => count($results),
            'valid_locations' => array_filter($results, fn($r) => $r['is_valid'])
        ];
    }
}