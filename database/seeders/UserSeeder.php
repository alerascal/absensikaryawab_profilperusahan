<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $departments = Department::all();

        // 3 Admin
        $admins = [
            ['name' => 'Admin Utama', 'email' => 'admin1@example.com'],
            ['name' => 'Admin HR', 'email' => 'admin2@example.com'],
            ['name' => 'Admin Keuangan', 'email' => 'admin3@example.com'],
        ];

        foreach ($admins as $admin) {
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department_id' => null,
                'is_active' => true,
                'employee_id' => null,
                'position' => 'Administrator',
                'employment_status' => 'Aktif',
                'join_date' => Carbon::now()->subYears(rand(1, 5)),
            ]);
        }

        // 17 Pegawai (acak dari beberapa departemen)
        $pegawaiNames = [
            'Andi Saputra',
            'Budi Santoso',
            'Citra Dewi',
            'Dian Pratama',
            'Eka Wulandari',
            'Fajar Nugraha',
            'Galih Ramadhan',
            'Hendra Wijaya',
            'Indah Lestari',
            'Joko Susilo',
            'Kartika Sari',
            'Lutfi Hidayat',
            'Maya Putri',
            'Nanda Kurniawan',
            'Oktaviani Cahya',
            'Putra Mahendra',
            'Rina Amelia'
        ];

        foreach ($pegawaiNames as $i => $name) {
            $dept = $departments->random();
            User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '', $name)) . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'pegawai',
                'department_id' => $dept->id,
                'is_active' => true,
                'employee_id' => 'EMP' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'position' => fake()->jobTitle(),
                'employment_status' => fake()->randomElement(['Aktif', 'Cuti', 'Resign']),

                'join_date' => Carbon::now()->subMonths(rand(1, 24)),
            ]);
        }
    }
}
