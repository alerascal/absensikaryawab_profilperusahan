<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'HR', 'jumlah' => 5, 'persen' => 10],
            ['name' => 'IT', 'jumlah' => 10, 'persen' => 20],
            ['name' => 'Finance', 'jumlah' => 8, 'persen' => 16],
        ];

        foreach ($departments as $dept) {
            Department::create($dept);
        }
    }
}
