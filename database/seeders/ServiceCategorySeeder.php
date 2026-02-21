<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Buying, Selling & Renting Marketplace',
                'description' => 'Property buying, selling and renting services'
            ],
            [
                'name' => 'Architectural Designs & House Plans Marketplace',
                'description' => 'Architectural drawings and house plans'
            ],
            [
                'name' => 'Marketing & Advertising Marketplace',
                'description' => 'Property marketing and advertising services'
            ],
            [
                'name' => 'Professionals Marketplace',
                'description' => 'Verified real estate professionals'
            ],
            [
                'name' => 'Terra Agents Room',
                'description' => 'Agents declare and manage services'
            ],
        ];

        foreach ($categories as $category) {
            ServiceCategory::create([
                'name'        => $category['name'],
                'slug'        => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active'   => true,
            ]);
        }
    }
}
