<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agent_service')->insert([
            ['agent_id' => 1, 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()], // Marie-Claire → House Sales
            ['agent_id' => 1, 'service_id' => 2, 'created_at' => now(), 'updated_at' => now()], // Marie-Claire → Land Survey
            ['agent_id' => 2, 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()], // Eric → House Sales
            ['agent_id' => 2, 'service_id' => 3, 'created_at' => now(), 'updated_at' => now()], // Eric → Title Deed
            ['agent_id' => 4, 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()], // Robert → House Sales
            ['agent_id' => 4, 'service_id' => 5, 'created_at' => now(), 'updated_at' => now()], // Robert → Architecture
            ['agent_id' => 5, 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()], // Anitha → House Sales
            ['agent_id' => 5, 'service_id' => 4, 'created_at' => now(), 'updated_at' => now()], // Anitha → Construction
            ['agent_id' => 3, 'service_id' => 1, 'created_at' => now(), 'updated_at' => now()], // Clarisse → House Sales
        ]);
    }
}