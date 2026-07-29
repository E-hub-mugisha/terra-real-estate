<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [];
        $houseImagePaths = [
            1 => ['houses/kacyiru-villa-front.jpg', 'houses/kacyiru-villa-living.jpg', 'houses/kacyiru-villa-kitchen.jpg', 'houses/kacyiru-villa-garden.jpg', 'houses/kacyiru-villa-master.jpg'],
            2 => ['houses/nyamirambo-bungalow-front.jpg', 'houses/nyamirambo-bungalow-living.jpg', 'houses/nyamirambo-bungalow-kitchen.jpg'],
            3 => ['houses/kimihurura-penthouse-living.jpg', 'houses/kimihurura-penthouse-view.jpg', 'houses/kimihurura-penthouse-kitchen.jpg', 'houses/kimihurura-penthouse-terrace.jpg'],
            4 => ['houses/musanze-house-front.jpg', 'houses/musanze-house-garden.jpg', 'houses/musanze-house-living.jpg'],
            5 => ['houses/biryogo-double-front.jpg', 'houses/biryogo-double-living.jpg', 'houses/biryogo-double-kitchen.jpg', 'houses/biryogo-double-master.jpg', 'houses/biryogo-double-yard.jpg'],
        ];

        foreach ($houseImagePaths as $houseId => $paths) {
            foreach ($paths as $path) {
                $images[] = [
                    'house_id'   => $houseId,
                    'image_path' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('house_images')->insert($images);
    }
}