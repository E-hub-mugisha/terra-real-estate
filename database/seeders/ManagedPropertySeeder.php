<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManagedPropertySeeder extends Seeder
{
    public function run(): void
    {
        // Owners are looked up through the users seeded by PropertyOwnerSeeder
        $ownerIds = DB::table('property_owners')
            ->join('users', 'users.id', '=', 'property_owners.user_id')
            ->pluck('property_owners.id', 'users.email');

        $properties = [
            // ---- Jean Bosco Habimana (2 houses in Kiyovu) ----
            [
                'owner_email'       => 'jb.habimana@example.com',
                'name'              => 'Kiyovu Garden Villas',
                'property_code'     => 'TPM-KGL-001',
                'property_type'     => 'residential',
                'description'       => 'Two secure family villas with gardens in the quiet Kiyovu neighbourhood, close to the city centre and international schools.',
                'province'          => 'Kigali City',
                'district'          => 'Nyarugenge',
                'sector'            => 'Kiyovu',
                'cell'              => 'Kiyovu',
                'village'           => 'Amahoro',
                'address'           => 'KG 11 Ave, Kiyovu, Nyarugenge, Kigali',
                'upi_reference'     => '1/01/02/03/1184',
                'latitude'          => -1.9536000,
                'longitude'         => 30.0605000,
                'management_status' => 'active',
                'notes'             => 'Gated compound with 24/7 guard.',
            ],
            [
                'owner_email'       => 'jb.habimana@example.com',
                'name'              => 'Rugenge Family Residences',
                'property_code'     => 'TPM-KGL-002',
                'property_type'     => 'residential',
                'description'       => 'Family residences within walking distance of Nyarugenge market and main transport routes.',
                'province'          => 'Kigali City',
                'district'          => 'Nyarugenge',
                'sector'            => 'Nyarugenge',
                'cell'              => 'Rugenge',
                'village'           => 'Ubumwe',
                'address'           => 'KN 4 St, Rugenge, Nyarugenge, Kigali',
                'upi_reference'     => '1/01/01/02/0932',
                'latitude'          => -1.9500000,
                'longitude'         => 30.0560000,
                'management_status' => 'active',
                'notes'             => null,
            ],

            // ---- Marie Claire Uwimana (apartments in Nyarutarama) ----
            [
                'owner_email'       => 'mc.uwimana@example.com',
                'name'              => 'Nyarutarama Heights Apartments',
                'property_code'     => 'TPM-KGL-003',
                'property_type'     => 'apartment_building',
                'description'       => 'Modern apartment building with 8 units, secure parking and backup power, near Nyarutarama golf course.',
                'province'          => 'Kigali City',
                'district'          => 'Gasabo',
                'sector'            => 'Remera',
                'cell'              => 'Nyarutarama',
                'village'           => 'Isangano',
                'address'           => 'KG 9 Ave, Nyarutarama, Gasabo, Kigali',
                'upi_reference'     => '1/02/08/04/2271',
                'latitude'          => -1.9366000,
                'longitude'         => 30.1111000,
                'management_status' => 'active',
                'notes'             => 'Backup generator and water tank on site.',
            ],

            // ---- Emmanuel Ndayisaba (Kicukiro, pending verification) ----
            [
                'owner_email'       => 'e.ndayisaba@example.com',
                'name'              => 'Kicukiro Centre Residences',
                'property_code'     => 'TPM-KGL-004',
                'property_type'     => 'residential',
                'description'       => 'Affordable family homes in Kicukiro Centre, with easy access to markets, schools and public transport.',
                'province'          => 'Kigali City',
                'district'          => 'Kicukiro',
                'sector'            => 'Kicukiro',
                'cell'              => 'Kagina',
                'village'           => 'Umucyo',
                'address'           => 'KK 15 Rd, Kicukiro Centre, Kicukiro, Kigali',
                'upi_reference'     => '1/03/05/02/0745',
                'latitude'          => -1.9706000,
                'longitude'         => 30.1044000,
                'management_status' => 'onboarding',
                'notes'             => 'Awaiting owner verification before listing units.',
            ],

            // ---- Kivu Heights Investments Ltd ----
            [
                'owner_email'       => 'solange@kivuheights.example.com',
                'name'              => 'Kacyiru Court Apartments',
                'property_code'     => 'TPM-KGL-005',
                'property_type'     => 'apartment_building',
                'description'       => 'Residential apartments in Kacyiru close to government offices, embassies and Kimihurura restaurants.',
                'province'          => 'Kigali City',
                'district'          => 'Gasabo',
                'sector'            => 'Kacyiru',
                'cell'              => 'Kamatamu',
                'village'           => 'Rugari',
                'address'           => 'KG 7 Ave, Kacyiru, Gasabo, Kigali',
                'upi_reference'     => '1/02/03/01/1560',
                'latitude'          => -1.9355000,
                'longitude'         => 30.0780000,
                'management_status' => 'active',
                'notes'             => 'Lift, CCTV and underground parking.',
            ],
            [
                'owner_email'       => 'solange@kivuheights.example.com',
                'name'              => 'Kimihurura Terrace Residences',
                'property_code'     => 'TPM-KGL-006',
                'property_type'     => 'apartment_building',
                'description'       => 'Furnished and unfurnished apartments in Kimihurura, popular with expatriates and young professionals.',
                'province'          => 'Kigali City',
                'district'          => 'Gasabo',
                'sector'            => 'Kimihurura',
                'cell'              => 'Rugando',
                'village'           => 'Ubuzima',
                'address'           => 'KG 626 St, Kimihurura, Gasabo, Kigali',
                'upi_reference'     => '1/02/04/03/0867',
                'latitude'          => -1.9490000,
                'longitude'         => 30.0900000,
                'management_status' => 'active',
                'notes'             => null,
            ],

            // ---- Umuganda Real Estate Holdings Ltd ----
            [
                'owner_email'       => 'patrick@umugandaholdings.example.com',
                'name'              => 'Gikondo Business & Residence Plaza',
                'property_code'     => 'TPM-KGL-007',
                'property_type'     => 'mixed_use',
                'description'       => 'Mixed-use development with ground-floor retail and residential apartments above, in the Gikondo industrial and residential corridor.',
                'province'          => 'Kigali City',
                'district'          => 'Kicukiro',
                'sector'            => 'Gikondo',
                'cell'              => 'Kinunga',
                'village'           => 'Isonga',
                'address'           => 'KK 3 Rd, Gikondo, Kicukiro, Kigali',
                'upi_reference'     => '1/03/02/01/3318',
                'latitude'          => -1.9770000,
                'longitude'         => 30.0700000,
                'management_status' => 'onboarding',
                'notes'             => 'Building under construction. Management begins after handover.',
            ],
            [
                'owner_email'       => 'patrick@umugandaholdings.example.com',
                'name'              => 'Nyabugogo Gateway Residences',
                'property_code'     => 'TPM-KGL-008',
                'property_type'     => 'residential',
                'description'       => 'Residential building next to the Nyabugogo bus terminal, convenient for commuters travelling in and out of Kigali.',
                'province'          => 'Kigali City',
                'district'          => 'Nyarugenge',
                'sector'            => 'Muhima',
                'cell'              => 'Nyabugogo',
                'village'           => 'Intwari',
                'address'           => 'KN 3 Rd, Nyabugogo, Nyarugenge, Kigali',
                'upi_reference'     => '1/01/06/02/0419',
                'latitude'          => -1.9390000,
                'longitude'         => 30.0450000,
                'management_status' => 'active',
                'notes'             => null,
            ],
        ];

        DB::transaction(function () use ($properties, $ownerIds) {
            foreach ($properties as $property) {
                $ownerId = $ownerIds[$property['owner_email']] ?? null;

                if (! $ownerId) {
                    throw new \RuntimeException(
                        "Owner for {$property['owner_email']} not found. Run PropertyOwnerSeeder first."
                    );
                }

                $row = collect($property)->except('owner_email')->all();

                DB::table('managed_properties')->updateOrInsert(
                    ['property_code' => $property['property_code']],
                    array_merge($row, [
                        'property_owner_id' => $ownerId,
                        'created_at'        => now(),
                        'updated_at'        => now(),
                    ])
                );
            }
        });
    }
}