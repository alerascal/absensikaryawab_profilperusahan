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
    protected function validateLocation($userLat, $userLon, $accuracy, $locations)
    {
        $validationResults = [];
        $isValid = false;
        $bestMatch = null;
        $minDistance = PHP_FLOAT_MAX;

        // Jika akurasi GPS sangat buruk
        if ($accuracy > 3000) {
            return [
                'is_valid' => false,
                'best_match' => null,
                'min_distance' => null,
                'results' => [],
                'message' => "⚠️ GPS Anda tidak akurat (±{$accuracy}m). Silakan aktifkan mode lokasi akurat atau pindah ke area terbuka."
            ];
        }

        foreach ($locations as $location) {
            $distance = $this->calculateDistance(
                (float)$userLat,
                (float)$userLon,
                (float)$location->latitude,
                (float)$location->longitude
            );

            $baseRadius = $location->radius;
            $accuracyBuffer = min($accuracy * 1.5, 300); // buffer tambahan dari akurasi
            $dynamicRadius = $baseRadius + $accuracyBuffer;

            $isInRadius = $distance <= $dynamicRadius;

            if ($isInRadius && $distance < $minDistance) {
                $minDistance = $distance;
                $bestMatch = $location;
                $isValid = true;
            }

            $validationResults[] = [
                'location' => $location,
                'distance' => $distance,
                'base_radius' => $baseRadius,
                'dynamic_radius' => $dynamicRadius,
                'is_valid' => $isInRadius,
                'accuracy_buffer' => $accuracyBuffer
            ];
        }

        return [
            'is_valid' => $isValid,
            'best_match' => $bestMatch,
            'min_distance' => $minDistance,
            'results' => $validationResults,
            'message' => $isValid ? "✅ Lokasi valid untuk absensi" : "⚠️ Anda berada di luar area absensi"
        ];
    }

    /**
     * Menentukan status absensi berdasarkan jadwal dan waktu saat ini
     */
    protected function determineAttendanceStatus($user, $currentTime, $currentDate)
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

        // Absensi terlalu awal
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
     * Ekstraksi koordinat dari URL Google Maps
     */
    protected function extractCoordinatesFromUrl($url)
    {
        if (str_contains($url, 'maps.app.goo.gl') || str_contains($url, 'goo.gl/maps')) {
            $context = stream_context_create([
                'http' => [
                    'method' => 'GET',
                    'follow_location' => 0,
                    'timeout' => 10
                ]
            ]);

            $headers = @get_headers($url, 1, $context);
            if ($headers && isset($headers['Location'])) {
                $url = is_array($headers['Location']) ? end($headers['Location']) : $headers['Location'];
            }
        }

        $patterns = [
            '/@(-?\d+\.\d{6,}),(-?\d+\.\d{6,}),\d+\.?\d*[mz]/',
            '/@(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
            '/[?&]q=(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
            '/place\/[^\/]+\/@(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
            '/dir\/[^\/]+\/(-?\d+\.\d{6,}),(-?\d+\.\d{6,})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                if (count($matches) >= 3) {
                    $lat = (float) $matches[1];
                    $lng = (float) $matches[2];

                    if ($lat >= -90 && $lat <= 90 && $lng >= -180 && $lng <= 180) {
                        return [
                            'latitude' => $lat,
                            'longitude' => $lng
                        ];
                    }
                }
            }
        }

        return null;
    }
}
