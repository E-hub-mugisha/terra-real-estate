<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [

            // ==========================
            // Buying, Selling & Renting
            // ==========================
            'Buying, Selling & Renting Marketplace' => [

                [
                    'name' => 'Residential Properties',
                    'items' => [
                        'Single-Family Homes',
                        'Apartments / Flats',
                        'Studios / Bedsitters',
                        'Villas',
                        'Estates',
                    ],
                ],

                [
                    'name' => 'Commercial Properties',
                    'items' => [
                        'Office Spaces',
                        'Retail Stores / Shops',
                        'Warehouses',
                        'Showrooms',
                        'Hotels & Guest Houses',
                    ],
                ],

                [
                    'name' => 'Special Use Properties',
                    'items' => [
                        'Event Halls',
                        'Co-working Spaces',
                        'Parking Lots',
                    ],
                ],

                [
                    'name' => 'Lands & Plots',
                    'items' => [
                        'Residential Plots',
                        'Commercial Plots',
                        'Agricultural Land',
                        'Industrial Land',
                    ],
                ],
            ],

            // ==========================
            // Architectural Designs
            // ==========================
            'Architectural Designs & House Plans Marketplace' => [

                [
                    'name' => 'Residential Designs',
                    'items' => [
                        'Bungalows',
                        'Storey Houses (Villas)',
                        'Apartment Blocks',
                        'Tiny Houses / Studios',
                        'Duplexes',
                    ],
                ],

                [
                    'name' => 'Commercial & Mixed-Use',
                    'items' => [
                        'Commercial Buildings / Malls',
                        'Office Complexes',
                        'Warehouses',
                        'Mixed-Use Buildings',
                    ],
                ],

                [
                    'name' => 'Hospitality & Leisure',
                    'items' => [
                        'Hotels & Resorts',
                        'Guest Houses / Motels',
                        'Restaurants & Cafés',
                        'Event Halls',
                    ],
                ],

                [
                    'name' => 'Public & Institutional',
                    'items' => [
                        'Clinics & Hospitals',
                        'Schools & Classrooms',
                        'Places of Worship',
                    ],
                ],
            ],

            // ==========================
            // Professionals Marketplace
            // ==========================
            'Professionals Marketplace' => [
                [
                    'name' => 'Built Environment Professionals',
                    'items' => [
                        'Engineers / Architects',
                        'Land Notaries',
                        'Land Valuers',
                        'Land Surveyors',
                        'Urban Planners',
                        'Environmentalists',
                    ],
                ],
            ],
        ];

        foreach ($data as $categoryName => $groups) {

            $category = ServiceCategory::where('name', $categoryName)->first();

            if (!$category) continue;

            foreach ($groups as $group) {

                $parent = ServiceSubcategory::create([
                    'service_category_id' => $category->id,
                    'name'        => $group['name'],
                    'slug'        => Str::slug($group['name']),
                    'description'=> null,
                ]);

                foreach ($group['items'] as $item) {
                    ServiceSubCategory::create([
                        'service_category_id' => $category->id,
                        'name'       => $item,
                        'slug'       => Str::slug($item),
                        'description'=> null,
                    ]);
                }
            }
        }
    }
}
