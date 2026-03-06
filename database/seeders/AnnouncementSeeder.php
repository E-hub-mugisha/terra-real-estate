<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            // 1 — Active: Platform launch
            [
                'title'      => 'Welcome to Imari — Rwanda\'s New Property Marketplace',
                'content'    => 'We are thrilled to announce the official launch of Imari, Rwanda\'s most comprehensive online property marketplace. Whether you are buying, selling, or renting residential and commercial properties, or searching for prime land across all five provinces, Imari connects you with verified agents, certified professionals, and thousands of listings updated daily. Create your free account today to save searches, receive instant alerts, and connect directly with property owners and agents. We look forward to transforming how Rwanda transacts in real estate.',
                'status'     => 'active',
                'start_date' => now()->subDays(5)->toDateString(),
                'end_date'   => now()->addDays(30)->toDateString(),
                'created_by' => 1,
            ],

            // 2 — Active: New agent verification programme
            [
                'title'      => 'Introducing Verified Agent Badges — Raising the Bar for Rwandan Real Estate',
                'content'    => 'Imari is proud to launch its Agent Verification Programme. All agents displaying the blue "Verified" badge have submitted valid national ID, proof of professional registration, and undergone a background screening conducted in partnership with the Rwanda Investigation Bureau (RIB). Verified agents are also required to adhere to Imari\'s Code of Conduct, which prohibits double-commission practices, misleading listing descriptions, and undisclosed conflicts of interest. Look for the badge when choosing your agent — your security is our priority.',
                'status'     => 'active',
                'start_date' => now()->subDays(3)->toDateString(),
                'end_date'   => now()->addDays(60)->toDateString(),
                'created_by' => 1,
            ],

            // 3 — Active: Kigali property expo
            [
                'title'      => 'Imari at the Kigali Real Estate & Construction Expo 2025',
                'content'    => 'Imari will be exhibiting at the Kigali Real Estate & Construction Expo taking place at the Kigali Convention Centre from 14–16 August 2025. Visit us at Stand B-07 to meet our team, explore our premium listing packages, and attend our panel discussion on "Digital Innovation in Rwanda\'s Property Market" scheduled for 15 August at 11:00 AM. The expo is free to attend and open to property buyers, investors, developers, and industry professionals. Register your interest at the expo website.',
                'status'     => 'active',
                'start_date' => now()->addDays(2)->toDateString(),
                'end_date'   => now()->addDays(45)->toDateString(),
                'created_by' => 1,
            ],

            // 4 — Active: Free listing promotion
            [
                'title'      => 'Limited Offer: List Your Property for Free — July 2025',
                'content'    => 'Throughout July 2025, all new property owners and landlords joining Imari can list up to three properties at absolutely no cost. This includes houses, apartments, land, and commercial properties. Each free listing includes full photo upload, map pin, description, contact details, and visibility in our standard search results. To take advantage of this offer, register your account before 31 July 2025 and use the promo code IMARI-FREE at the listing checkout. Terms and conditions apply — offer valid for individual landlords only, not agencies.',
                'status'     => 'active',
                'start_date' => now()->toDateString(),
                'end_date'   => now()->addDays(31)->toDateString(),
                'created_by' => 1,
            ],

            // 5 — Active: Platform maintenance notice
            [
                'title'      => 'Scheduled Maintenance — Sunday 20 July 2025, 02:00–06:00 AM',
                'content'    => 'Imari will undergo scheduled platform maintenance on Sunday 20 July 2025 between 02:00 AM and 06:00 AM (East Africa Time). During this window, the website and mobile application will be temporarily unavailable. We apologise for any inconvenience this may cause. The maintenance is necessary to deploy infrastructure upgrades that will significantly improve platform speed, search performance, and map loading times. All data will be fully preserved. If you have urgent enquiries, please contact our support team via WhatsApp on +250 788 000 100 before or after the maintenance window.',
                'status'     => 'active',
                'start_date' => now()->addDays(1)->toDateString(),
                'end_date'   => now()->addDays(15)->toDateString(),
                'created_by' => 1,
            ],

            // 6 — Active: New professional directory feature
            [
                'title'      => 'New Feature: Find Architects, Lawyers & Surveyors on Imari',
                'content'    => 'Imari has launched its Professional Services Directory — a curated marketplace of verified architects, structural engineers, land surveyors, property valuers, building contractors, real estate lawyers, interior designers, MEP engineers, landscape architects, and urban planners. Every professional listed has submitted their RCIC, REB, RLMUA, or RBA registration certificate for verification. You can now search professionals by discipline, location, language, and years of experience, read client reviews, and request a quote — all directly through the Imari platform. Navigate to the "Professionals" section to explore.',
                'status'     => 'active',
                'start_date' => now()->subDays(1)->toDateString(),
                'end_date'   => now()->addDays(90)->toDateString(),
                'created_by' => 1,
            ],

            // 7 — Active: Tender module launch
            [
                'title'      => 'Imari Tenders: Construction & Property Procurement Notices Now Live',
                'content'    => 'We are pleased to announce the launch of Imari Tenders, a dedicated section for construction and property-related procurement notices from government institutions, districts, parastatals, and private developers across Rwanda. Contractors, consultants, and suppliers can now browse open tenders, download bidding documents, and set up alerts for tender categories matching their expertise. Institutions wishing to publish tender notices on Imari can contact our business team at tenders@imari.rw for competitive publishing packages. All tenders are displayed exactly as submitted by the procuring entities.',
                'status'     => 'active',
                'start_date' => now()->subDays(2)->toDateString(),
                'end_date'   => now()->addDays(120)->toDateString(),
                'created_by' => 1,
            ],

            // 8 — Inactive (draft): Upcoming mortgage partner
            [
                'title'      => 'Coming Soon: Apply for a Home Loan Directly on Imari',
                'content'    => 'Imari is partnering with three leading Rwandan commercial banks to bring mortgage pre-qualification and home loan applications directly within the platform. Soon, when you find your ideal property on Imari, you will be able to calculate your monthly repayments, check your eligibility, and submit a loan application — all without leaving the page. Our banking partners will be announced at the Kigali Real Estate Expo in August. Stay tuned for this exciting development that will make home ownership more accessible than ever for Rwandans.',
                'status'     => 'inactive',
                'start_date' => now()->addDays(40)->toDateString(),
                'end_date'   => now()->addDays(120)->toDateString(),
                'created_by' => 1,
            ],

            // 9 — Expired: Early-adopter discount
            [
                'title'      => 'Early Adopter Discount — 50% Off Premium Listings (Expired)',
                'content'    => 'As a thank-you to our founding users, Imari offered a 50% discount on all Premium and Featured Listing packages throughout June 2025. This promotion has now ended. We are grateful to the hundreds of agents, landlords, and developers who joined Imari during our early phase and helped shape our platform. Premium listing packages at standard pricing are still available and offer significantly enhanced visibility, featured placement in search results, social media promotion, and a dedicated account manager. Visit the Pricing page for current rates.',
                'status'     => 'inactive',
                'start_date' => now()->subDays(45)->toDateString(),
                'end_date'   => now()->subDays(5)->toDateString(),
                'created_by' => 1,
            ],

            // 10 — Active: Policy update
            [
                'title'      => 'Updated Listing Policy: Accurate Pricing & UPI Compliance',
                'content'    => 'Effective 1 July 2025, all land and property listings on Imari must display an accurate asking price in Rwandan Francs (RWF) and, for land listings, include a valid UPI (Uburenganzira bwo Gukoresha Ubutaka) reference number where a title deed exists. Listings without a price will no longer appear in standard search results and will be marked as "Price on Application" only with agent-tier accounts. This policy update is designed to improve transparency and trust for property seekers on our platform. Listings that do not comply by 15 July 2025 will be temporarily suspended pending correction. Please update your listings through your dashboard.',
                'status'     => 'active',
                'start_date' => now()->subDays(1)->toDateString(),
                'end_date'   => now()->addDays(50)->toDateString(),
                'created_by' => 1,
            ],
        ];

        foreach ($announcements as $announcement) {
            $announcement['slug'] = Str::slug($announcement['title']);
            Announcement::firstOrCreate(
                ['slug' => $announcement['slug']],
                $announcement
            );
        }
    }
}