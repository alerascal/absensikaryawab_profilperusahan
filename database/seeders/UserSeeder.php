<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Default',
            'email' => 'admin@company.com',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pegawai Default',
            'email' => 'pegawai@company.com',
            'password' => 'pegawai123',
            'role' => 'pegawai',
        ]);
    }
}

