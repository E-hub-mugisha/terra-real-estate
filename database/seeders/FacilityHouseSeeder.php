<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilityHouseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('facility_house')->insert([
            ['house_id' => 1, 'facility_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 1, 'facility_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 1, 'facility_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 1, 'facility_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 1, 'facility_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 2, 'facility_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 2, 'facility_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 2, 'facility_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 3, 'facility_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 3, 'facility_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 3, 'facility_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 4, 'facility_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 5, 'facility_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 5, 'facility_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 5, 'facility_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['house_id' => 5, 'facility_id' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}