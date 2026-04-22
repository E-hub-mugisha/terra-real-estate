<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Blog;
use App\Models\BlogCategory;

class BlogSeeder extends Seeder
{
    public function run()
    {

        $category = BlogCategory::first();

        $blogs = [

            [
                'title' => 'Why Kigali is Becoming One of Africa’s Top Real Estate Investment Destinations',
                'content' => '
                <p>Kigali has rapidly transformed into one of the most attractive real estate markets in East Africa. 
                With its clean environment, strong governance, and steady economic growth, the city continues to attract both local and international investors.</p>

                <p>Areas such as Nyarutarama, Kacyiru, and Kimihurura have experienced major development in residential and commercial properties. 
                Investors are particularly interested in modern apartments and luxury villas due to the growing expatriate population.</p>

                <p>The government has also implemented policies that make property ownership easier for foreign investors. 
                Combined with Rwanda’s political stability, this makes Kigali a safe and promising real estate market.</p>
                '
            ],

            [
                'title' => '5 Fast Growing Neighborhoods in Kigali for Property Investment',
                'content' => '
                <p>If you are considering investing in real estate in Kigali, location is everything. Several neighborhoods are experiencing rapid growth due to infrastructure development and increasing demand.</p>

                <p>Some of the fastest growing areas include Kinyinya, Rebero, Gacuriro, Kanombe, and Masaka. These locations offer affordable land prices compared to the city center but are quickly gaining popularity.</p>

                <p>Investors buying land today in these neighborhoods are likely to see significant property value appreciation in the coming years.</p>
                '
            ],

            [
                'title' => 'A Beginner’s Guide to Buying Land in Rwanda',
                'content' => '
                <p>Buying land in Rwanda is a straightforward process when you understand the legal requirements. 
                The first step is verifying land ownership through the Rwanda Land Management Authority.</p>

                <p>Buyers should ensure the land title is legitimate and free from disputes. 
                It is also recommended to work with a licensed real estate agent or lawyer.</p>

                <p>Once the agreement is signed, ownership transfer can be completed through the land registry system.</p>
                '
            ],

            [
                'title' => 'Renting vs Buying Property in Kigali: Which is Better?',
                'content' => '
                <p>Many residents and expatriates living in Kigali face the decision of whether to rent or buy property. 
                Renting provides flexibility, especially for people staying short-term.</p>

                <p>However, purchasing property can be a long-term investment opportunity. 
                Property values in Kigali have been steadily rising over the past decade.</p>

                <p>Ultimately, the choice depends on financial goals, duration of stay, and investment strategy.</p>
                '
            ],

            [
                'title' => 'How Infrastructure Development is Boosting Rwanda’s Real Estate Market',
                'content' => '
                <p>Major infrastructure projects in Rwanda are significantly influencing property demand and prices.</p>

                <p>New roads, improved transport networks, and urban planning initiatives are opening new areas for real estate development.</p>

                <p>Projects such as the Bugesera International Airport are expected to create new investment opportunities in nearby districts.</p>
                '
            ],

            [
                'title' => 'Top Tips for First-Time Home Buyers in Rwanda',
                'content' => '
                <p>Buying your first home is an exciting milestone, but it also requires careful planning.</p>

                <p>Start by determining your budget and exploring financing options available through local banks.</p>

                <p>It is also important to inspect the property, verify documentation, and consider future resale value.</p>
                '
            ],

            [
                'title' => 'Luxury Living: The Rise of High-End Villas in Kigali',
                'content' => '
                <p>Luxury real estate is becoming increasingly popular in Kigali. 
                Neighborhoods like Nyarutarama and Gacuriro now feature modern villas with swimming pools, smart home systems, and beautiful city views.</p>

                <p>This trend is driven by international investors, diplomats, and business professionals looking for high-quality housing.</p>
                '
            ],

            [
                'title' => 'Understanding Property Taxes in Rwanda',
                'content' => '
                <p>Property owners in Rwanda are required to pay property taxes annually. 
                The amount depends on the value and location of the property.</p>

                <p>Understanding these tax obligations helps property investors plan their finances effectively.</p>
                '
            ],

            [
                'title' => 'The Future of Smart Cities in Rwanda',
                'content' => '
                <p>Rwanda is actively working toward developing smart cities that integrate technology with urban planning.</p>

                <p>Kigali Innovation City is one of the major projects expected to transform the country into a regional technology hub.</p>

                <p>These developments will increase demand for residential and commercial real estate in surrounding areas.</p>
                '
            ],

            [
                'title' => 'Why Real Estate Remains One of the Safest Investments in Rwanda',
                'content' => '
                <p>Real estate continues to be one of the most stable and profitable investments in Rwanda.</p>

                <p>With a growing population and increasing urbanization, demand for housing is expected to remain strong.</p>

                <p>For long-term investors, property ownership offers both rental income and capital appreciation.</p>
                '
            ]

        ];


        foreach ($blogs as $blog) {

            Blog::create([
                'blog_category_id' => $category->id,
                'title' => $blog['title'],
                'user_id' => 1, // Assuming the admin user has ID 1
                'slug' => Str::slug($blog['title']),
                'content' => $blog['content'],
                'featured_image' => 'blogs/default.jpg',
                'published_at' => now(),
                'is_published' => true,
            ]);

        }
    }
}