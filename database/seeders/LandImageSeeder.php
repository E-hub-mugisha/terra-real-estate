<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [];
        $landImagePaths = [
            1 => ['lands/nyagatovu-plot-aerial.jpg', 'lands/nyagatovu-plot-road.jpg', 'lands/nyagatovu-plot-view.jpg'],
            2 => ['lands/kn3-commercial-plot.jpg', 'lands/kn3-plot-road.jpg', 'lands/kn3-plot-aerial.jpg'],
            3 => ['lands/huye-agricultural-plot.jpg', 'lands/huye-plot-farm.jpg'],
            4 => ['lands/rubavu-lakefront-plot.jpg', 'lands/rubavu-lake-view.jpg', 'lands/rubavu-plot-aerial.jpg'],
            5 => ['lands/bugesera-plot-road.jpg', 'lands/bugesera-plot-aerial.jpg', 'lands/bugesera-plot-view.jpg'],
        ];

        foreach ($landImagePaths as $landId => $paths) {
            foreach ($paths as $path) {
                $images[] = [
                    'land_id'    => $landId,
                    'image_path' => $path,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('land_images')->insert($images);
    }
}