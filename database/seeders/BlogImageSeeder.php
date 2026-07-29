<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogImageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('blog_images')->insert([
            ['blog_id' => 1, 'image_path' => 'blogs/kigali-market-chart-2026.jpg', 'caption' => 'Kigali property price trends 2024-2026', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['blog_id' => 1, 'image_path' => 'blogs/gasabo-development.jpg',        'caption' => 'New development in Gasabo district',      'sort_order' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['blog_id' => 2, 'image_path' => 'blogs/diaspora-land-visit.jpg',       'caption' => 'Diaspora investor visiting a land plot',   'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['blog_id' => 3, 'image_path' => 'blogs/rlmua-office.jpg',              'caption' => 'RLMUA office in Kigali',                   'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['blog_id' => 4, 'image_path' => 'blogs/construction-site-rwanda.jpg',   'caption' => 'Construction site in Kigali',               'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['blog_id' => 5, 'image_path' => 'blogs/bugesera-airport-aerial.jpg',    'caption' => 'Bugesera International Airport aerial view', 'sort_order' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}