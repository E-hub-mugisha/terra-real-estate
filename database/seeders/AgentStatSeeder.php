<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentStatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agent_stats')->insert([
            [
                'id'                       => 1,
                'agent_id'                 => 1, // Marie-Claire
                'level_id'                 => 3, // Gold
                'total_referrals'          => 12,
                'total_revenue_generated'  => 28500000,
                'total_commissions_earned' => 4250000,
                'total_commissions_paid'   => 3450000,
                'pending_payout'           => 800000,
                'last_level_upgrade_at'    => now()->subDays(45),
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
            [
                'id'                       => 2,
                'agent_id'                 => 2, // Eric
                'level_id'                 => 2, // Silver
                'total_referrals'          => 7,
                'total_revenue_generated'  => 15200000,
                'total_commissions_earned' => 1896000,
                'total_commissions_paid'   => 960000,
                'pending_payout'           => 936000,
                'last_level_upgrade_at'    => now()->subDays(90),
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
            [
                'id'                       => 3,
                'agent_id'                 => 3, // Clarisse
                'level_id'                 => 1, // Bronze
                'total_referrals'          => 2,
                'total_revenue_generated'  => 4500000,
                'total_commissions_earned' => 675000,
                'total_commissions_paid'   => 0,
                'pending_payout'           => 675000,
                'last_level_upgrade_at'    => null,
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
            [
                'id'                       => 4,
                'agent_id'                 => 4, // Robert
                'level_id'                 => 4, // Platinum
                'total_referrals'          => 24,
                'total_revenue_generated'  => 65000000,
                'total_commissions_earned' => 12192000,
                'total_commissions_paid'   => 10000000,
                'pending_payout'           => 2192000,
                'last_level_upgrade_at'    => now()->subDays(120),
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
            [
                'id'                       => 5,
                'agent_id'                 => 5, // Anitha
                'level_id'                 => 2, // Silver
                'total_referrals'          => 5,
                'total_revenue_generated'  => 9800000,
                'total_commissions_earned' => 1960000,
                'total_commissions_paid'   => 960000,
                'pending_payout'           => 1000000,
                'last_level_upgrade_at'    => now()->subDays(60),
                'created_at'               => now(),
                'updated_at'               => now(),
            ],
        ]);
    }
}