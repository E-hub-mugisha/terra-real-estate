<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;

class PropertyMarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        // Create Service Category
        $category = ServiceCategory::updateOrCreate(
            ['slug' => 'property-marketplace'],
            [
                'name' => 'Property Marketplace',
                'description' => "Rwanda's First Online One Stop Center for Real Estate.\n\nIgisubizo Kirambye - The Lasting Solution\n\nContact: +250 796511725\nEmail: terraltd.rd@gmail.com\nWebsite: terra.rw",
                'is_active' => true,
            ]
        );

        $subCategories = [

            'Residential' => [
                'Houses',
                'Villas',
            ],

            'Apartments' => [
                'Studio',
                'One Bedroom',
                'Two Bedrooms',
                'Three Bedrooms',
                'Four Bedrooms+',
            ],

            'Commercial' => [
                'Offices',
                'Commercial Stores',
                'Warehouses',
                'Industrial Facilities',
                'Hotels',
                'Mixed-use Buildings',
            ],

            'Land' => [
                'Residential',
                'Commercial',
                'Industrial',
                'Agricultural',
                'Development Site',
            ],

            'Special Properties' => [
                'Holiday Homes',
                'Student Accommodation',
                'Investment Properties',
                'Lodges/Short Stay',
            ],

            'Designs' => [
                'Residential Designs',
                'Commercial Designs',
                'Industrial Designs',
                'Institutional Designs',
                'Landscape Designs',
                'Interior Designs',
            ],

        ];

        foreach ($subCategories as $subcategoryName => $services) {

            $subcategory = ServiceSubCategory::updateOrCreate(
                [
                    'service_category_id' => $category->id,
                    'slug' => Str::slug($subcategoryName),
                ],
                [
                    'name' => $subcategoryName,
                    'description' => $subcategoryName,
                ]
            );

            foreach ($services as $serviceName) {

                Service::updateOrCreate(
                    [
                        'service_subcategory_id' => $subcategory->id,
                        'slug' => Str::slug($serviceName),
                    ],
                    [
                        'service_category_id' => $category->id,
                        'title' => $serviceName,
                        'description' => $serviceName,
                        'price' => 0,
                        'commission_type' => 'percentage', // or fixed
                        'commission_value' => 10,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}