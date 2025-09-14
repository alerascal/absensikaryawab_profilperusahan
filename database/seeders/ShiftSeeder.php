<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShiftSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('shifts')->insert([
            [
                'name' => 'Pagi',
                'start_time' => '07:00:00',
                'end_time' => '15:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Siang',
                'start_time' => '15:00:00',
                'end_time' => '23:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Malam',
                'start_time' => '23:00:00',
                'end_time' => '07:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
