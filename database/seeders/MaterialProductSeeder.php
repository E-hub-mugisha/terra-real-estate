<?php

namespace Database\Seeders;

use App\Models\MaterialCategory;
use App\Models\MaterialProduct;
use App\Models\Shop;
use Illuminate\Database\Seeder;

class MaterialProductSeeder extends Seeder
{
    /**
     * Sample product names per category, so seeded titles look plausible
     * instead of generic "Product 1", "Product 2".
     */
    private array $productsByCategory = [
        'Cement & Concrete' => [
            'PPC Cement 50kg Bag', 'River Sand (per truck)', 'Crushed Aggregates 20mm',
            'Ready-Mix Concrete C25', 'Solid Concrete Blocks 6"',
        ],
        'Steel & Rebar' => [
            'Reinforcement Bar Y12', 'Reinforcement Bar Y16', 'Galvanized Steel Sheet 2mm',
            'Welded Wire Mesh Panel', 'Structural I-Beam 200mm',
        ],
        'Timber & Wood' => [
            'Eucalyptus Timber Plank 2x4', 'Marine Plywood 18mm', 'Treated Wood Pole 6m',
            'Solid Wood Panel Door',
        ],
        'Roofing' => [
            'Galvanized Iron Sheet (IBR)', 'Clay Roof Tile', 'Prefabricated Roof Truss',
            'PVC Gutter & Downpipe Set',
        ],
        'Tiles & Flooring' => [
            'Ceramic Floor Tile 60x60', 'Porcelain Wall Tile 30x60', 'Terrazzo Tile Polished',
            'Vinyl Flooring Roll',
        ],
        'Electrical' => [
            'Twin & Earth Cable 2.5mm', 'Wall Switch & Socket Set', 'MCB Circuit Breaker 20A',
            'LED Ceiling Light Fixture',
        ],
        'Plumbing' => [
            'PVC Pipe 4-inch', 'Ceramic Wash Basin', 'Plastic Water Tank 5000L',
            'Submersible Water Pump',
        ],
        'Paint & Finishes' => [
            'Interior Emulsion Paint 20L', 'Weatherproof Exterior Paint 20L',
            'Universal Wall Primer', 'Textured Wallpaper Roll',
        ],
        'Doors & Windows' => [
            'Aluminum Sliding Door', 'Aluminum Casement Window', 'Steel Security Door',
            'Tempered Glass Panel',
        ],
        'Hardware & Tools' => [
            'Hand Tool Set (12-piece)', 'Cordless Power Drill', 'Assorted Nails & Fasteners (5kg)',
            'Safety Helmet & Vest Kit',
        ],
    ];

    private array $units = ['per bag', 'per m2', 'per m3', 'per piece', 'per truck', 'per ton', 'per roll', 'per set'];

    public function run(): void
    {
        $shops = Shop::approved()->get();
        $categories = MaterialCategory::with('materialSubcategories')->get();

        if ($shops->isEmpty()) {
            $this->command->warn('No approved shops found — run ShopSeeder first.');
            return;
        }

        if ($categories->isEmpty()) {
            $this->command->warn('No material categories found — run MaterialCategorySeeder first.');
            return;
        }

        $statuses = ['approved', 'approved', 'approved', 'pending', 'rejected'];
        $stockStatuses = ['in_stock', 'in_stock', 'in_stock', 'out_of_stock', 'made_to_order'];

        foreach ($shops as $shop) {
            // Each shop lists products from 2–4 random categories
            $shopCategories = $categories->random(min(rand(2, 4), $categories->count()));

            foreach ($shopCategories as $category) {
                $productNames = $this->productsByCategory[$category->name] ?? ["{$category->name} Item"];
                $subcategories = $category->materialSubcategories;

                // 2–3 products per category for this shop
                $picks = collect($productNames)->random(min(rand(2, 3), count($productNames)));

                foreach ($picks as $title) {
                    $status = $statuses[array_rand($statuses)];
                    $hasPrice = rand(0, 4) !== 0; // ~80% of products have a listed price

                    $product = MaterialProduct::create([
                        'shop_id'                 => $shop->id,
                        'material_category_id'    => $category->id,
                        'material_subcategory_id' => $subcategories->isNotEmpty()
                            ? $subcategories->random()->id
                            : null,
                        'title'                   => $title,
                        'slug'                    => MaterialProduct::generateUniqueSlug($title . '-' . $shop->id),
                        'description'              => "{$title} available from {$shop->name}. Quality checked and ready for delivery across Rwanda.",
                        'price'                    => $hasPrice ? rand(1500, 250000) : null,
                        'currency'                 => 'RWF',
                        'unit'                     => $this->units[array_rand($this->units)],
                        'min_order_quantity'       => rand(0, 1) ? rand(1, 20) : null,
                        'stock_status'             => $stockStatuses[array_rand($stockStatuses)],
                        'status'                   => $status,
                        'rejection_reason'         => $status === 'rejected' ? 'Product images unclear or description incomplete.' : null,
                        'is_featured'              => rand(0, 9) === 0, // ~10% featured
                        'views_count'              => rand(0, 300),
                        'whatsapp_clicks_count'    => rand(0, 40),
                    ]);

                    $this->seedImages($product);
                }
            }
        }

        $this->command->info('Material products seeded successfully.');
    }

    /**
     * Attaches 1–3 placeholder images per product, one flagged primary.
     */
    private function seedImages(MaterialProduct $product): void
    {
        $imageCount = rand(1, 3);

        for ($i = 0; $i < $imageCount; $i++) {
            $product->images()->create([
                // Placeholder path — swap for real seeded/copied files if you
                // want actual images rendered locally instead of a placeholder URL.
                'image_path' => "shops/placeholders/material-{$product->material_category_id}-" . rand(1, 5) . '.jpg',
                'is_primary' => $i === 0,
                'order'      => $i,
            ]);
        }
    }
}