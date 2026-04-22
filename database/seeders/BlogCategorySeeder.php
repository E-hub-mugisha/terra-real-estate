<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\BlogCategory;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            'Real Estate Market Trends',
            'Home Buying Guide',
            'Property Investment',
            'Architecture & Design',
            'Real Estate Tips & Advice'

        ];

        foreach ($categories as $category) {

            BlogCategory::create([
                'name' => $category,
                'slug' => Str::slug($category)
            ]);

        }
    }
}