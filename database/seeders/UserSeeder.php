<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        \App\Models\User::query()->delete();
        $faker = Faker::create('id_ID');

        $departments = Department::all();

        // ==============================
        // 1️⃣  Admin
        // ==============================
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => $faker->name(),
                'email' => "admin{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department_id' => null,
                'is_active' => true,
                'employee_id' => 'ADM' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'position' => $faker->randomElement(['Administrator', 'Supervisor', 'System Admin']),
                'employment_status' => 'full-time',
                'join_date' => Carbon::now()->subYears(rand(3, 10)),
            ]);
        }

        // ==============================
        // 2️⃣  Pegawai
        // ==============================
        for ($i = 1; $i <= 100; $i++) {
            $dept = $departments->isNotEmpty() ? $departments->random() : null;

            User::create([
                'name' => $faker->name(),
                'email' => "pegawai{$i}@example.com",
                'password' => Hash::make('password'),
                'role' => 'pegawai',
                'department_id' => $dept ? $dept->id : null,
                'is_active' => $faker->boolean(90),
                'employee_id' => 'EMP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'position' => $faker->jobTitle(),
                'employment_status' => $faker->randomElement(['full-time', 'part-time', 'contract']),
                'join_date' => Carbon::now()->subMonths(rand(1, 60)),
            ]);
        }

        // ==============================
        // ✅  Akun Admin Default (untuk login cepat)
        // ==============================
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department_id' => null,
                'is_active' => true,
                'employee_id' => 'ADM0000',
                'position' => 'Super Admin',
                'employment_status' => 'full-time',
                'join_date' => Carbon::now()->subYears(5),
            ]
        );
    }
}
