<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        // Hapus semua data lama
        Attendance::truncate();

        $employees = User::where('role', 'pegawai')->get();
        $statuses = ['Hadir', 'Terlambat', 'Absen'];
        $locations = ['Office', 'Home', 'Client Site'];

        foreach ($employees as $user) {
            $startDate = Carbon::today()->subYear(); // 1 tahun yang lalu
            $endDate = Carbon::today();

            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
                $status = $statuses[array_rand($statuses)];
                $location = $locations[array_rand($locations)];

                $checkIn = null;
                $checkOut = null;

                if ($status !== 'Absen') {
                    if ($status === 'Hadir') {
                        $checkIn = $date->copy()->setTime(rand(7,8), rand(0,59), 0);
                        $checkOut = $date->copy()->setTime(rand(16,17), rand(0,59), 0);
                    } elseif ($status === 'Terlambat') {
                        $checkIn = $date->copy()->setTime(rand(9,10), rand(0,59), 0);
                        $checkOut = $date->copy()->setTime(rand(17,18), rand(0,59), 0);
                    }
                }

                // GPS metadata dummy (random dalam kota Tegal misalnya)
                $latitude = -6.8695 + mt_rand(-100, 100) / 10000;   // sekitar Tegal
                $longitude = 109.1405 + mt_rand(-100, 100) / 10000;
                $gpsAccuracy = rand(5, 50); // 5–50 meter
                $distance = rand(0, 200);  // 0–200 meter dari lokasi absen
                $altitude = rand(5, 20);   // 5–20 meter
                $heading = rand(0, 360);   // arah acak
                $speed = rand(0, 2);       // rata-rata jalan kaki

                Attendance::create([
                    'user_id' => $user->id,
                    'date' => $date->toDateString(),
                    'check_in' => $checkIn ? $checkIn->toTimeString() : null,
                    'check_out' => $checkOut ? $checkOut->toTimeString() : null,
                    'status' => $status,
                    'location' => $location,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'gps_accuracy' => $gpsAccuracy,
                    'distance_to_location' => $distance,
                    'altitude' => $altitude,
                    'heading' => $heading,
                    'speed' => $speed,
                ]);
            }
        }
    }
}
