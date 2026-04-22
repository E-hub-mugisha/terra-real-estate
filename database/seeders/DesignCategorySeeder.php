<?php

namespace Database\Seeders;

use App\Models\DesignCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DesignCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Residential',
            'Commercial',
            'Industrial',
            'Mixed-Use',
            'Hospitality & Tourism',
            'Institutional & Public',
            'Eco & Sustainable',
            'Landscape & Outdoor',
            'Interior Design',
            'Urban Planning',
            'Religious & Cultural',
            'Renovation & Remodelling',
        ];

        foreach ($categories as $name) {
            DesignCategory::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}