<?php

namespace Database\Seeders;

use App\Models\Land;
use Illuminate\Database\Seeder;

class LandSeeder extends Seeder
{
    public function run(): void
    {
        $lands = [
            // 1 — Residential plot, Kigali (Kiyovu)
            [
                'user_id'          => 1,
                'service_id'       => 1, // For Sale
                'title'            => 'Prime Residential Plot in Kiyovu, Kigali',
                'description'      => 'A rare opportunity to acquire a flat, fully serviced residential plot in the heart of Kiyovu — Kigali\'s most prestigious neighbourhood. The plot is connected to mains water, electricity, and a tarmac road. Surrounded by embassies, upscale villas, and international schools. Ideal for constructing a high-end home or boutique guesthouse. UPI verified and title deed ready for immediate transfer.',
                'price'            => 95000000,   // RWF
                'size_sqm'        => 600,
                'zoning'          => 'R1',
                'land_use'        => 'Housing',
                'province'        => 'Kigali City',
                'district'        => 'Nyarugenge',
                'sector'          => 'Kiyovu',
                'cell'            => 'Inganzo',
                'village'         => 'Inganzo I',
                'upi'             => '1/01/01/01/0123',
                'title_doc'       => 'title_docs/kiyovu_plot_001.pdf',
                'is_title_verified' => true,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(6),
            ],

            // 2 — Commercial land, CBD Kigali
            [
                'user_id'          => 1,
                'service_id'       => 1,
                'title'            => 'Commercial Land on KN 3 Ave, Kigali CBD',
                'description'      => 'Strategically located commercial plot on one of Kigali\'s busiest arterial roads, KN 3 Avenue, directly facing the Kigali Convention Centre precinct. Zoned for high-density commercial use — suitable for a hotel, mixed-use tower, or retail complex. Flat topography, excellent road frontage, and all utilities at the boundary. Freehold title deed available.',
                'price'            => 320000000,
                'size_sqm'        => 1200,
                'zoning'          => 'Commercial',
                'land_use'        => 'Commercial Development',
                'province'        => 'Kigali City',
                'district'        => 'Nyarugenge',
                'sector'          => 'Nyarugenge',
                'cell'            => 'Biryogo',
                'village'         => 'Biryogo I',
                'upi'             => '1/01/01/02/0456',
                'title_doc'       => 'title_docs/kn3_commercial_002.pdf',
                'is_title_verified' => true,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(4),
            ],

            // 3 — Residential plot, Nyarutarama
            [
                'user_id'          => 2,
                'service_id'       => 1,
                'title'            => 'Serviced Residential Plot in Nyarutarama',
                'description'      => 'Well-situated residential plot in Nyarutarama, Kigali\'s most exclusive residential enclave adjacent to the golf course. The plot enjoys gentle terrain with natural drainage, tarmac road access, and proximity to international restaurants, supermarkets, and private clinics. Perfect for a luxury family home or investment property. Title deed verified by RLMUA.',
                'price'            => 140000000,
                'size_sqm'        => 800,
                'zoning'          => 'R1',
                'land_use'        => 'Housing',
                'province'        => 'Kigali City',
                'district'        => 'Gasabo',
                'sector'          => 'Remera',
                'cell'            => 'Nyarutarama',
                'village'         => 'Nyarutarama II',
                'upi'             => '1/02/05/03/0789',
                'title_doc'       => 'title_docs/nyarutarama_plot_003.pdf',
                'is_title_verified' => true,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(5),
            ],

            // 4 — Agricultural land, Musanze
            [
                'user_id'          => 2,
                'service_id'       => 1,
                'title'            => 'Fertile Agricultural Land in Musanze District',
                'description'      => 'Large expanse of fertile agricultural land in the volcanic highlands of Musanze, renowned for rich soils ideal for Irish potato, pyrethrum, and horticulture. The land is currently under cultivation and comes with an active borehole. Stunning backdrop of the Virunga volcanoes. Suitable for commercial farming, agritourism, or reforestation projects. Traditional land use rights with ongoing formalisation.',
                'price'            => 28000000,
                'size_sqm'        => 15000,
                'zoning'          => 'Agricultural',
                'land_use'        => 'Farming',
                'province'        => 'Northern Province',
                'district'        => 'Musanze',
                'sector'          => 'Muhoza',
                'cell'            => 'Cyabararika',
                'village'         => 'Rutare',
                'upi'             => '4/05/02/01/1011',
                'title_doc'       => 'title_docs/musanze_agri_004.pdf',
                'is_title_verified' => false,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(8),
            ],

            // 5 — Mixed-use plot, Huye
            [
                'user_id'          => 3,
                'service_id'       => 1,
                'title'            => 'Mixed-Use Plot Near University of Rwanda, Huye',
                'description'      => 'Excellent investment plot situated 500 metres from the University of Rwanda main campus in Huye (Butare). Zoned for mixed residential and commercial use, making it ideal for student accommodation, a hostel, restaurant, or retail block. High footfall area near the National Museum of Rwanda. Mains electricity and water connected. Clear freehold title.',
                'price'            => 18500000,
                'size_sqm'        => 950,
                'zoning'          => 'R2',
                'land_use'        => 'Residential / Commercial',
                'province'        => 'Southern Province',
                'district'        => 'Huye',
                'sector'          => 'Ngoma',
                'cell'            => 'Matyazo',
                'village'         => 'Matyazo I',
                'upi'             => '3/07/01/04/1213',
                'title_doc'       => 'title_docs/huye_mixeduse_005.pdf',
                'is_title_verified' => true,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(6),
            ],

            // 6 — Lakefront plot, Rubavu (Gisenyi)
            [
                'user_id'          => 3,
                'service_id'       => 1,
                'title'            => 'Lakefront Plot on Lake Kivu Shore, Rubavu',
                'description'      => 'Extraordinary lakefront plot with direct water frontage on the shores of Lake Kivu in Rubavu (Gisenyi). This flat, sandy plot is perfectly positioned for a boutique hotel, beach resort, or private lakeside residence. Breathtaking views of the Congo mountains across the lake. Just 1 km from Rubavu town centre and 5 km from the DRC border crossing. A genuinely rare listing on Kivu\'s most sought-after shoreline.',
                'price'            => 210000000,
                'size_sqm'        => 2500,
                'zoning'          => 'R1',
                'land_use'        => 'Hospitality / Housing',
                'province'        => 'Western Province',
                'district'        => 'Rubavu',
                'sector'          => 'Rubavu',
                'cell'            => 'Kivumu',
                'village'         => 'Kivumu II',
                'upi'             => '5/03/06/02/1415',
                'title_doc'       => 'title_docs/rubavu_lakefront_006.pdf',
                'is_title_verified' => true,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(3),
            ],

            // 7 — Industrial land, Bugesera SEZ
            [
                'user_id'          => 4,
                'service_id'       => 1,
                'title'            => 'Industrial Plot in Bugesera Special Economic Zone',
                'description'      => 'Large industrial plot within the Bugesera Special Economic Zone (SEZ), adjacent to the new Bugesera International Airport. The plot is fully serviced with heavy-duty road access, three-phase electricity, and industrial water supply. Ideal for a warehouse, manufacturing plant, cold storage, or logistics hub. Tax incentives apply under Rwanda\'s SEZ framework. Freehold title, RSSB and RDB registered.',
                'price'            => 175000000,
                'size_sqm'        => 10000,
                'zoning'          => 'Industrial',
                'land_use'        => 'Manufacturing / Logistics',
                'province'        => 'Eastern Province',
                'district'        => 'Bugesera',
                'sector'          => 'Rilima',
                'cell'            => 'Gako',
                'village'         => 'Gako SEZ',
                'upi'             => '2/08/04/03/1617',
                'title_doc'       => 'title_docs/bugesera_industrial_007.pdf',
                'is_title_verified' => true,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(12),
            ],

            // 8 — Residential plot, Kimironko
            [
                'user_id'          => 4,
                'service_id'       => 1,
                'title'            => 'Affordable Residential Plot in Kimironko',
                'description'      => 'Affordable and well-connected residential plot in Kimironko, one of Kigali\'s most densely populated and commercially active suburbs. The plot is a short walk from Kimironko market, buses to the CBD, and Kigali\'s largest second-hand goods market. Electricity pole on the boundary and water main nearby. A solid entry-level investment with strong rental demand in the surrounding area.',
                'price'            => 32000000,
                'size_sqm'        => 400,
                'zoning'          => 'R1',
                'land_use'        => 'Housing',
                'province'        => 'Kigali City',
                'district'        => 'Gasabo',
                'sector'          => 'Kimironko',
                'cell'            => 'Kibagabaga',
                'village'         => 'Kibagabaga I',
                'upi'             => '1/02/06/05/1819',
                'title_doc'       => 'title_docs/kimironko_plot_008.pdf',
                'is_title_verified' => true,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(5),
            ],

            // 9 — Tourism / Eco land, Nyungwe corridor
            [
                'user_id'          => 5,
                'service_id'       => 1,
                'title'            => 'Eco-Tourism Land on Nyungwe Forest Corridor, Nyamasheke',
                'description'      => 'Unique eco-tourism and conservation plot bordering the Nyungwe Forest National Park buffer zone in Nyamasheke district. The forested terrain is rich in biodiversity, with indigenous hardwoods, birds, and primates. Suitable for an eco-lodge, nature camp, or reforestation carbon-credit project. Access via murram road off the Kibuye–Cyangugu highway. Investors must comply with RDB eco-tourism development guidelines.',
                'price'            => 45000000,
                'size_sqm'        => 30000,
                'zoning'          => 'R3',
                'land_use'        => 'Eco-Tourism / Forestry',
                'province'        => 'Western Province',
                'district'        => 'Nyamasheke',
                'sector'          => 'Kagano',
                'cell'            => 'Gitwa',
                'village'         => 'Gitwa II',
                'upi'             => '5/09/07/01/2021',
                'title_doc'       => 'title_docs/nyamasheke_eco_009.pdf',
                'is_title_verified' => false,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(10),
            ],

            // 10 — Residential plot, Kicukiro (Gahanga)
            [
                'user_id'          => 5,
                'service_id'       => 1,
                'title'            => 'Gated Estate Plot in Gahanga, Kicukiro',
                'description'      => 'Well-priced residential plot within a developing gated estate in Gahanga sector, Kicukiro — one of Kigali\'s fastest-growing peri-urban zones. The estate has a master plan with paved internal roads, a perimeter wall, and shared borehole water. Close to Gahanga Cricket Oval, the Kigali–Huye highway, and several new schools and clinics. Ideal for building a mid-range family home. Title deed in progress with RLMUA.',
                'price'            => 22000000,
                'size_sqm'        => 500,
                'zoning'          => 'R1',
                'land_use'        => 'Housing',
                'province'        => 'Kigali City',
                'district'        => 'Kicukiro',
                'sector'          => 'Gahanga',
                'cell'            => 'Kabeza',
                'village'         => 'Kabeza II',
                'upi'             => '1/03/08/02/2223',
                'title_doc'       => 'title_docs/gahanga_plot_010.pdf',
                'is_title_verified' => false,
                'status'          => 'available',
                'is_approved'     => true,
                'expires_at'      => now()->addMonths(7),
            ],
        ];

        foreach ($lands as $land) {
            Land::create($land);
        }
    }
}