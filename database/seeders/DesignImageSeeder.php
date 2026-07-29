<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [];
        $designImagePaths = [
            1 => ['designs/gallery/3bed-bungalow-floor.jpg', 'designs/gallery/3bed-bungalow-3d.jpg', 'designs/gallery/3bed-bungalow-elevation.jpg'],
            2 => ['designs/gallery/4bed-double-ground.jpg', 'designs/gallery/4bed-double-first.jpg', 'designs/gallery/4bed-double-3d.jpg'],
            3 => ['designs/gallery/free-2bed-floor.jpg', 'designs/gallery/free-2bed-sketch.jpg'],
            4 => ['designs/gallery/commercial-shop-floor.jpg', 'designs/gallery/commercial-shop-3d.jpg'],
            5 => ['designs/gallery/6unit-apartment-floor.jpg', 'designs/gallery/6unit-apartment-3d.jpg', 'designs/gallery/6unit-apartment-roof.jpg'],
        ];

        foreach ($designImagePaths as $designId => $paths) {
            foreach ($paths as $path) {
                $images[] = [
                    'architectural_design_id' => $designId,
                    'image_path'             => $path,
                    'created_at'             => now(),
                    'updated_at'             => now(),
                ];
            }
        }

        DB::table('design_images')->insert($images);
    }
}