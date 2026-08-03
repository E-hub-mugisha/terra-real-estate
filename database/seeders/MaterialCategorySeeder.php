<?php

namespace Database\Seeders;

use App\Models\MaterialCategory;
use Illuminate\Database\Seeder;

class MaterialCategorySeeder extends Seeder
{
    public function run(): void
    {
        $tree = [
            'Cement & Concrete' => ['Cement', 'Sand', 'Aggregates/Gravel', 'Ready-Mix Concrete', 'Concrete Blocks'],
            'Steel & Rebar' => ['Reinforcement Bars', 'Steel Sheets', 'Wire Mesh', 'Structural Steel'],
            'Timber & Wood' => ['Timber Planks', 'Plywood', 'Wood Poles', 'Doors (Wooden)'],
            'Roofing' => ['Iron Sheets', 'Roof Tiles', 'Trusses', 'Gutters & Fittings'],
            'Tiles & Flooring' => ['Ceramic Tiles', 'Porcelain Tiles', 'Terrazzo', 'Vinyl Flooring'],
            'Electrical' => ['Cables & Wires', 'Switches & Sockets', 'Circuit Breakers', 'Lighting Fixtures'],
            'Plumbing' => ['Pipes & Fittings', 'Sanitary Ware', 'Water Tanks', 'Pumps'],
            'Paint & Finishes' => ['Interior Paint', 'Exterior Paint', 'Primers', 'Wallpaper'],
            'Doors & Windows' => ['Aluminum Doors', 'Aluminum Windows', 'Steel Doors', 'Glass'],
            'Hardware & Tools' => ['Hand Tools', 'Power Tools', 'Fasteners & Nails', 'Safety Equipment'],
        ];

        $order = 0;

        foreach ($tree as $categoryName => $subs) {
            $category = MaterialCategory::create([
                'name' => $categoryName,
                'order' => $order++,
                'is_active' => true,
            ]);

            foreach ($subs as $subOrder => $subName) {
                $category->subcategories()->create([
                    'name' => $subName,
                    'order' => $subOrder,
                    'is_active' => true,
                ]);
            }
        }
    }
}
