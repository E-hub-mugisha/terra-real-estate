<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\House;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    public function run(): void
    {
        // Helper: resolve facility IDs by slug from the DB
        $f = fn(array $slugs) => Facility::whereIn('slug', $slugs)->pluck('id')->toArray();

        $houses = [
            // 1 — Modern Villa in Kiyovu
            [
                'data' => [
                    'user_id'     => 1,
                    'service_id'  => 1,
                    'title'       => 'Modern Villa in Kiyovu',
                    'type'        => 'Villa',
                    'price'       => 185000000,
                    'area_sqft'   => 3200,
                    'status'      => 'available',
                    'bedrooms'    => 5,
                    'bathrooms'   => 4,
                    'garages'     => 2,
                    'description' => 'Stunning modern villa nestled in the prestigious Kiyovu neighbourhood of Kigali. Features high-end finishes, open-plan living spaces, a landscaped garden, and panoramic views of the city. Close to embassies and international schools.',
                    'city'        => 'Kigali',
                    'state'       => 'Kigali City',
                    'zip_code'    => 'KN 5 Rd',
                    'country'     => 'Rwanda',
                    'address'     => 'KN 5 Rd, Kiyovu, Kigali',
                    'condition'   => 'new',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'swimming-pool',
                    'garden-landscaping',
                    'cctv-security',
                    '24-7-security-guard',
                    'electric-fence',
                    'standby-generator',
                    'high-speed-internet',
                    'parking-space',
                    'smart-home-system',
                    'servants-quarters',
                ]),
            ],

            // 2 — Furnished Apartment in Kimihurura
            [
                'data' => [
                    'user_id'     => 1,
                    'service_id'  => 2,
                    'title'       => 'Furnished Apartment in Kimihurura',
                    'type'        => 'Apartment',
                    'price'       => 1200000,
                    'area_sqft'   => 1100,
                    'status'      => 'available',
                    'bedrooms'    => 3,
                    'bathrooms'   => 2,
                    'garages'     => 1,
                    'description' => 'Fully furnished and serviced apartment in the heart of Kimihurura diplomatic zone. Features a modern kitchen, high-speed internet, 24/7 security, standby generator, and rooftop terrace with stunning Kigali skyline views.',
                    'city'        => 'Kigali',
                    'state'       => 'Kigali City',
                    'zip_code'    => 'KG 9 Ave',
                    'country'     => 'Rwanda',
                    'address'     => 'KG 9 Ave, Kimihurura, Gasabo',
                    'condition'   => 'good',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'furnished',
                    'high-speed-internet',
                    'satellite-cable-tv',
                    'standby-generator',
                    '24-7-security-guard',
                    'cctv-security',
                    'rooftop-terrace',
                    'parking-space',
                    'air-conditioning',
                    'backup-water-supply',
                ]),
            ],

            // 3 — Family Home in Remera
            [
                'data' => [
                    'user_id'     => 2,
                    'service_id'  => 1,
                    'title'       => 'Family Home in Remera',
                    'type'        => 'House',
                    'price'       => 62000000,
                    'area_sqft'   => 1800,
                    'status'      => 'available',
                    'bedrooms'    => 4,
                    'bathrooms'   => 3,
                    'garages'     => 1,
                    'description' => 'Spacious family home located in Remera, just minutes from Kigali International Airport and the popular Gisimenti shopping strip. The property features a large compound with a garden, solar panels, and borehole water supply.',
                    'city'        => 'Kigali',
                    'state'       => 'Kigali City',
                    'zip_code'    => 'KG 15 Ave',
                    'country'     => 'Rwanda',
                    'address'     => 'KG 15 Ave, Remera, Gasabo',
                    'condition'   => 'good',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'solar-panels',
                    'borehole-water-tank',
                    'garden-landscaping',
                    'parking-space',
                    'cctv-security',
                    'electric-fence',
                    'storage-room',
                    'laundry-room',
                    'servants-quarters',
                ]),
            ],

            // 4 — Studio Apartment in Nyamirambo
            [
                'data' => [
                    'user_id'     => 2,
                    'service_id'  => 2,
                    'title'       => 'Studio Apartment in Nyamirambo',
                    'type'        => 'Apartment',
                    'price'       => 280000,
                    'area_sqft'   => 420,
                    'status'      => 'available',
                    'bedrooms'    => 1,
                    'bathrooms'   => 1,
                    'garages'     => 0,
                    'description' => 'Cosy and affordable studio apartment in the vibrant Nyamirambo district. Walking distance to the Nyamirambo market, local restaurants, and mosques. Ideal for a young professional or student. Includes water and electricity.',
                    'city'        => 'Kigali',
                    'state'       => 'Kigali City',
                    'zip_code'    => 'KN 22 St',
                    'country'     => 'Rwanda',
                    'address'     => 'KN 22 St, Nyamirambo, Nyarugenge',
                    'condition'   => 'fair',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'furnished',
                    'backup-water-supply',
                    'satellite-cable-tv',
                    'high-speed-internet',
                ]),
            ],

            // 5 — Luxury Penthouse in Nyarutarama
            [
                'data' => [
                    'user_id'     => 3,
                    'service_id'  => 1,
                    'title'       => 'Luxury Penthouse in Nyarutarama',
                    'type'        => 'Penthouse',
                    'price'       => 320000000,
                    'area_sqft'   => 4500,
                    'status'      => 'available',
                    'bedrooms'    => 6,
                    'bathrooms'   => 5,
                    'garages'     => 3,
                    'description' => 'Exceptional top-floor penthouse in Kigali\'s most exclusive enclave, Nyarutarama. This landmark property features a private pool, wrap-around terrace, smart home automation, chef\'s kitchen, and cinema room. Steps from the Golf Club and top international restaurants.',
                    'city'        => 'Kigali',
                    'state'       => 'Kigali City',
                    'zip_code'    => 'KG 200 St',
                    'country'     => 'Rwanda',
                    'address'     => 'KG 200 St, Nyarutarama, Gasabo',
                    'condition'   => 'new',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'swimming-pool',
                    'smart-home-system',
                    'rooftop-terrace',
                    'gym-fitness-room',
                    'elevator-lift',
                    'air-conditioning',
                    'standby-generator',
                    'cctv-security',
                    '24-7-security-guard',
                    'high-speed-internet',
                    'satellite-cable-tv',
                    'parking-space',
                    'laundry-room',
                    'furnished',
                ]),
            ],

            // 6 — Townhouse in Kacyiru
            [
                'data' => [
                    'user_id'     => 3,
                    'service_id'  => 2,
                    'title'       => 'Townhouse in Kacyiru',
                    'type'        => 'Townhouse',
                    'price'       => 950000,
                    'area_sqft'   => 2100,
                    'status'      => 'available',
                    'bedrooms'    => 4,
                    'bathrooms'   => 3,
                    'garages'     => 2,
                    'description' => 'Well-maintained townhouse in Kacyiru, the government and NGO hub of Kigali. Located within a secure, gated community with a shared swimming pool and children\'s play area. A short walk to the Parliament, ministries, and Nakumatt supermarket.',
                    'city'        => 'Kigali',
                    'state'       => 'Kigali City',
                    'zip_code'    => 'KG 7 Ave',
                    'country'     => 'Rwanda',
                    'address'     => 'KG 7 Ave, Kacyiru, Gasabo',
                    'condition'   => 'good',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'swimming-pool',
                    'gated-community',
                    'childrens-play-area',
                    'cctv-security',
                    '24-7-security-guard',
                    'standby-generator',
                    'parking-space',
                    'garden-landscaping',
                    'high-speed-internet',
                    'backup-water-supply',
                ]),
            ],

            // 7 — Commercial Building in Downtown Kigali
            [
                'data' => [
                    'user_id'     => 4,
                    'service_id'  => 1,
                    'title'       => 'Commercial Building in Downtown Kigali',
                    'type'        => 'Commercial',
                    'price'       => 490000000,
                    'area_sqft'   => 8000,
                    'status'      => 'available',
                    'bedrooms'    => 0,
                    'bathrooms'   => 6,
                    'garages'     => 5,
                    'description' => 'Prime commercial building located along KN 3 Avenue in the Kigali CBD. The property comprises ground-floor retail units and four upper floors of open-plan offices, with a rooftop conference facility. High footfall area near the Kigali Convention Centre.',
                    'city'        => 'Kigali',
                    'state'       => 'Kigali City',
                    'zip_code'    => 'KN 3 Ave',
                    'country'     => 'Rwanda',
                    'address'     => 'KN 3 Ave, Nyarugenge, Kigali CBD',
                    'condition'   => 'new',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'elevator-lift',
                    'cctv-security',
                    '24-7-security-guard',
                    'standby-generator',
                    'high-speed-internet',
                    'air-conditioning',
                    'parking-space',
                    'wheelchair-access',
                    'backup-water-supply',
                    'rooftop-terrace',
                ]),
            ],

            // 8 — Bungalow in Butare (Huye)
            [
                'data' => [
                    'user_id'     => 4,
                    'service_id'  => 2,
                    'title'       => 'Bungalow in Butare (Huye)',
                    'type'        => 'Bungalow',
                    'price'       => 350000,
                    'area_sqft'   => 1400,
                    'status'      => 'available',
                    'bedrooms'    => 3,
                    'bathrooms'   => 2,
                    'garages'     => 1,
                    'description' => 'Comfortable single-storey bungalow in Huye district (formerly Butare), Rwanda\'s intellectual capital and home to the University of Rwanda. The property sits on a large plot with a mature garden, and is a 10-minute drive from the National Museum of Rwanda.',
                    'city'        => 'Huye',
                    'state'       => 'Southern Province',
                    'zip_code'    => 'HY 100',
                    'country'     => 'Rwanda',
                    'address'     => 'Ngoma Sector, Huye District, Southern Province',
                    'condition'   => 'good',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'garden-landscaping',
                    'borehole-water-tank',
                    'solar-panels',
                    'parking-space',
                    'storage-room',
                    'servants-quarters',
                    'electric-fence',
                ]),
            ],

            // 9 — Lakeside Cottage in Gisenyi
            [
                'data' => [
                    'user_id'     => 5,
                    'service_id'  => 1,
                    'title'       => 'Lakeside Cottage in Gisenyi',
                    'type'        => 'Cottage',
                    'price'       => 95000000,
                    'area_sqft'   => 1600,
                    'status'      => 'available',
                    'bedrooms'    => 3,
                    'bathrooms'   => 2,
                    'garages'     => 1,
                    'description' => 'Charming lakeside cottage on the shores of Lake Kivu in Rubavu (Gisenyi). Enjoy direct beach access, breathtaking views of the DRC mountains, and cool volcanic highland breezes. Close to popular resorts, Kivu Belt boutique wineries, and the Rubavu border crossing.',
                    'city'        => 'Rubavu',
                    'state'       => 'Western Province',
                    'zip_code'    => 'RB 200',
                    'country'     => 'Rwanda',
                    'address'     => 'Lake Kivu Shore Rd, Rubavu District, Western Province',
                    'condition'   => 'good',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'garden-landscaping',
                    'borehole-water-tank',
                    'solar-panels',
                    'satellite-cable-tv',
                    'high-speed-internet',
                    'parking-space',
                    'cctv-security',
                    'backup-water-supply',
                ]),
            ],

            // 10 — Gated Residence in Musanze
            [
                'data' => [
                    'user_id'     => 5,
                    'service_id'  => 2,
                    'title'       => 'Gated Residence in Musanze (Ruhengeri)',
                    'type'        => 'House',
                    'price'       => 600000,
                    'area_sqft'   => 2200,
                    'status'      => 'available',
                    'bedrooms'    => 4,
                    'bathrooms'   => 3,
                    'garages'     => 2,
                    'description' => 'Spacious gated residence in Musanze district, gateway to Volcanoes National Park and the famous mountain gorilla trekking experience. The home features a large garden with Virunga volcano views, a fireplace for cool highland evenings, and easy access to Musanze town centre.',
                    'city'        => 'Musanze',
                    'state'       => 'Northern Province',
                    'zip_code'    => 'MZ 100',
                    'country'     => 'Rwanda',
                    'address'     => 'Cyuve Sector, Musanze District, Northern Province',
                    'condition'   => 'good',
                    'is_approved' => true,
                ],
                'facilities' => $f([
                    'gated-community',
                    'garden-landscaping',
                    'fireplace',
                    'cctv-security',
                    '24-7-security-guard',
                    'electric-fence',
                    'solar-panels',
                    'borehole-water-tank',
                    'parking-space',
                    'servants-quarters',
                    'storage-room',
                ]),
            ],
        ];

        foreach ($houses as $entry) {
            $house = House::create($entry['data']);

            if (!empty($entry['facilities'])) {
                $house->facilities()->sync($entry['facilities']);
            }
        }
    }
}