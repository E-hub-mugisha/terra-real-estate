<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Sales',      'code' => 'SALES', 'description' => 'Property Sales Team'],
            ['name' => 'Operations', 'code' => 'OPS',   'description' => 'Operations & Admin'],
            ['name' => 'Finance',    'code' => 'FIN',   'description' => 'Finance & Payments'],
            ['name' => 'HR',         'code' => 'HR',    'description' => 'Human Resources'],
            ['name' => 'IT',         'code' => 'IT',    'description' => 'Information Technology'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }
    }
}
