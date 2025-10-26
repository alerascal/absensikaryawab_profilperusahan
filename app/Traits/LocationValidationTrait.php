<?php

namespace App\Traits;

use App\Models\AttendanceLocation;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

trait LocationValidationTrait
{
    /**
     * Menghitung jarak antara dua koordinat menggunakan Haversine formula
     */
    protected function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter

        $lat1Rad = deg2rad($lat1);
        $lat2Rad = deg2rad($lat2);
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($dLon / 2) ** 2;

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        Log::info("Distance calculation: from ({$lat1}, {$lon1}) to ({$lat2}, {$lon2}) = {$distance}m");

        return $distance;
    }

    /**
     * Calculate accuracy factor based on GPS accuracy
     * Sesuaikan dengan yang ada di LocationService
     */
    protected function calculateAccuracyFactor($accuracy)
    {
        if ($accuracy <= 10) return 0.2;
        if ($accuracy <= 50) return 0.5;
        if ($accuracy <= 100) return 0.8;
        if ($accuracy <= 500) return 1.0;
        if ($accuracy <= 1000) return 1.2;
        return 1.5;
    }

    /**
     * Validate location with dynamic radius
     * Sinkronisasi dengan method di LocationService
     */
    protected function validateLocation($userLat, $userLon, $accuracy, $locations)
    {
        Log::info('Validating location using trait:', [
            'user_coords' => [$userLat, $userLon],
            'accuracy' => $accuracy,
            'total_locations' => $locations->count()
        ]);

        $validationResults = [];
        $isValid = false;
        $bestMatch = null;
        $minDistance = PHP_FLOAT_MAX;
        $nearestLocation = null;

        // Check if accuracy is too poor for reliable validation
        if ($accuracy > config('app.max_accuracy', 3000)) {
            return [
                'is_valid' => false,
                'best_match' => null,
                'min_distance' => null,
                'nearest_location' => null,
                'nearest_distance' => null,
                'results' => [],
                'accuracy_factor' => $this->calculateAccuracyFactor($accuracy),
                'message' => "⚠️ GPS Anda tidak akurat (±{$accuracy}m). Silakan aktifkan mode lokasi akurat atau pindah ke area terbuka."
            ];
        }

        $accuracyFactor = $this->calculateAccuracyFactor($accuracy);

        foreach ($locations as $location) {
            $distance = $this->calculateDistance(
                (float)$userLat,
                (float)$userLon,
                (float)$location->latitude,
                (float)$location->longitude
            );

            $baseRadius = $location->radius;
            $accuracyBuffer = min($accuracy * $accuracyFactor, 500);
            $dynamicRadius = $baseRadius + $accuracyBuffer;

            $isInRadius = $distance <= $dynamicRadius;

            // Track nearest location
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestLocation = $location;
            }
            $baseRadius = $location->radius;
            $accuracyFactor = $this->calculateAccuracyFactor($accuracy);

            // Longgarkan buffer kalau GPS akurasi buruk
            if ($accuracy > 50) {
                $accuracyFactor *= 2;
            }

            $accuracyBuffer = min($accuracy * $accuracyFactor, 1000); // max buffer 1 km
            $dynamicRadius = $baseRadius + $accuracyBuffer;

            // Tambahkan toleransi minimal 2000m
            $toleranceRadius = max($dynamicRadius, 2000);

            $isInRadius = $distance <= $toleranceRadius;


            // Find best match (valid and closest)
            if ($isInRadius && ($bestMatch === null || $distance <
                $this->calculateDistance($userLat, $userLon, $bestMatch->latitude, $bestMatch->longitude))) {
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

            Log::info('Location validation check:', [
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
            'min_distance' => $bestMatch ? $this->calculateDistance(
                $userLat,
                $userLon,
                $bestMatch->latitude,
                $bestMatch->longitude
            ) : null,
            'nearest_location' => $nearestLocation?->name
        ]);

        return [
            'is_valid' => $isValid,
            'best_match' => $bestMatch,
            'min_distance' => $bestMatch ? $this->calculateDistance(
                $userLat,
                $userLon,
                $bestMatch->latitude,
                $bestMatch->longitude
            ) : null,
            'nearest_location' => $nearestLocation,
            'nearest_distance' => $minDistance,
            'results' => $validationResults,
            'accuracy_factor' => $accuracyFactor,
            'message' => $isValid
                ? "✅ Lokasi valid untuk absensi: {$bestMatch->name}"
                : "⚠️ Anda berada di luar area absensi (jarak terdekat: " . round($minDistance, 1) . "m)"
        ];
    }

    /**
     * Menentukan status absensi berdasarkan keterlambatan dan lokasi
     * Sinkronisasi dengan AttendanceService
     */
    protected function determineAttendanceStatus($lateMinutes, $isValidLocation)
    {
        if (!$isValidLocation) {
            return 'Lokasi Invalid';
        }

        if ($lateMinutes <= 0) {
            return 'Hadir';
        } elseif ($lateMinutes <= 30) {
            return 'Hadir';
        } elseif ($lateMinutes <= 60) {
            return 'Terlambat';
        } else {
            return 'Absen';
        }
    }

    /**
     * Menentukan status absensi berdasarkan jadwal dan waktu saat ini
     * Method legacy yang masih dibutuhkan untuk kompatibilitas
     */
    protected function determineAttendanceStatusLegacy($user, $currentTime, $currentDate)
    {
        $dayOfWeek = $currentDate->format('l');

        $schedule = $user->schedules()
            ->where(function ($query) use ($dayOfWeek) {
                $query->where('days', 'like', "%{$dayOfWeek}%")
                    ->orWhere('days', 'like', "%All%");
            })
            ->first();

        if (!$schedule) {
            Log::warning("No schedule found for user {$user->id} on {$dayOfWeek}");
            return [
                'status' => 'Hadir',
                'schedule_id' => null,
                'message' => 'Tidak ada jadwal untuk hari ini'
            ];
        }

        $scheduleStartTime = Carbon::parse($schedule->start_time);
        $scheduleEndTime = Carbon::parse($schedule->end_time);
        $currentTimeCarbon = Carbon::parse($currentTime);

        if ($currentTimeCarbon->lt($scheduleStartTime->subHours(2))) {
            return [
                'status' => 'Terlalu Awal',
                'schedule_id' => $schedule->id,
                'message' => 'Absensi terlalu awal. Jam kerja dimulai pukul ' . $scheduleStartTime->format('H:i')
            ];
        }

        $minutesLate = $currentTimeCarbon->diffInMinutes($scheduleStartTime, false);

        if ($minutesLate <= 0) {
            return [
                'status' => 'Hadir',
                'schedule_id' => $schedule->id,
                'message' => 'Tepat waktu'
            ];
        } elseif ($minutesLate <= 15) {
            return [
                'status' => 'Terlambat',
                'schedule_id' => $schedule->id,
                'message' => "Terlambat {$minutesLate} menit"
            ];
        } elseif ($minutesLate <= 60) {
            return [
                'status' => 'Absen',
                'schedule_id' => $schedule->id,
                'message' => "Terlambat {$minutesLate} menit - dianggap tidak hadir"
            ];
        } else {
            if ($currentTimeCarbon->gt($scheduleEndTime)) {
                return [
                    'status' => 'Absen',
                    'schedule_id' => $schedule->id,
                    'message' => 'Melewati jam kerja - dianggap tidak hadir'
                ];
            }
            return [
                'status' => 'Absen',
                'schedule_id' => $schedule->id,
                'message' => "Sangat terlambat ({$minutesLate} menit) - dianggap tidak hadir"
            ];
        }
    }

    /**
     * Generate GPS quality notes
     * Sinkronisasi dengan AttendanceService
     */
    protected function generateGpsNotes($accuracy, $locationValidation, $request = null)
    {
        $gpsQuality = $this->evaluateGpsQuality($accuracy);
        $notes = "GPS: {$gpsQuality['description']} (±{$accuracy}m)";

        if ($locationValidation['best_match']) {
            $distance = round($locationValidation['min_distance'], 1);
            $notes .= " | Lokasi: {$locationValidation['best_match']->name} ({$distance}m)";
        }

        return $notes;
    }

    /**
     * Evaluate GPS quality
     * Sinkronisasi dengan AttendanceService
     */
    protected function evaluateGpsQuality($accuracy)
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
     * Ekstraksi koordinat dari URL Google Maps
     */
    protected function extractCoordinatesFromUrl($url)
    {
        // Handle shortened URLs
        if (str_contains($url, 'maps.app.goo.gl') || str_contains($url, 'goo.gl/maps')) {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'follow_location' => 0,
                    'timeout' => 10,
                    'user_agent' => 'Mozilla/5.0 (compatible; AttendanceBot/1.0)'
                ]
            ]);

            $headers = @get_headers($url, 1, $context);
            if ($headers && isset($headers['Location'])) {
                $url = is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
            }
        }

        // Various patterns to extract coordinates from Google Maps URLs
        $patterns = [
            '/@(-?\d+\.\d{6,}),(-?\d+\.\d{6,}),\d+\.?\d*[mz]/',
            '/@(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
            '/[?&]q=(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
            '/place\/[^\/]+\/@(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
            '/dir\/[^\/]+\/(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
            '/ll=(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
            '/center=(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                if (count($matches) >= 3) {
                    $lat = (float) $matches[1];
                    $lng = (float) $matches[2];

                    // Validate coordinates are within valid ranges
                    if ($lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180) {
                        Log::info('Extracted coordinates from URL:', [
                            'url' => $url,
                            'latitude' => $lat,
                            'longitude' => $lng,
                            'pattern' => $pattern
                        ]);

                        return [
                            'latitude' => $lat,
                            'longitude' => $lng
                        ];
                    }
                }
            }
        }

        Log::warning('Failed to extract coordinates from URL:', ['url' => $url]);
        return null;
    }
}
