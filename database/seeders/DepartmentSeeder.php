<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'id'          => 1,
                'name'        => 'Listings & Property Management',
                'code'        => 'LPM',
                'description' => 'Manages house, land, and architectural design listings across the platform',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id'          => 2,
                'name'        => 'Agent & Consultant Relations',
                'code'        => 'ACR',
                'description' => 'Handles agent onboarding, verification, and consultant partnerships',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id'          => 3,
                'name'        => 'Finance & Payments',
                'code'        => 'FNP',
                'description' => 'Oversees MoMo payments, commission payouts, and financial reporting',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id'          => 4,
                'name'        => 'Marketing & Advertising',
                'code'        => 'MKT',
                'description' => 'Manages advertisement packages, blog content, and platform promotions',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'id'          => 5,
                'name'        => 'Technology & Platform Operations',
                'code'        => 'TPO',
                'description' => 'Maintains platform infrastructure, activity logging, and system health',
                'is_active'   => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}