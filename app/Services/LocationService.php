<?php

namespace App\Services;

use App\Models\AttendanceLocation;

class LocationService
{
  /**
   * Ambil semua lokasi absensi
   */
  public function getAll()
  {
    return AttendanceLocation::orderBy('name')->get();
  }

  /**
   * Ambil lokasi aktif
   */
  public function getActive()
  {
    return AttendanceLocation::where('is_active', true)->get();
  }

  /**
   * Ambil lokasi berdasarkan ID
   */
  public function findById(int $id)
  {
    return AttendanceLocation::findOrFail($id);
  }

  /**
   * Validasi jarak user ke lokasi (GPS)
   */
  public function validateRadius(
    float $userLat,
    float $userLng,
    float $locationLat,
    float $locationLng,
    float $maxRadius
  ): bool {
    $distance = $this->calculateDistance(
      $userLat,
      $userLng,
      $locationLat,
      $locationLng
    );

    return $distance <= $maxRadius;
  }

  /**
   * Hitung jarak Haversine (meter)
   */
  private function calculateDistance($lat1, $lon1, $lat2, $lon2)
  {
    $earthRadius = 6371000; // meter

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat / 2) * sin($dLat / 2) +
      cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
      sin($dLon / 2) * sin($dLon / 2);

    $c = 2 * asin(sqrt($a));

    return $earthRadius * $c;
  }
}
