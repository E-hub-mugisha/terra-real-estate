<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultantUnavailableDateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultant_unavailable_dates')->insert([
            [
                'id'             => 1,
                'consultant_id'  => 1, // Patrick - Surveyor
                'date'           => now()->addDays(1)->format('Y-m-d'),
                'reason'         => 'Field survey in Musanze — full day commitment',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 2,
                'consultant_id'  => 2, // Aimable - Attorney
                'date'           => now()->addDays(5)->format('Y-m-d'),
                'reason'         => 'Court appearance at Kigali Commercial Court',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 3,
                'consultant_id'  => 3, // Grace - Architect
                'date'           => now()->addDays(3)->format('Y-m-d'),
                'reason'         => 'RIA annual conference — Kigali Convention Centre',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 4,
                'consultant_id'  => 4, // Théogène - Engineer
                'date'           => now()->addDays(7)->format('Y-m-d'),
                'reason'         => 'RHA training workshop on updated building code',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 5,
                'consultant_id'  => 1, // Patrick - Surveyor
                'date'           => now()->addDays(12)->format('Y-m-d'),
                'reason'         => 'RLMUA stakeholder meeting — Kigali headquarters',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}