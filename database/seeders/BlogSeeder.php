<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('blogs')->insert([
            [
                'id'              => 1,
                'views_count'     => 1245,
                'unique_views_count' => 987,
                'user_id'         => 1,
                'blog_category_id'=> 1,
                'title'           => 'Kigali Real Estate Market Report 2026: Prices Up 12% in Gasabo District',
                'slug'            => 'kigali-real-estate-market-report-2026',
                'featured_image'  => 'blogs/kigali-market-2026.jpg',
                'content'         => '<h2>Kigali Property Market Continues Upward Trend</h2><p>The Kigali real estate market has shown remarkable resilience in 2026, with property prices in Gasabo district increasing by 12% compared to the previous year. The growth is driven by increased demand from the growing middle class and returning diaspora community.</p><p>Key findings from our analysis of over 2,000 property transactions in the first half of 2026 include: average residential plot prices in Kacyiru reached 45,000 RWF per square meter, while Kimironko and Nyagatovu areas saw 18% growth in new listings.</p><p>Commercial properties in the CBD continue to command premium rates, with KN 3 Road plots averaging 400,000 RWF per square meter. The development of the new Bugesera International Airport is also driving property interest in the Eastern Province.</p>',
                'is_published'    => 1,
                'published_at'    => now()->subDays(15),
                'views'           => 1245,
                'status'          => 'active',
                'created_at'      => now()->subDays(15),
                'updated_at'      => now(),
            ],
            [
                'id'              => 2,
                'views_count'     => 876,
                'unique_views_count' => 712,
                'user_id'         => 1,
                'blog_category_id'=> 2,
                'title'           => '5 Things Every Rwandan Diaspora Investor Should Know Before Buying Land',
                'slug'            => 'diaspora-land-investment-guide-rwanda',
                'featured_image'  => 'blogs/diaspora-investment-guide.jpg',
                'content'         => '<h2>A Guide for Rwandans Abroad Looking to Invest Back Home</h2><p>Many Rwandans living abroad dream of owning property back home, but the process can be complex without local knowledge. Here are five essential tips to protect your investment:</p><p><strong>1. Verify the UPI Number:</strong> Every land parcel in Rwanda has a Unique Parcel Identifier (UPI) registered with RLMUA. Always verify this before making any payment.</p><p><strong>2. Use a Verified Agent:</strong> Work with Terra-verified agents who understand the local market and can handle the paperwork remotely.</p><p><strong>3. Check Zoning Regulations:</strong> R1, R2, and R3 zones have different building restrictions. Make sure your intended use matches the zoning.</p><p><strong>4. Conduct a Title Search:</strong> Visit the RLMUA office or use their online portal to verify ownership and check for any encumbrances.</p><p><strong>5. Use Escrow for Payments:</strong> Never transfer large sums directly to a seller. Use Terra\'s secure payment system or a bank escrow service.</p>',
                'is_published'    => 1,
                'published_at'    => now()->subDays(30),
                'views'           => 876,
                'status'          => 'active',
                'created_at'      => now()->subDays(30),
                'updated_at'      => now(),
            ],
            [
                'id'              => 3,
                'views_count'     => 567,
                'unique_views_count' => 456,
                'user_id'         => 1,
                'blog_category_id'=> 3,
                'title'           => 'Understanding the UPI System: Rwanda\'s Land Registration Revolution',
                'slug'            => 'understanding-upi-system-rwanda-land-registration',
                'featured_image'  => 'blogs/upi-system-guide.jpg',
                'content'         => '<h2>How Rwanda\'s Unique Parcel Identifier System Works</h2><p>Rwanda has been a pioneer in land administration reform in Africa. The Unique Parcel Identifier (UPI) system, managed by the Rwanda Land Management and Use Authority (RLMUA), assigns a unique code to every land parcel in the country.</p><p>The UPI follows a hierarchical structure: Province/District/Sector/Cell/Parcel. For example, UPI 1/02/04/006/021 refers to Parcel 21 in Cell 6 of Sector 4 in District 2 of Kigali City.</p><p>When buying land on Terra Rwanda, always verify the UPI matches the title deed and the physical boundaries. Our verified agents can help you conduct this due diligence before you commit to a purchase.</p>',
                'is_published'    => 1,
                'published_at'    => now()->subDays(45),
                'views'           => 567,
                'status'          => 'active',
                'created_at'      => now()->subDays(45),
                'updated_at'      => now(),
            ],
            [
                'id'              => 4,
                'views_count'     => 345,
                'unique_views_count' => 289,
                'user_id'         => 1,
                'blog_category_id'=> 4,
                'title'           => 'Building Your Dream Home in Rwanda: A Step-by-Step Construction Guide',
                'slug'            => 'building-dream-home-rwanda-construction-guide',
                'featured_image'  => 'blogs/construction-guide-rwanda.jpg',
                'content'         => '<h2>From Land Purchase to Move-In Day</h2><p>Building a home in Rwanda requires careful planning and compliance with the Rwanda Building Code (RBC). Here is a step-by-step guide to help you navigate the process:</p><p><strong>Step 1: Acquire Land with Verified Title</strong> — Ensure the land has a verified UPI and title deed.</p><p><strong>Step 2: Hire a Registered Architect</strong> — Your house plan must be prepared by a Rwanda Institute of Architects (RIA) registered professional.</p><p><strong>Step 3: Get Building Approval</strong> — Submit your plans to the Kigali City One-Stop Center or your district office for construction permit approval.</p><p><strong>Step 4: Hire a Licensed Contractor</strong> — Use contractors registered with the Rwanda Housing Authority for quality assurance.</p><p><strong>Step 5: Inspections and Handover</strong> — Schedule mandatory inspections at foundation, structural, and completion stages.</p>',
                'is_published'    => 1,
                'published_at'    => now()->subDays(60),
                'views'           => 345,
                'status'          => 'active',
                'created_at'      => now()->subDays(60),
                'updated_at'      => now(),
            ],
            [
                'id'              => 5,
                'views_count'     => 234,
                'unique_views_count' => 198,
                'user_id'         => 1,
                'blog_category_id'=> 5,
                'title'           => 'Bugesera Airport Corridor: How the New Airport Is Transforming Eastern Province Real Estate',
                'slug'            => 'bugesera-airport-corridor-real-estate-transformation',
                'featured_image'  => 'blogs/bugesera-airport-development.jpg',
                'content'         => '<h2>The Eastern Province Property Boom</h2><p>The construction of Bugesera International Airport has triggered a significant real estate transformation in the Eastern Province. Land prices in Nyamata and surrounding sectors have increased by over 40% since construction began in 2022.</p><p>The airport, expected to be fully operational by 2027, is attracting commercial developments including hotels, logistics centers, and residential communities. The Rwandan government has also invested in new road infrastructure connecting the airport to Kigali, further boosting property values along the corridor.</p><p>For investors looking to capitalize on this growth, Terra Rwanda offers verified land listings in the Bugesera area with clear title documentation. Our agents can help you identify the best investment opportunities before prices rise further.</p>',
                'is_published'    => 1,
                'published_at'    => now()->subDays(10),
                'views'           => 234,
                'status'          => 'active',
                'created_at'      => now()->subDays(10),
                'updated_at'      => now(),
            ],
        ]);
    }
}