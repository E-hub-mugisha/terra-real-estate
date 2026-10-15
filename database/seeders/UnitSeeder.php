<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = DB::table('buildings')
            ->join('managed_properties', 'managed_properties.id', '=', 'buildings.managed_property_id')
            ->select(
                'buildings.id',
                'buildings.name',
                'buildings.building_code',
                'buildings.managed_property_id',
                'managed_properties.name as property_name'
            )
            ->get()
            ->keyBy('building_code');

        $floors = DB::table('floors')
            ->get()
            ->groupBy('building_id')
            ->map(fn ($group) => $group->keyBy('floor_number'));

        DB::transaction(function () use ($buildings, $floors) {
            foreach ($this->layouts() as $code => $layout) {
                $building = $buildings[$code] ?? null;

                if (! $building) {
                    throw new \RuntimeException("Building {$code} not found. Run BuildingSeeder first.");
                }

                $buildingFloors = $floors[$building->id] ?? collect();

                if ($buildingFloors->isEmpty()) {
                    throw new \RuntimeException("No floors for {$code}. Run FloorSeeder first.");
                }

                $floorNumbers = $layout['floor_numbers']
                    ?? $buildingFloors->keys()->sort()->values()->all();

                $index = 0;

                foreach ($floorNumbers as $floorNumber) {
                    $floor = $buildingFloors[$floorNumber]
                        ?? throw new \RuntimeException("Floor {$floorNumber} missing for {$code}.");

                    for ($i = 0; $i < $layout['units_per_floor']; $i++) {
                        [$type, $beds, $baths, $area, $baseRent] =
                            $layout['templates'][$index % count($layout['templates'])];

                        $rent = $this->roundRent($baseRent + ($floorNumber * ($layout['rent_step'] ?? 0)));

                        $unitNumber = $layout['numbers'][$index]
                            ?? $this->unitNumber($layout['prefix'], $floorNumber, $i);

                        $status = $layout['statuses'][$index % count($layout['statuses'])];

                        DB::table('units')->updateOrInsert(
                            [
                                'managed_property_id' => $building->managed_property_id,
                                'unit_number'         => $unitNumber,
                            ],
                            [
                                'building_id'      => $building->id,
                                'floor_id'         => $floor->id,
                                'unit_type'        => $type,
                                'bedrooms'         => $beds,
                                'bathrooms'        => $baths,
                                'area_sqm'         => $area,
                                'monthly_rent'     => $rent,
                                'security_deposit' => $rent * $layout['deposit_months'],
                                'currency'         => 'RWF',
                                'status'           => $status,
                                'description'      => $this->description($type, $beds, $building, $floor, $layout['features']),
                                'created_at'       => now(),
                                'updated_at'       => now(),
                            ]
                        );

                        $index++;
                    }
                }
            }
        });
    }

    /**
     * Template format: [unit_type, bedrooms, bathrooms, area_sqm, base_monthly_rent]
     * Rent rises by rent_step for every floor above ground.
     * Statuses are cycled across the building's units in order.
     */
    private function layouts(): array
    {
        return [
            // ---- Kiyovu Garden Villas ----
            'KGV-A' => [
                'prefix' => 'VA', 'numbers' => ['VA'],
                'floor_numbers' => [0], 'units_per_floor' => 1,
                'templates' => [['villa', 4, 3, 320, 2200000]],
                'deposit_months' => 3,
                'statuses' => ['occupied'],
                'features' => 'Private garden, secure parking and a boys quarters.',
            ],
            'KGV-B' => [
                'prefix' => 'VB', 'numbers' => ['VB'],
                'floor_numbers' => [0], 'units_per_floor' => 1,
                'templates' => [['villa', 4, 4, 350, 2500000]],
                'deposit_months' => 3,
                'statuses' => ['available'],
                'features' => 'Private garden, secure parking and a boys quarters.',
            ],

            // ---- Rugenge Family Residences ----
            'RFR-A' => [
                'prefix' => 'RA', 'units_per_floor' => 2,
                'templates' => [['apartment', 2, 1, 85, 350000], ['apartment', 3, 2, 120, 450000]],
                'rent_step' => 0, 'deposit_months' => 1,
                'statuses' => ['occupied', 'available', 'available', 'occupied'],
                'features' => 'Separate entrance and water tank.',
            ],

            // ---- Nyarutarama Heights Apartments ----
            'NHA-MAIN' => [
                'prefix' => 'NH', 'units_per_floor' => 2,
                'templates' => [['apartment', 2, 2, 95, 850000], ['apartment', 3, 3, 140, 1250000]],
                'rent_step' => 30000, 'deposit_months' => 2,
                'statuses' => ['occupied', 'available', 'occupied', 'occupied', 'reserved', 'occupied', 'available', 'occupied'],
                'features' => 'Secure parking, backup power and fibre internet ready.',
            ],

            // ---- Kicukiro Centre Residences (onboarding, so units are not yet listed) ----
            'KCR-A' => [
                'prefix' => 'CA', 'units_per_floor' => 2,
                'templates' => [['apartment', 2, 1, 80, 320000], ['apartment', 3, 2, 110, 420000]],
                'rent_step' => 0, 'deposit_months' => 1,
                'statuses' => ['reserved'],
                'features' => 'Close to Kicukiro market and public transport.',
            ],
            'KCR-B' => [
                'prefix' => 'CB', 'units_per_floor' => 2,
                'templates' => [['apartment', 2, 1, 80, 320000], ['apartment', 3, 2, 110, 420000]],
                'rent_step' => 0, 'deposit_months' => 1,
                'statuses' => ['reserved'],
                'features' => 'Close to Kicukiro market and public transport.',
            ],

            // ---- Kacyiru Court Apartments ----
            'KCA-A' => [
                'prefix' => 'TA', 'units_per_floor' => 2,
                'templates' => [['apartment', 2, 2, 100, 780000], ['apartment', 3, 3, 150, 1100000]],
                'rent_step' => 25000, 'deposit_months' => 2,
                'statuses' => ['occupied', 'occupied', 'available', 'occupied', 'occupied', 'available', 'occupied', 'reserved', 'occupied', 'available'],
                'features' => 'Lift access, CCTV and underground parking.',
            ],
            'KCA-B' => [
                'prefix' => 'TB', 'units_per_floor' => 2,
                'templates' => [['apartment', 1, 1, 60, 520000], ['apartment', 2, 2, 100, 800000]],
                'rent_step' => 25000, 'deposit_months' => 2,
                'statuses' => ['occupied', 'available', 'occupied', 'occupied', 'available', 'occupied', 'occupied', 'occupied', 'available', 'occupied'],
                'features' => 'Lift access, CCTV and underground parking.',
            ],

            // ---- Kimihurura Terrace Residences ----
            'KTR-MAIN' => [
                'prefix' => 'KT', 'units_per_floor' => 2,
                'templates' => [
                    ['studio', 0, 1, 38, 600000],
                    ['apartment', 1, 1, 62, 780000],
                    ['apartment', 2, 2, 98, 1100000],
                ],
                'rent_step' => 20000, 'deposit_months' => 2,
                'statuses' => ['available', 'occupied', 'occupied', 'available', 'occupied', 'reserved', 'occupied', 'available'],
                'features' => 'Access to the rooftop terrace, ideal for professionals.',
            ],

            // ---- Nyabugogo Gateway Residences ----
            'NGR-A' => [
                'prefix' => 'NG', 'units_per_floor' => 3,
                'templates' => [
                    ['studio', 0, 1, 28, 130000],
                    ['apartment', 1, 1, 48, 210000],
                    ['apartment', 2, 1, 70, 320000],
                ],
                'rent_step' => 10000, 'deposit_months' => 1,
                'statuses' => ['occupied', 'occupied', 'available', 'occupied', 'available', 'occupied', 'occupied', 'occupied', 'available', 'occupied', 'available', 'occupied'],
                'features' => 'Steps from the Nyabugogo bus terminal.',
            ],

            // GBP-TWR (Gikondo Plaza) is intentionally skipped: building is under construction.
        ];
    }

    private function unitNumber(string $prefix, int $floorNumber, int $position): string
    {
        return $floorNumber === 0
            ? $prefix . '-G' . ($position + 1)
            : $prefix . '-' . (($floorNumber * 100) + $position + 1);
    }

    private function roundRent(float $amount): float
    {
        return round($amount / 5000) * 5000;
    }

    private function description(string $type, int $beds, object $building, object $floor, string $features): string
    {
        $label = match (true) {
            $type === 'studio' => 'Studio apartment',
            $type === 'villa'  => "{$beds}-bedroom villa",
            default            => "{$beds}-bedroom apartment",
        };

        $where = $type === 'villa'
            ? "{$building->name} at {$building->property_name}"
            : 'on the ' . strtolower($floor->name) . " of {$building->name}, {$building->property_name}";

        return "{$label} {$where}. {$features}";
    }
}
