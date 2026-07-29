<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentCommissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agent_commissions')->insert([
            [
                'id'                          => 1,
                'agent_id'                    => 1, // Marie-Claire (Gold - 25%)
                'commissionable_type'         => 'App\\Models\\House',
                'commissionable_id'           => 1, // Kacyiru Villa
                'property_type'               => 'Villa',
                'property_title'              => 'Modern 4-Bedroom Villa in Kacyiru',
                'listing_package_id'          => 2,
                'listing_days'                => 60,
                'price_per_day'               => 1000.00,
                'discount_applied_pct'        => 0.00,
                'listing_fee_gross'           => 60000.00,
                'listing_fee_net'             => 60000.00,
                'listing_agent_pct'           => 25.00,
                'listing_commission'          => 15000.00,
                'sale_price'                  => 85000000.00,
                'agent_level_id'              => 3, // Gold
                'sale_commission_rate'        => 2.00,
                'sale_commission'             => 1700000.00,
                'listing_commission_status'   => 'paid',
                'sale_commission_status'      => 'pending',
                'listing_commission_paid_at'  => now()->subDays(14),
                'sale_commission_paid_at'     => null,
                'notes'                       => 'Listing commission paid. Sale commission pending property sale completion.',
                'created_at'                  => now()->subDays(15),
                'updated_at'                  => now(),
            ],
            [
                'id'                          => 2,
                'agent_id'                    => 2, // Eric (Silver - 20%)
                'commissionable_type'         => 'App\\Models\\Land',
                'commissionable_id'           => 1, // Nyagatovu Plot
                'property_type'               => 'Land',
                'property_title'              => 'Prime Residential Plot in Nyagatovu',
                'listing_package_id'          => 4,
                'listing_days'                => 60,
                'price_per_day'               => 800.00,
                'discount_applied_pct'        => 0.00,
                'listing_fee_gross'           => 48000.00,
                'listing_fee_net'             => 48000.00,
                'listing_agent_pct'           => 20.00,
                'listing_commission'          => 9600.00,
                'sale_price'                  => 25000000.00,
                'agent_level_id'              => 2, // Silver
                'sale_commission_rate'        => 1.50,
                'sale_commission'             => 375000.00,
                'listing_commission_status'   => 'paid',
                'sale_commission_status'      => 'pending',
                'listing_commission_paid_at'  => now()->subDays(10),
                'sale_commission_paid_at'     => null,
                'notes'                       => 'Listing commission paid. Awaiting sale completion.',
                'created_at'                  => now()->subDays(12),
                'updated_at'                  => now(),
            ],
            [
                'id'                          => 3,
                'agent_id'                    => 4, // Robert (Platinum - 30%)
                'commissionable_type'         => 'App\\Models\\House',
                'commissionable_id'           => 3, // Kimihurura Penthouse
                'property_type'               => 'Apartment',
                'property_title'              => 'Luxury Penthouse Apartment at Kimihurura Heights',
                'listing_package_id'          => 2,
                'listing_days'                => 60,
                'price_per_day'               => 1000.00,
                'discount_applied_pct'        => 0.00,
                'listing_fee_gross'           => 60000.00,
                'listing_fee_net'             => 60000.00,
                'listing_agent_pct'           => 30.00,
                'listing_commission'          => 18000.00,
                'sale_price'                  => 120000000.00,
                'agent_level_id'              => 4, // Platinum
                'sale_commission_rate'        => 2.50,
                'sale_commission'             => 3000000.00,
                'listing_commission_status'   => 'paid',
                'sale_commission_status'      => 'pending',
                'listing_commission_paid_at'  => now()->subDays(20),
                'sale_commission_paid_at'     => null,
                'notes'                       => 'High-value listing. Premium commission rate applied.',
                'created_at'                  => now()->subDays(22),
                'updated_at'                  => now(),
            ],
            [
                'id'                          => 4,
                'agent_id'                    => 5, // Anitha (Silver - 20%)
                'commissionable_type'         => 'App\\Models\\Land',
                'commissionable_id'           => 4, // Rubavu Lakefront
                'property_type'               => 'Land',
                'property_title'              => 'Lakefront Plot in Rubavu — Lake Kivu Views',
                'listing_package_id'          => 4,
                'listing_days'                => 60,
                'price_per_day'               => 800.00,
                'discount_applied_pct'        => 0.00,
                'listing_fee_gross'           => 48000.00,
                'listing_fee_net'             => 48000.00,
                'listing_agent_pct'           => 20.00,
                'listing_commission'          => 9600.00,
                'sale_price'                  => 45000000.00,
                'agent_level_id'              => 2, // Silver
                'sale_commission_rate'        => 1.50,
                'sale_commission'             => 675000.00,
                'listing_commission_status'   => 'paid',
                'sale_commission_status'      => 'approved',
                'listing_commission_paid_at'  => now()->subDays(8),
                'sale_commission_paid_at'     => null,
                'notes'                       => 'Sale approved. Payout scheduled for next payment cycle.',
                'created_at'                  => now()->subDays(10),
                'updated_at'                  => now(),
            ],
            [
                'id'                          => 5,
                'agent_id'                    => 1, // Marie-Claire (Gold - 25%)
                'commissionable_type'         => 'App\\Models\\House',
                'commissionable_id'           => 5, // Biryogo Double Storey
                'property_type'               => 'Double Storey',
                'property_title'              => 'New 5-Bedroom Double Storey in Biryogo',
                'listing_package_id'          => 2,
                'listing_days'                => 60,
                'price_per_day'               => 1000.00,
                'discount_applied_pct'        => 10.00,
                'listing_fee_gross'           => 60000.00,
                'listing_fee_net'             => 54000.00,
                'listing_agent_pct'           => 25.00,
                'listing_commission'          => 13500.00,
                'sale_price'                  => 65000000.00,
                'agent_level_id'              => 3, // Gold
                'sale_commission_rate'        => 2.00,
                'sale_commission'             => 1300000.00,
                'listing_commission_status'   => 'pending',
                'sale_commission_status'      => 'pending',
                'listing_commission_paid_at'  => null,
                'sale_commission_paid_at'     => null,
                'notes'                       => 'Duration discount of 10% applied for 60-day listing. Commission pending payment confirmation.',
                'created_at'                  => now()->subDays(2),
                'updated_at'                  => now(),
            ],
        ]);
    }
}