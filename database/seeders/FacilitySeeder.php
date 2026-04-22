<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            'Pool',
            'Gym',
            'Fireplace',
            'Garage',
            'Balcony',
            'Garden',
            'Swimming Pool',
            'Sauna',
            'Spa',
            'Terrace',
            'View',
            'Elevator',
            '24/7 Security',
            'Parking',
            'Playground',
            'Storage',
            'Air Conditioning'
        ];

        foreach ($facilities as $item) {
            Facility::create([
                'name' => $item,
                'slug' => Str::slug($item),
            ]);
        }
    }
}
