<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class,
            AttendanceSeeder::class,
            ShiftSeeder::class,
        ]);
    }
}