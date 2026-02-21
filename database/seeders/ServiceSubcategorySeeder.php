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
                    'local_name' => 'Amazu yo guturamo',
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
                    'local_name' => 'Imitungo y’ubucuruzi',
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
                    'local_name' => 'Imitungo yihariye',
                    'items' => [
                        'Event Halls',
                        'Co-working Spaces',
                        'Parking Lots',
                    ],
                ],

                [
                    'name' => 'Lands & Plots',
                    'local_name' => 'Ubutaka n’Ibibanza',
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
                    'local_name' => 'Ibishushanyo by’amazu yo guturamo',
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
                    'local_name' => 'Ubucuruzi n’ihuriro',
                    'items' => [
                        'Commercial Buildings / Malls',
                        'Office Complexes',
                        'Warehouses',
                        'Mixed-Use Buildings',
                    ],
                ],

                [
                    'name' => 'Hospitality & Leisure',
                    'local_name' => 'Ubukerarugendo n’imyidagaduro',
                    'items' => [
                        'Hotels & Resorts',
                        'Guest Houses / Motels',
                        'Restaurants & Cafés',
                        'Event Halls',
                    ],
                ],

                [
                    'name' => 'Public & Institutional',
                    'local_name' => 'Ibikorwa remezo',
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
                    'local_name' => null,
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
                    'local_name'  => $group['local_name'],
                    'description'=> null,
                ]);

                foreach ($group['items'] as $item) {
                    ServiceSubCategory::create([
                        'service_category_id' => $category->id,
                        'name'       => $item,
                        'slug'       => Str::slug($item),
                        'local_name' => null,
                        'description'=> null,
                    ]);
                }
            }
        }
    }
}
