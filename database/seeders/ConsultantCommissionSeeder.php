<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultantCommissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultant_commissions')->insert([
            [
                'id'                     => 1,
                'consultant_id'          => 1, // Patrick
                'client_id'              => 1, // Jean-Bosco
                'service_description'    => 'Cadastral survey — Nyagatovu residential plot',
                'service_value'          => 150000,
                'commission_tier_id'     => 3, // Professional Tier
                'terra_commission_pct'   => 20.00,
                'consultant_payout_pct'  => 80.00,
                'terra_commission_amount'=> 30000,
                'consultant_payout_amount'=> 120000,
                'status'                 => 'paid',
                'confirmed_at'           => now()->subDays(8),
                'paid_at'                => now()->subDays(5),
                'notes'                  => 'Survey completed and paid. RLMUA documentation submitted.',
                'created_at'             => now()->subDays(12),
                'updated_at'             => now(),
            ],
            [
                'id'                     => 2,
                'consultant_id'          => 2, // Aimable
                'client_id'              => 4, // Diane
                'service_description'    => 'Title deed transfer — Nyamata property',
                'service_value'          => 85000,
                'commission_tier_id'     => 2, // Growth Tier
                'terra_commission_pct'   => 25.00,
                'consultant_payout_pct'  => 75.00,
                'terra_commission_amount'=> 21250,
                'consultant_payout_amount'=> 63750,
                'status'                 => 'pending',
                'confirmed_at'           => null,
                'paid_at'                => null,
                'notes'                  => 'Title transfer in progress. Awaiting RLMUA processing.',
                'created_at'             => now()->subDays(5),
                'updated_at'             => now(),
            ],
            [
                'id'                     => 3,
                'consultant_id'          => 3, // Grace
                'client_id'              => 2, // linked to agent
                'service_description'    => 'Custom house plan — 4-bedroom villa Kacyiru',
                'service_value'          => 350000,
                'commission_tier_id'     => 3, // Professional Tier
                'terra_commission_pct'   => 20.00,
                'consultant_payout_pct'  => 80.00,
                'terra_commission_amount'=> 70000,
                'consultant_payout_amount'=> 280000,
                'status'                 => 'confirmed',
                'confirmed_at'           => now()->subDays(10),
                'paid_at'                => null,
                'notes'                  => 'Design completed and delivered. Payout scheduled for next cycle.',
                'created_at'             => now()->subDays(18),
                'updated_at'             => now(),
            ],
            [
                'id'                     => 4,
                'consultant_id'          => 1, // Patrick
                'client_id'              => 1, // Jean-Pierre
                'service_description'    => 'Commercial plot cadastral survey — KN 3 Road',
                'service_value'          => 200000,
                'commission_tier_id'     => 3, // Professional Tier
                'terra_commission_pct'   => 20.00,
                'consultant_payout_pct'  => 80.00,
                'terra_commission_amount'=> 40000,
                'consultant_payout_amount'=> 160000,
                'status'                 => 'paid',
                'confirmed_at'           => now()->subDays(17),
                'paid_at'                => now()->subDays(12),
                'notes'                  => 'Commercial survey completed. Higher fee applied due to complexity.',
                'created_at'             => now()->subDays(22),
                'updated_at'             => now(),
            ],
            [
                'id'                     => 5,
                'consultant_id'          => 4, // Théogène
                'client_id'              => 2, // Chantal
                'service_description'    => 'Structural inspection — Rubavu building under construction',
                'service_value'          => 50000,
                'commission_tier_id'     => 1, // Starter Tier
                'terra_commission_pct'   => 30.00,
                'consultant_payout_pct'  => 70.00,
                'terra_commission_amount'=> 15000,
                'consultant_payout_amount'=> 35000,
                'status'                 => 'pending',
                'confirmed_at'           => null,
                'paid_at'                => null,
                'notes'                  => 'Inspection in progress. Report pending.',
                'created_at'             => now()->subDays(3),
                'updated_at'             => now(),
            ],
        ]);
    }
}