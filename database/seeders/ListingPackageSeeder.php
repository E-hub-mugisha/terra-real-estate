<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ListingPackageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('listing_packages')->insert([
            [
                'id'                   => 1,
                'listing_type'         => 'house',
                'package_tier'         => 'basic',
                'price_per_day'        => 500,
                'agent_commission_pct' => 15.00,
                'terra_share_pct'      => 85.00,
                'features'             => '3 images, 30 days, standard placement',
                'is_active'            => 1,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'id'                   => 2,
                'listing_type'         => 'house',
                'package_tier'         => 'premium',
                'price_per_day'        => 1000,
                'agent_commission_pct' => 20.00,
                'terra_share_pct'      => 80.00,
                'features'             => '10 images, 60 days, featured placement, video',
                'is_active'            => 1,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'id'                   => 3,
                'listing_type'         => 'land',
                'package_tier'         => 'basic',
                'price_per_day'        => 400,
                'agent_commission_pct' => 15.00,
                'terra_share_pct'      => 85.00,
                'features'             => '3 images, 30 days, standard placement',
                'is_active'            => 1,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'id'                   => 4,
                'listing_type'         => 'land',
                'package_tier'         => 'premium',
                'price_per_day'        => 800,
                'agent_commission_pct' => 20.00,
                'terra_share_pct'      => 80.00,
                'features'             => '10 images, 60 days, featured placement, video',
                'is_active'            => 1,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'id'                   => 5,
                'listing_type'         => 'architectural_design',
                'package_tier'         => 'standard',
                'price_per_day'        => 300,
                'agent_commission_pct' => 15.00,
                'terra_share_pct'      => 85.00,
                'features'             => '5 preview images, 30 days, design file hosting',
                'is_active'            => 1,
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ]);
    }
}