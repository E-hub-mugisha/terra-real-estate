<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSubcategory;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [

            // ==========================
            // BUYING / SELLING / RENTING
            // ==========================
            [
                'category' => 'Buying, Selling & Renting Marketplace',
                'subcategory' => 'Single-Family Homes',
                'title' => 'Sell a Single-Family Home',
                'description' => 'List and sell a standalone residential house.',
                'price' => 0,
            ],
            [
                'category' => 'Buying, Selling & Renting Marketplace',
                'subcategory' => 'Apartments / Flats',
                'title' => 'Rent an Apartment',
                'description' => 'Rent out apartments and flats to tenants.',
                'price' => 0,
            ],
            [
                'category' => 'Buying, Selling & Renting Marketplace',
                'subcategory' => 'Residential Plots',
                'title' => 'Sell Residential Land',
                'description' => 'Sell land designated for residential construction.',
                'price' => 0,
            ],

            // ==========================
            // ARCHITECTURAL DESIGNS
            // ==========================
            [
                'category' => 'Architectural Designs & House Plans Marketplace',
                'subcategory' => 'Bungalows',
                'title' => 'Bungalow House Plan',
                'description' => 'Ready-made architectural plans for bungalows.',
                'price' => 25000,
            ],
            [
                'category' => 'Architectural Designs & House Plans Marketplace',
                'subcategory' => 'Storey Houses (Villas)',
                'title' => 'Villa Architectural Design',
                'description' => 'Modern multi-storey villa house designs.',
                'price' => 50000,
            ],
            [
                'category' => 'Architectural Designs & House Plans Marketplace',
                'subcategory' => 'Apartment Blocks',
                'title' => 'Apartment Block Design',
                'description' => 'Architectural drawings for apartment buildings.',
                'price' => 100000,
            ],

            // ==========================
            // MARKETING & ADVERTISING
            // ==========================
            [
                'category' => 'Marketing & Advertising Marketplace',
                'subcategory' => null,
                'title' => 'Featured Property Advertisement',
                'description' => 'Promote your property on the homepage.',
                'price' => 15000,
            ],
            [
                'category' => 'Marketing & Advertising Marketplace',
                'subcategory' => null,
                'title' => 'Social Media Property Promotion',
                'description' => 'Advertise property across social media platforms.',
                'price' => 20000,
            ],

            // ==========================
            // PROFESSIONAL SERVICES
            // ==========================
            [
                'category' => 'Professionals Marketplace',
                'subcategory' => 'Engineers / Architects',
                'title' => 'Architectural Consultancy',
                'description' => 'Professional architectural consulting services.',
                'price' => 30000,
            ],
            [
                'category' => 'Professionals Marketplace',
                'subcategory' => 'Land Surveyors',
                'title' => 'Land Surveying Service',
                'description' => 'Land measurement and boundary verification.',
                'price' => 40000,
            ],
            [
                'category' => 'Professionals Marketplace',
                'subcategory' => 'Land Valuers',
                'title' => 'Land Valuation Service',
                'description' => 'Official valuation of land and property.',
                'price' => 35000,
            ],

            // ==========================
            // TERRA AGENTS ROOM
            // ==========================
            [
                'category' => 'Terra Agents Room',
                'subcategory' => null,
                'title' => 'Agent Property Listing Management',
                'description' => 'Agents manage listings on behalf of property owners.',
                'price' => 0,
            ],
        ];

        foreach ($services as $item) {

            $category = ServiceCategory::where('name', $item['category'])->first();

            if (!$category) continue;

            $subcategory = null;

            if ($item['subcategory']) {
                $subcategory = ServiceSubcategory::where('name', $item['subcategory'])->first();
            }

            Service::create([
                'service_category_id'    => $category->id,
                'service_subcategory_id' => $subcategory?->id,
                'title'                  => $item['title'],
                'slug'                   => Str::slug($item['title']),
                'description'            => $item['description'],
                'price'                  => $item['price'],
                'is_active'              => true,
            ]);
        }
    }
}
