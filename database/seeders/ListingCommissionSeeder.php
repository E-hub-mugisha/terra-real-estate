<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingCommissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('listing_commissions')->insert([
            [
                'id'                      => 1,
                'listing_id'              => 1,
                'agent_id'                => 1,  // Marie-Claire
                'listing_package_id'      => 2,
                'listing_type'            => 'house',
                'package_tier'            => 'premium',
                'net_listing_amount'      => 60000,
                'agent_commission_pct'    => 25.00,
                'agent_commission_amount' => 15000,
                'terra_share_amount'      => 45000,
                'agent_level'             => 'gold',
                'performance_bonus_pct'   => 0.00,
                'performance_bonus_amount'=> 0,
                'total_agent_payout'      => 15000,
                'status'                  => 'paid',
                'confirmed_at'            => now()->subDays(14),
                'paid_at'                 => now()->subDays(12),
                'notes'                   => 'Gold agent commission — 25% of net listing amount.',
                'created_at'              => now()->subDays(15),
                'updated_at'              => now(),
            ],
            [
                'id'                      => 2,
                'listing_id'              => 2,
                'agent_id'                => 2,  // Eric
                'listing_package_id'      => 4,
                'listing_type'            => 'land',
                'package_tier'            => 'premium',
                'net_listing_amount'      => 48000,
                'agent_commission_pct'    => 20.00,
                'agent_commission_amount' => 9600,
                'terra_share_amount'      => 38400,
                'agent_level'             => 'silver',
                'performance_bonus_pct'   => 0.00,
                'performance_bonus_amount'=> 0,
                'total_agent_payout'      => 9600,
                'status'                  => 'paid',
                'confirmed_at'            => now()->subDays(10),
                'paid_at'                 => now()->subDays(8),
                'notes'                   => 'Silver agent commission — 20% of net listing amount.',
                'created_at'              => now()->subDays(12),
                'updated_at'              => now(),
            ],
            [
                'id'                      => 3,
                'listing_id'              => 3,
                'agent_id'                => 4,  // Robert
                'listing_package_id'      => 2,
                'listing_type'            => 'house',
                'package_tier'            => 'premium',
                'net_listing_amount'      => 60000,
                'agent_commission_pct'    => 30.00,
                'agent_commission_amount' => 18000,
                'terra_share_amount'      => 42000,
                'agent_level'             => 'platinum',
                'performance_bonus_pct'   => 2.00,
                'performance_bonus_amount'=> 1200,
                'total_agent_payout'      => 19200,
                'status'                  => 'paid',
                'confirmed_at'            => now()->subDays(20),
                'paid_at'                 => now()->subDays(18),
                'notes'                   => 'Platinum agent commission — 30% + 2% performance bonus for exceeding quarterly target.',
                'created_at'              => now()->subDays(22),
                'updated_at'              => now(),
            ],
            [
                'id'                      => 4,
                'listing_id'              => 4,
                'agent_id'                => 5,  // Anitha
                'listing_package_id'      => 4,
                'listing_type'            => 'land',
                'package_tier'            => 'premium',
                'net_listing_amount'      => 48000,
                'agent_commission_pct'    => 20.00,
                'agent_commission_amount' => 9600,
                'terra_share_amount'      => 38400,
                'agent_level'             => 'silver',
                'performance_bonus_pct'   => 0.00,
                'performance_bonus_amount'=> 0,
                'total_agent_payout'      => 9600,
                'status'                  => 'pending',
                'confirmed_at'            => null,
                'paid_at'                 => null,
                'notes'                   => 'Pending confirmation — awaiting payment verification.',
                'created_at'              => now()->subDays(10),
                'updated_at'              => now(),
            ],
            [
                'id'                      => 5,
                'listing_id'              => 5,
                'agent_id'                => 1,  // Marie-Claire
                'listing_package_id'      => 5,
                'listing_type'            => 'architectural_design',
                'package_tier'            => 'standard',
                'net_listing_amount'      => 9000,
                'agent_commission_pct'    => 25.00,
                'agent_commission_amount' => 2250,
                'terra_share_amount'      => 6750,
                'agent_level'             => 'gold',
                'performance_bonus_pct'   => 0.00,
                'performance_bonus_amount'=> 0,
                'total_agent_payout'      => 2250,
                'status'                  => 'pending',
                'confirmed_at'            => null,
                'paid_at'                 => null,
                'notes'                   => 'Design listing commission — pending approval.',
                'created_at'              => now()->subDays(6),
                'updated_at'              => now(),
            ],
        ]);
    }
}