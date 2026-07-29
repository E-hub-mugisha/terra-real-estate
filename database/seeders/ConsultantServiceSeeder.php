<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultantServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultant_service')->insert([
            ['consultant_id' => 1, 'service_id' => 2, 'price' => 150000.00, 'created_at' => now(), 'updated_at' => now()], // Patrick → Land Survey
            ['consultant_id' => 2, 'service_id' => 3, 'price' => 85000.00,  'created_at' => now(), 'updated_at' => now()], // Aimable → Title Deed
            ['consultant_id' => 3, 'service_id' => 5, 'price' => 350000.00, 'created_at' => now(), 'updated_at' => now()], // Grace → Architecture
            ['consultant_id' => 4, 'service_id' => 4, 'price' => 50000.00,  'created_at' => now(), 'updated_at' => now()], // Théogène → Construction
            ['consultant_id' => 5, 'service_id' => 2, 'price' => 100000.00, 'created_at' => now(), 'updated_at' => now()], // Valérie → Valuation (using survey service)
        ]);
    }
}