<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        // Properties are looked up by the codes set in ManagedPropertySeeder
        $propertyIds = DB::table('managed_properties')->pluck('id', 'property_code');

        $buildings = [
            // ---- TPM-KGL-001  Kiyovu Garden Villas ----
            [
                'property_code'    => 'TPM-KGL-001',
                'name'             => 'Villa A',
                'building_code'    => 'KGV-A',
                'number_of_floors' => 2,
                'description'      => 'Detached family villa with garden, ground floor living area and upper floor bedrooms.',
                'is_active'        => true,
            ],
            [
                'property_code'    => 'TPM-KGL-001',
                'name'             => 'Villa B',
                'building_code'    => 'KGV-B',
                'number_of_floors' => 2,
                'description'      => 'Detached family villa with private parking and boys quarters.',
                'is_active'        => true,
            ],

            // ---- TPM-KGL-002  Rugenge Family Residences ----
            [
                'property_code'    => 'TPM-KGL-002',
                'name'             => 'Block A',
                'building_code'    => 'RFR-A',
                'number_of_floors' => 2,
                'description'      => 'Two-storey residential block with separate entrances.',
                'is_active'        => true,
            ],

            // ---- TPM-KGL-003  Nyarutarama Heights Apartments ----
            [
                'property_code'    => 'TPM-KGL-003',
                'name'             => 'Main Building',
                'building_code'    => 'NHA-MAIN',
                'number_of_floors' => 4,
                'description'      => 'Four-storey apartment building with two units per floor, secure parking and backup power.',
                'is_active'        => true,
            ],

            // ---- TPM-KGL-004  Kicukiro Centre Residences ----
            [
                'property_code'    => 'TPM-KGL-004',
                'name'             => 'Block A',
                'building_code'    => 'KCR-A',
                'number_of_floors' => 2,
                'description'      => 'Family homes arranged over two floors.',
                'is_active'        => true,
            ],
            [
                'property_code'    => 'TPM-KGL-004',
                'name'             => 'Block B',
                'building_code'    => 'KCR-B',
                'number_of_floors' => 2,
                'description'      => 'Second block, same layout as Block A.',
                'is_active'        => true,
            ],

            // ---- TPM-KGL-005  Kacyiru Court Apartments ----
            [
                'property_code'    => 'TPM-KGL-005',
                'name'             => 'Tower A',
                'building_code'    => 'KCA-A',
                'number_of_floors' => 5,
                'description'      => 'Five-storey apartment tower with lift and underground parking.',
                'is_active'        => true,
            ],
            [
                'property_code'    => 'TPM-KGL-005',
                'name'             => 'Tower B',
                'building_code'    => 'KCA-B',
                'number_of_floors' => 5,
                'description'      => 'Twin tower to Tower A, sharing the parking and CCTV system.',
                'is_active'        => true,
            ],

            // ---- TPM-KGL-006  Kimihurura Terrace Residences ----
            [
                'property_code'    => 'TPM-KGL-006',
                'name'             => 'Terrace Building',
                'building_code'    => 'KTR-MAIN',
                'number_of_floors' => 4,
                'description'      => 'Four-storey building with furnished and unfurnished apartments and a shared rooftop terrace.',
                'is_active'        => true,
            ],

            // ---- TPM-KGL-007  Gikondo Business & Residence Plaza (under construction) ----
            [
                'property_code'    => 'TPM-KGL-007',
                'name'             => 'Plaza Tower',
                'building_code'    => 'GBP-TWR',
                'number_of_floors' => 6,
                'description'      => 'Mixed-use tower with retail on the ground floor and apartments above. Under construction.',
                'is_active'        => false,
            ],

            // ---- TPM-KGL-008  Nyabugogo Gateway Residences ----
            [
                'property_code'    => 'TPM-KGL-008',
                'name'             => 'Block A',
                'building_code'    => 'NGR-A',
                'number_of_floors' => 4,
                'description'      => 'Residential block beside the Nyabugogo bus terminal.',
                'is_active'        => true,
            ],
        ];

        DB::transaction(function () use ($buildings, $propertyIds) {
            foreach ($buildings as $building) {
                $propertyId = $propertyIds[$building['property_code']] ?? null;

                if (! $propertyId) {
                    throw new \RuntimeException(
                        "Property {$building['property_code']} not found. Run ManagedPropertySeeder first."
                    );
                }

                $row = collect($building)->except('property_code')->all();

                DB::table('buildings')->updateOrInsert(
                    [
                        'managed_property_id' => $propertyId,
                        'building_code'       => $building['building_code'],
                    ],
                    array_merge($row, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ])
                );
            }
        });
    }
}