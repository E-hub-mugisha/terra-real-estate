<?php

namespace Database\Seeders;

use App\Models\Advertisement;
use App\Models\Agent;
use App\Models\House;
use App\Models\Land;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    public function run(): void
    {
        // Resolve agents by email
        $agent = fn(string $email) => Agent::where('email', $email)->first();

        // Resolve first available houses and lands by title (adjust if needed)
        $house = fn(string $title) => House::where('title', 'like', "%{$title}%")->first();
        $land  = fn(string $title) => Land::where('title', 'like', "%{$title}%")->first();

        $advertisements = [

            // ─── FEATURED ────────────────────────────────────────────────────

            [
                'agent'            => $agent('claudine.uwimana@imari.rw'),
                'advertisable'     => $house('Modern Villa in Kiyovu'),
                'ad_type'          => 'featured',
                'title'            => 'Featured: Stunning Modern Villa in Kiyovu — Your Dream Home Awaits',
                'description'      => 'This premium featured listing puts one of Kigali\'s most sought-after villas in Kiyovu directly in front of thousands of serious buyers. Nestled in the diplomatic quarter with 5 bedrooms, a landscaped garden, and panoramic city views, this property represents the best of contemporary Kigali living. Contact Claudine Uwimana today to arrange a private viewing.',
                'banner_image'     => 'ads/banners/featured-kiyovu-villa.jpg',
                'price'            => 350000.00,
                'start_date'       => now()->toDateString(),
                'end_date'         => now()->addDays(30)->toDateString(),
                'status'           => 'active',
            ],

            [
                'agent'            => $agent('jp.habimana@imari.rw'),
                'advertisable'     => $house('Commercial Building in Downtown Kigali'),
                'ad_type'          => 'featured',
                'title'            => 'Featured: Prime CBD Commercial Building — Exceptional Investment Opportunity',
                'description'      => 'A landmark commercial building on KN 3 Avenue in the Kigali CBD is now available for acquisition. Comprising ground-floor retail and four floors of office space with a rooftop conference facility, this asset offers compelling yields in Rwanda\'s fastest-growing commercial district. Enquire with Jean-Pierre Habimana for financials and a site visit.',
                'banner_image'     => 'ads/banners/featured-cbd-commercial.jpg',
                'price'            => 500000.00,
                'start_date'       => now()->toDateString(),
                'end_date'         => now()->addDays(45)->toDateString(),
                'status'           => 'active',
            ],

            // ─── SPOTLIGHT ───────────────────────────────────────────────────

            [
                'agent'            => $agent('solange.ineza@imari.rw'),
                'advertisable'     => $house('Lakeside Cottage in Gisenyi'),
                'ad_type'          => 'spotlight',
                'title'            => 'Spotlight: Rare Lakeside Cottage on Lake Kivu — Beach Access Included',
                'description'      => 'An extraordinary opportunity to own a charming lakeside cottage with direct beach access on the shores of Lake Kivu in Rubavu. Wake up to volcanic mountain views across the Congo border. A perfect private retreat or high-yield short-let investment in Rwanda\'s most scenic location. Exclusively listed with Solange Ineza.',
                'banner_image'     => 'ads/banners/spotlight-lake-kivu-cottage.jpg',
                'price'            => 220000.00,
                'start_date'       => now()->toDateString(),
                'end_date'         => now()->addDays(21)->toDateString(),
                'status'           => 'active',
            ],

            [
                'agent'            => $agent('e.mugabo@imari.rw'),
                'advertisable'     => $house('Luxury Penthouse in Nyarutarama'),
                'ad_type'          => 'spotlight',
                'title'            => 'Spotlight: Nyarutarama Penthouse — Kigali\'s Finest Address',
                'description'      => 'The ultimate penthouse in Kigali\'s most exclusive enclave is seeking a discerning buyer. Smart home automation, private rooftop pool, cinema room, and chef\'s kitchen — all steps from the Golf Club. This is a once-in-a-generation opportunity for serious luxury buyers and diaspora investors. Represented by Emmanuel Mugabo, diaspora investment specialist.',
                'banner_image'     => 'ads/banners/spotlight-nyarutarama-penthouse.jpg',
                'price'            => 480000.00,
                'start_date'       => now()->subDays(2)->toDateString(),
                'end_date'         => now()->addDays(28)->toDateString(),
                'status'           => 'active',
            ],

            // ─── BANNER ──────────────────────────────────────────────────────

            [
                'agent'            => $agent('aline.murekatete@imari.rw'),
                'advertisable'     => $house('Furnished Apartment in Kimihurura'),
                'ad_type'          => 'banner',
                'title'            => 'Banner: Fully Furnished 3-Bed in Kimihurura — Move In Today',
                'description'      => 'A beautifully furnished 3-bedroom apartment in Kimihurura\'s diplomatic zone is available for immediate occupancy. High-speed internet, rooftop terrace, 24/7 security, and standby generator — everything you need for a seamless Kigali living experience. Managed by Aline Murekatete, Kigali\'s trusted property management specialist.',
                'banner_image'     => 'ads/banners/banner-kimihurura-apartment.jpg',
                'price'            => 180000.00,
                'start_date'       => now()->toDateString(),
                'end_date'         => now()->addDays(14)->toDateString(),
                'status'           => 'active',
            ],

            [
                'agent'            => $agent('bosco.niyonzima@imari.rw'),
                'advertisable'     => $land('Industrial Plot in Bugesera'),
                'ad_type'          => 'banner',
                'title'            => 'Banner: Fully Serviced Industrial Plot in Bugesera SEZ — 10,000 m²',
                'description'      => 'A fully serviced 10,000 m² industrial plot within the Bugesera Special Economic Zone is now available for acquisition. Located adjacent to the new international airport, with three-phase electricity, industrial water supply, and tax incentives under Rwanda\'s SEZ framework. Ideal for manufacturing, cold storage, or logistics. Contact Bosco Niyonzima.',
                'banner_image'     => 'ads/banners/banner-bugesera-industrial.jpg',
                'price'            => 270000.00,
                'start_date'       => now()->toDateString(),
                'end_date'         => now()->addDays(30)->toDateString(),
                'status'           => 'active',
            ],

            // ─── BOOST ───────────────────────────────────────────────────────

            [
                'agent'            => $agent('patrick.nshimiyimana@imari.rw'),
                'advertisable'     => $land('Gated Estate Plot in Gahanga'),
                'ad_type'          => 'boost',
                'title'            => 'Boost: Affordable Plot in Gahanga Gated Estate — From RWF 22M',
                'description'      => 'Secure your residential plot in Kicukiro\'s fastest-growing gated estate before prices rise further. Paved internal roads, perimeter wall, and borehole water already in place. Just 15 minutes from Kigali CBD on the Kigali–Huye highway. Patrick Nshimiyimana is on hand to walk you through the RLMUA title process step by step.',
                'banner_image'     => 'ads/banners/boost-gahanga-plot.jpg',
                'price'            => 85000.00,
                'start_date'       => now()->toDateString(),
                'end_date'         => now()->addDays(10)->toDateString(),
                'status'           => 'active',
            ],

            [
                'agent'            => $agent('aline.murekatete@imari.rw'),
                'advertisable'     => $house('Townhouse in Kacyiru'),
                'ad_type'          => 'boost',
                'title'            => 'Boost: Kacyiru Townhouse in Gated Community — RWF 950K/month',
                'description'      => 'A well-maintained 4-bedroom townhouse within a secure Kacyiru estate is available for rent now. Shared pool, children\'s play area, and walking distance to Parliament and the ministry quarter. Perfect for senior government officials, diplomats, or NGO staff. Managed by Aline Murekatete.',
                'banner_image'     => 'ads/banners/boost-kacyiru-townhouse.jpg',
                'price'            => 65000.00,
                'start_date'       => now()->subDays(1)->toDateString(),
                'end_date'         => now()->addDays(9)->toDateString(),
                'status'           => 'active',
            ],

            // ─── PENDING ─────────────────────────────────────────────────────

            [
                'agent'            => $agent('diane.ishimwe@imari.rw'),
                'advertisable'     => $land('Mixed-Use Plot Near University of Rwanda'),
                'ad_type'          => 'featured',
                'title'            => 'Featured: Mixed-Use Plot Near University of Rwanda, Huye — Investor\'s Pick',
                'description'      => 'A rare mixed-use plot 500 m from the University of Rwanda main campus in Huye — ideal for student accommodation, a hostel, or retail block. High footfall, mains utilities, and a clear freehold title. Southern Province\'s most compelling development opportunity this year. Submitted by Diane Ishimwe, pending admin approval.',
                'banner_image'     => 'ads/banners/pending-huye-plot.jpg',
                'price'            => 300000.00,
                'start_date'       => now()->addDays(3)->toDateString(),
                'end_date'         => now()->addDays(33)->toDateString(),
                'status'           => 'pending',
            ],

            // ─── EXPIRED ─────────────────────────────────────────────────────

            [
                'agent'            => $agent('bosco.niyonzima@imari.rw'),
                'advertisable'     => $house('Family Home in Remera'),
                'ad_type'          => 'spotlight',
                'title'            => 'Spotlight: Remera Family Home with Solar & Borehole — SOLD',
                'description'      => 'This spotlight campaign for a 4-bedroom family home in Remera has now concluded. The property attracted strong interest due to its solar panels, borehole water supply, and proximity to Kigali International Airport. The listing has been marked as sold. Bosco Niyonzima thanks all enquirers for their interest.',
                'banner_image'     => 'ads/banners/expired-remera-house.jpg',
                'price'            => 150000.00,
                'start_date'       => now()->subDays(30)->toDateString(),
                'end_date'         => now()->subDays(2)->toDateString(),
                'status'           => 'expired',
            ],
        ];

        foreach ($advertisements as $entry) {
            $agent        = $entry['agent'];
            $advertisable = $entry['advertisable'];

            // Skip if agent or advertisable model was not found in DB
            if (! $agent || ! $advertisable) {
                continue;
            }

            Advertisement::firstOrCreate(
                [
                    'agent_id'          => $agent->id,
                    'advertisable_type' => get_class($advertisable),
                    'advertisable_id'   => $advertisable->id,
                    'ad_type'           => $entry['ad_type'],
                ],
                [
                    'title'        => $entry['title'],
                    'description'  => $entry['description'],
                    'banner_image' => $entry['banner_image'],
                    'price'        => $entry['price'],
                    'start_date'   => $entry['start_date'],
                    'end_date'     => $entry['end_date'],
                    'status'       => $entry['status'],
                ]
            );
        }
    }
}