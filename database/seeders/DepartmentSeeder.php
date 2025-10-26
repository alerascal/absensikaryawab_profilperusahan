<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Human Resources (HR)'],
            ['name' => 'Finance & Accounting'],
            ['name' => 'Information Technology (IT)'],
            ['name' => 'Marketing & Sales'],
            ['name' => 'Operations'],
            ['name' => 'Research & Development (R&D)'],
            ['name' => 'Legal & Compliance'],
            ['name' => 'Customer Service'],
            ['name' => 'Procurement & Logistics'],
            ['name' => 'Production/Manufacturing'],
            ['name' => 'Quality Assurance'],
            ['name' => 'Corporate Strategy'],
            ['name' => 'Public Relations (PR)'],
            ['name' => 'Health, Safety & Environment (HSE)'],
            ['name' => 'Executive Management'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}