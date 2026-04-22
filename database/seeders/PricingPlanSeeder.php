<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use Illuminate\Database\Seeder;

class PricingPlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            // 1 — Free
            [
                'name'             => 'Free',
                'description'      => 'Get started at no cost. List your property on Imari and reach thousands of buyers and renters across Rwanda. The Free plan is perfect for individual landlords and first-time sellers who want basic visibility without any upfront investment. Your listing will appear in standard search results with up to 3 photos.',
                'price_per_day'    => 0.00,
                'max_images'       => 3,
                'featured'         => false,
                'priority_listing' => false,
                'show_on_homepage' => false,
                'active'           => true,
            ],

            // 2 — Basic
            [
                'name'             => 'Basic',
                'description'      => 'Upgrade to the Basic plan for enhanced visibility at an affordable daily rate. Your listing will appear higher in search results with up to 8 photos to showcase your property. Ideal for landlords and small agencies looking to attract more enquiries without a large marketing budget. Includes a "Basic" badge on your listing.',
                'price_per_day'    => 1500.00, // RWF per day
                'max_images'       => 8,
                'featured'         => false,
                'priority_listing' => false,
                'show_on_homepage' => false,
                'active'           => true,
            ],

            // 3 — Standard
            [
                'name'             => 'Standard',
                'description'      => 'The Standard plan gives your property significantly boosted exposure across the Imari platform. Listings are prioritised in search results, support up to 15 high-resolution photos, and are displayed with a "Standard" badge. Standard listings also receive periodic promotion via Imari\'s social media channels. Recommended for agents and developers with active portfolios.',
                'price_per_day'    => 4000.00,
                'max_images'       => 15,
                'featured'         => false,
                'priority_listing' => true,
                'show_on_homepage' => false,
                'active'           => true,
            ],

            // 4 — Premium
            [
                'name'             => 'Premium',
                'description'      => 'The Premium plan is designed for serious sellers and agents who want maximum results. Your listing is marked as Featured, placed in the priority search index, and displayed in the dedicated Featured Properties section on the Imari homepage. Supports up to 25 photos, a video embed link, and a virtual tour URL. Premium listings receive a dedicated account manager and weekly performance reports.',
                'price_per_day'    => 9000.00,
                'max_images'       => 25,
                'featured'         => true,
                'priority_listing' => true,
                'show_on_homepage' => true,
                'active'           => true,
            ],

            // 5 — Elite (top tier)
            [
                'name'             => 'Elite',
                'description'      => 'The Elite plan is Imari\'s most powerful listing package, reserved for flagship properties and top-performing agencies. Elite listings are pinned at the very top of all relevant search results, prominently featured on the homepage hero carousel, and promoted via targeted email campaigns to Imari\'s verified buyer and investor database. Includes unlimited photos, a 3D virtual tour embed, a dedicated landing page, and fortnightly consultation calls with the Imari marketing team.',
                'price_per_day'    => 20000.00,
                'max_images'       => 100,
                'featured'         => true,
                'priority_listing' => true,
                'show_on_homepage' => true,
                'active'           => true,
            ],

            // 6 — Agent Spotlight (agent-profile promotion, not a property plan)
            [
                'name'             => 'Agent Spotlight',
                'description'      => 'The Agent Spotlight plan promotes the agent\'s profile — not just a single property — across the Imari platform. The agent\'s profile card is featured on the Find an Agent homepage section, their listings receive a priority boost in search, and they receive a verified spotlight badge. Ideal for agents building their personal brand on Imari. Includes up to 20 images per listing and monthly analytics on profile views and enquiry conversion.',
                'price_per_day'    => 6500.00,
                'max_images'       => 20,
                'featured'         => true,
                'priority_listing' => true,
                'show_on_homepage' => true,
                'active'           => true,
            ],

            // 7 — Developer Pack (for multi-unit projects)
            [
                'name'             => 'Developer Pack',
                'description'      => 'Built for property developers launching multi-unit projects such as apartment blocks, gated estates, or commercial complexes. The Developer Pack allows a single project to be listed as a development with individual units beneath it, each with its own photos and pricing. The parent project listing appears in the Homepage New Developments section, and the developer receives a dedicated project microsite on the Imari platform. Supports unlimited images across the project.',
                'price_per_day'    => 35000.00,
                'max_images'       => 100,
                'featured'         => true,
                'priority_listing' => true,
                'show_on_homepage' => true,
                'active'           => true,
            ],

            // 8 — Inactive legacy plan (kept for historical orders)
            [
                'name'             => 'Starter Pro (Legacy)',
                'description'      => 'This plan has been retired and is no longer available for new subscriptions. It was an introductory plan offered during Imari\'s beta launch phase. Existing active orders under this plan will be honoured until their expiry date. Subscribers are encouraged to migrate to the Basic or Standard plan to continue enjoying enhanced features.',
                'price_per_day'    => 2500.00,
                'max_images'       => 10,
                'featured'         => false,
                'priority_listing' => false,
                'show_on_homepage' => false,
                'active'           => false,
            ],
        ];

        foreach ($plans as $plan) {
            PricingPlan::firstOrCreate(
                ['name' => $plan['name']],
                $plan
            );
        }
    }
}