<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Schedule;
use App\Models\AttendanceLocation;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $users     = User::all();
        $locations = AttendanceLocation::pluck('id')->toArray();
        $schedules = Schedule::all();

        if ($users->isEmpty()) {
            $this->command->warn('Seeder dibatalkan: user kosong');
            return;
        }

        $startDate = Carbon::now()->subYears(5)->startOfYear();
        $endDate   = Carbon::now();

        foreach ($users as $user) {
            $date = $startDate->copy();

            while ($date <= $endDate) {

                // Lewati weekend
                if ($date->isWeekend()) {
                    $date->addDay();
                    continue;
                }

                // Status random
                $status = collect([
                    'Hadir',
                    'Terlambat',
                    'Izin',
                    'Sakit',
                    'Alpha',
                ])->random();

                $schedule = $schedules->random();

                // Default value
                $checkIn  = null;
                $notes    = null;
                $locationId = null;
                $locationText = 'Tidak diketahui';

                if (in_array($status, ['Hadir', 'Terlambat'])) {
                    $checkIn = $date->copy()->setTime(
                        rand(7, 8),
                        rand(0, 59)
                    );

                    $locationId   = $locations ? collect($locations)->random() : null;
                    $locationText = 'Kantor Utama';

                    if ($status === 'Terlambat') {
                        $notes = 'Terlambat ' . rand(5, 30) . ' menit';
                    }
                }

                if ($status === 'Alpha') {
                    $notes = 'Tidak hadir tanpa keterangan';
                }

                if (in_array($status, ['Izin', 'Sakit'])) {
                    $notes = $status . ' (disetujui)';
                }

                Attendance::create([
                    'user_id'               => $user->id,
                    'schedule_id'           => $schedule->id ?? null,
                    'attendance_location_id' => $locationId,
                    'date'                  => $date->toDateString(),
                    'check_in'              => $checkIn,
                    'check_out'             => null,
                    'status'                => $status,
                    'location'              => $locationText,
                    'latitude'              => -6.879704,
                    'longitude'             => 109.125595,
                    'accuracy'              => rand(5, 20),
                    'notes'                 => $notes,
                ]);

                $date->addDay();
            }
        }

        $this->command->info('Seeder Attendance 5 tahun berhasil dibuat');
    }
}
