<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('activity_logs')->insert([
            [
                'id'            => 1,
                'user_id'       => 2,  // Marie-Claire
                'action'        => 'created',
                'module'        => 'houses',
                'description'   => 'Created listing: Modern 4-Bedroom Villa in Kacyiru with Panoramic Kigali View',
                'subject_type'  => 'App\\Models\\House',
                'subject_id'    => 1,
                'properties'    => json_encode(['title' => 'Modern 4-Bedroom Villa in Kacyiru', 'price' => 85000000, 'status' => 'available']),
                'ip_address'    => '41.186.255.42',
                'user_agent'    => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at'    => now()->subDays(15),
                'updated_at'    => now(),
            ],
            [
                'id'            => 2,
                'user_id'       => 1,  // Jean-Pierre (Admin)
                'action'        => 'approved',
                'module'        => 'houses',
                'description'   => 'Approved house listing ID 1: Modern 4-Bedroom Villa in Kacyiru',
                'subject_type'  => 'App\\Models\\House',
                'subject_id'    => 1,
                'properties'    => json_encode(['approved_by' => 1, 'previous_status' => 'pending', 'new_status' => 'approved']),
                'ip_address'    => '41.186.255.10',
                'user_agent'    => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'created_at'    => now()->subDays(14),
                'updated_at'    => now(),
            ],
            [
                'id'            => 3,
                'user_id'       => 5,  // Eric
                'action'        => 'created',
                'module'        => 'lands',
                'description'   => 'Created listing: Prime Residential Plot in Nyagatovu — Kimironko, Gasabo',
                'subject_type'  => 'App\\Models\\Land',
                'subject_id'    => 1,
                'properties'    => json_encode(['title' => 'Prime Residential Plot in Nyagatovu', 'price' => 25000000, 'size_sqm' => 600]),
                'ip_address'    => '154.72.32.18',
                'user_agent'    => 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X)',
                'created_at'    => now()->subDays(12),
                'updated_at'    => now(),
            ],
            [
                'id'            => 4,
                'user_id'       => 4,  // Diane
                'action'        => 'purchased',
                'module'        => 'architectural_designs',
                'description'   => 'Purchased architectural design: 3-Bedroom Modern Bungalow — Kigali Style',
                'subject_type'  => 'App\\Models\\DesignOrder',
                'subject_id'    => 1,
                'properties'    => json_encode(['design_id' => 1, 'amount' => 150000, 'payment_status' => 'paid']),
                'ip_address'    => '196.44.198.22',
                'user_agent'    => 'Mozilla/5.0 (Linux; Android 13; Samsung Galaxy S23)',
                'created_at'    => now()->subDays(7),
                'updated_at'    => now(),
            ],
            [
                'id'            => 5,
                'user_id'       => 1,  // Jean-Pierre (Admin)
                'action'        => 'confirmed_payment',
                'module'        => 'advertisements',
                'description'   => 'Confirmed MoMo payment for advertisement: Premium Villa in Kacyiru — Own Your Dream Home Today',
                'subject_type'  => 'App\\Models\\Advertisement',
                'subject_id'    => 1,
                'properties'    => json_encode(['momo_transaction_id' => 'MTN20260715001', 'amount' => 35000, 'payment_method' => 'momo']),
                'ip_address'    => '41.186.255.10',
                'user_agent'    => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'created_at'    => now()->subDays(14),
                'updated_at'    => now(),
            ],
        ]);
    }
}