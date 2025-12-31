<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   // ← Tambahkan baris ini
use App\Models\User;
use App\Models\Shift;
use App\Models\Schedule;
use App\Models\Holiday;
use Carbon\Carbon;

class AbsensiScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Shift
        $shiftPagi = Shift::firstOrCreate(
            ['name' => 'Pagi'],
            [
                'start_time' => '07:00',
                'end_time' => '15:00',
            ]
        );

        $shiftSore = Shift::firstOrCreate(
            ['name' => 'Sore'],
            [
                'start_time' => '15:00',
                'end_time' => '23:00',
            ]
        );

        $shiftMalam = Shift::firstOrCreate(
            ['name' => 'Malam'],
            [
                'start_time' => '23:00',
                'end_time' => '07:00',
            ]
        );

        // 2. Hari Libur: Sabtu & Minggu
        Holiday::whereNotNull('day_of_week')->delete();
        Holiday::create(['name' => 'Libur Mingguan', 'day_of_week' => 6]);
        Holiday::create(['name' => 'Libur Mingguan', 'day_of_week' => 7]);

        // 3. Reset jadwal dengan aman (karena ada foreign key constraint)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schedule::query()->delete();
        DB::table('schedule_user')->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Data jadwal lama telah dihapus.');

        // 4. Ambil pegawai aktif
        $pegawai = User::where('role', 'pegawai')
            ->where('is_active', true)
            ->inRandomOrder()
            ->get();

        if ($pegawai->isEmpty()) {
            $this->command->warn('Tidak ada pegawai. Jalankan UserSeeder dulu!');
            return;
        }

        // 5. Jadwal Fulltime 08:00 - 17:00 (Senin-Jumat)
        $fulltimeSchedules = [];
        foreach (range(1, 5) as $day) {
            $schedule = Schedule::create([
                'day'         => $day,
                'start_time'  => '08:00',
                'end_time'    => '17:00',
                'is_fulltime' => true,
                'shift_id'    => null,
            ]);
            $fulltimeSchedules[] = $schedule;
        }

        // 6. Shift Pagi (20 pegawai)
        $shiftPagiUsers = $pegawai->take(20);
        foreach (range(1, 5) as $day) {
            $schedule = Schedule::create([
                'day'         => $day,
                'start_time'  => '07:00',
                'end_time'    => '15:00',
                'is_fulltime' => false,
                'shift_id'    => $shiftPagi->id,
            ]);
            $schedule->users()->attach($shiftPagiUsers->pluck('id'));
        }

        // 7. Shift Sore (15 pegawai berbeda)
        $remainingPegawai = $pegawai->whereNotIn('id', $shiftPagiUsers->pluck('id'));
        $shiftSoreUsers = $remainingPegawai->take(15);
        foreach (range(1, 5) as $day) {
            $schedule = Schedule::create([
                'day'         => $day,
                'start_time'  => '15:00',
                'end_time'    => '23:00',
                'is_fulltime' => false,
                'shift_id'    => $shiftSore->id,
            ]);
            $schedule->users()->attach($shiftSoreUsers->pluck('id'));
        }

        // 8. Update Fulltime: hanya pegawai yang tidak punya shift
        $usersInShift = Schedule::where('is_fulltime', false)
            ->with('users')
            ->get()
            ->flatMap(fn($s) => $s->users->pluck('id'))
            ->unique();

        $eligibleForFulltime = User::where('role', 'pegawai')
            ->whereNotIn('id', $usersInShift)
            ->pluck('id');

        foreach ($fulltimeSchedules as $sched) {
            $sched->users()->sync($eligibleForFulltime);
        }

        $this->command->info('Seeder jadwal selesai!');
        $this->command->info('✓ Shift: Pagi, Sore, Malam');
        $this->command->info('✓ Libur: Sabtu & Minggu');
        $this->command->info('✓ Fulltime: 08:00-17:00 untuk pegawai non-shift');
        $this->command->info("✓ Shift Pagi: {$shiftPagiUsers->count()} pegawai");
        $this->command->info("✓ Shift Sore: {$shiftSoreUsers->count()} pegawai");
    }
}
