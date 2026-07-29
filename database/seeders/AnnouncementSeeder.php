<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('announcements')->insert([
            [
                'id'                 => 1,
                'views_count'        => 2345,
                'unique_views_count' => 1876,
                'title'              => 'Terra Rwanda Official Launch — 50% Off All Listing Packages for July 2026',
                'slug'               => 'terra-rwanda-launch-50-percent-off-july-2026',
                'content'            => 'To celebrate the official launch of Terra Rwanda Property Exchange, we are offering 50% off all listing packages for the entire month of July 2026. List your house, land, or architectural design and reach thousands of verified buyers across Rwanda. This limited-time offer applies to all package tiers — Basic, Premium, and Developer. Use promo code TERRALAUNCH50 at checkout.',
                'status'             => 'active',
                'start_date'         => '2026-07-01',
                'end_date'           => '2026-07-31',
                'created_by'         => 1,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id'                 => 2,
                'views_count'        => 1234,
                'unique_views_count' => 987,
                'title'              => 'New: MoMo Payment Integration — List Your Property in Seconds',
                'slug'               => 'momo-payment-integration-listing',
                'content'            => 'Terra Rwanda now supports MTN MoMo payments for all listing packages. Simply select MoMo as your payment method, enter your phone number, and confirm the payment on your phone. No need to visit a bank or wait for manual confirmation. Your listing will be active within minutes of payment confirmation.',
                'status'             => 'active',
                'start_date'         => '2026-06-15',
                'end_date'           => '2026-12-31',
                'created_by'         => 1,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id'                 => 3,
                'views_count'        => 567,
                'unique_views_count' => 456,
                'title'              => 'Agent Verification Update — New Requirements Effective August 2026',
                'slug'               => 'agent-verification-update-august-2026',
                'content'            => 'Starting August 1, 2026, all agents on Terra Rwanda must provide a valid RLMUA registration number or RHA certification to maintain verified status. Unverified agents will have limited listing capabilities. Please upload your certification documents to your agent profile before the deadline to avoid any interruption in service.',
                'status'             => 'active',
                'start_date'         => '2026-07-15',
                'end_date'           => '2026-08-31',
                'created_by'         => 1,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id'                 => 4,
                'views_count'        => 890,
                'unique_views_count' => 712,
                'title'              => 'Free Architectural Design Downloads — Terra Rwanda Community Initiative',
                'slug'               => 'free-architectural-design-downloads-community',
                'content'            => 'As part of our commitment to making quality housing accessible to all Rwandans, Terra Rwanda is now offering free starter house plan designs. These designs are compliant with the Rwanda Building Code and are perfect for first-time homeowners building on R1 residential plots. Download your free plan today and start building your dream home.',
                'status'             => 'active',
                'start_date'         => '2026-05-01',
                'end_date'           => '2026-12-31',
                'created_by'         => 1,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id'                 => 5,
                'views_count'        => 345,
                'unique_views_count' => 289,
                'title'              => 'Scheduled Maintenance — Platform Downtime on August 2, 2026 (2AM-6AM)',
                'slug'               => 'scheduled-maintenance-august-2026',
                'content'            => 'Terra Rwanda will undergo scheduled maintenance on August 2, 2026, from 2:00 AM to 6:00 AM CAT. During this time, the platform will be temporarily unavailable for listing submissions, payments, and agent dashboard access. We apologize for the inconvenience and recommend completing any pending transactions before the maintenance window.',
                'status'             => 'active',
                'start_date'         => '2026-07-28',
                'end_date'           => '2026-08-03',
                'created_by'         => 1,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ]);
    }
}