<?php

namespace Database\Seeders;

use App\Models\ArchitecturalDesign;
use App\Models\DesignCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArchitecturalDesignSeeder extends Seeder
{
    public function run(): void
    {
        // Helper: resolve category ID by slug
        $cat = fn(string $slug) => DesignCategory::where('slug', $slug)->value('id');

        $designs = [
            // 1 — Modern 4-bedroom family villa
            [
                'title'         => 'Modern 4-Bedroom Family Villa',
                'user_id'       => 1,
                'service_id'    => 1,
                'category_id'   => $cat('residential'),
                'description'   => 'A contemporary single-storey family villa designed for the Rwandan climate, featuring wide overhanging eaves for shade, natural cross-ventilation, and an open-plan kitchen-dining-living area. The design includes 4 bedrooms, 3 bathrooms, a servant\'s quarter, double garage, and a landscaped front courtyard. Fully compliant with Kigali City master plan setback and floor-area-ratio requirements. Supplied with full architectural, structural, and MEP drawings.',
                'design_file'   => 'designs/files/modern-4bed-villa.zip',
                'preview_image' => 'designs/previews/modern-4bed-villa.jpg',
                'price'         => 850000,   // RWF
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => true,
            ],

            // 2 — Compact 2-bedroom starter home
            [
                'title'         => 'Compact 2-Bedroom Starter Home',
                'user_id'       => 1,
                'service_id'    => 1,
                'category_id'   => $cat('residential'),
                'description'   => 'An affordable yet elegant starter home design ideal for plots of 300–500 m². Features 2 bedrooms, 1 bathroom, an open living and kitchen area, and a covered veranda. The design maximises space efficiency and uses locally available materials — brick, iron sheet roofing, and timber — to keep construction costs low. Perfect for peri-urban areas such as Gahanga, Kimironko, or Muhanga.',
                'design_file'   => 'designs/files/2bed-starter-home.zip',
                'preview_image' => 'designs/previews/2bed-starter-home.jpg',
                'price'         => 0,
                'is_free'       => true,
                'status'        => 'approved',
                'featured'      => false,
            ],

            // 3 — Duplex apartment block (G+3)
            [
                'title'         => 'G+3 Apartment Block — 12 Units',
                'user_id'       => 2,
                'service_id'    => 1,
                'category_id'   => $cat('residential'),
                'description'   => 'A four-storey (G+3) apartment block yielding 12 two-bedroom units, designed for high-density residential zones in Kigali. Each floor has 3 units per level with a shared staircase and lift shaft provision. The façade incorporates vertical louvres and balconies for aesthetic appeal and passive cooling. Full BOQ, structural drawings, and utility schematics included. Designed in accordance with Rwanda Building Code 2022.',
                'design_file'   => 'designs/files/g3-apartment-block-12units.zip',
                'preview_image' => 'designs/previews/g3-apartment-block.jpg',
                'price'         => 2500000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => true,
            ],

            // 4 — Boutique hotel, Lake Kivu
            [
                'title'         => 'Lakeside Boutique Hotel — 20 Rooms',
                'user_id'       => 2,
                'service_id'    => 1,
                'category_id'   => $cat('hospitality-tourism'),
                'description'   => 'A 20-room boutique hotel concept inspired by the vernacular architecture of the Great Lakes region, positioned for lakefront sites on Lake Kivu. The design features tiered terraces cascading towards the water, a rooftop bar, infinity pool, restaurant pavilion, and reception block. Each room has a private balcony with lake views. Designed to meet RDB\'s tourism star-rating guidelines and minimise environmental footprint with a grey-water recycling system.',
                'design_file'   => 'designs/files/lakeside-boutique-hotel.zip',
                'preview_image' => 'designs/previews/lakeside-boutique-hotel.jpg',
                'price'         => 4500000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => true,
            ],

            // 5 — Eco lodge, Nyungwe corridor
            [
                'title'         => 'Eco-Lodge Forest Retreat — 8 Chalets',
                'user_id'       => 3,
                'service_id'    => 1,
                'category_id'   => $cat('eco-sustainable'),
                'description'   => 'A low-impact eco-lodge design comprising 8 standalone chalets, a central dining and lounge pavilion, and a ranger station. Designed for forested highland sites near Nyungwe or Volcanoes National Park. All structures use rammed earth walls, reclaimed timber, and green roofs seeded with indigenous grasses. Solar and micro-hydro power systems, rainwater harvesting, and composting toilets are fully detailed. RDB eco-tourism compliance documentation included.',
                'design_file'   => 'designs/files/eco-lodge-8chalets.zip',
                'preview_image' => 'designs/previews/eco-lodge-8chalets.jpg',
                'price'         => 3200000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => false,
            ],

            // 6 — Commercial plaza (G+2)
            [
                'title'         => 'Modern Commercial Plaza — G+2',
                'user_id'       => 3,
                'service_id'    => 1,
                'category_id'   => $cat('commercial'),
                'description'   => 'A three-storey commercial plaza suitable for busy urban arterials in Kigali, Huye, or Rubavu. Ground floor is designed for retail and banking hall use; upper floors accommodate open-plan offices with modular fit-out options. The building features a glazed curtain wall façade, underground parking for 20 vehicles, and a rooftop plant room. Full fire escape, disabled access, and electrical single-line diagrams included.',
                'design_file'   => 'designs/files/commercial-plaza-g2.zip',
                'preview_image' => 'designs/previews/commercial-plaza-g2.jpg',
                'price'         => 3800000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => false,
            ],

            // 7 — Primary school block
            [
                'title'         => '6-Classroom Primary School Block',
                'user_id'       => 4,
                'service_id'    => 1,
                'category_id'   => $cat('institutional-public'),
                'description'   => 'A single-storey six-classroom primary school block designed to MINEDUC\'s standard infrastructure guidelines for Rwanda. The design incorporates a wide covered walkway, natural lighting through high-level clerestory windows, separate boys\' and girls\' latrines, a headteacher\'s office, and a staff room. The structure uses load-bearing brick with a corrugated iron roof and is optimised for construction in rural and peri-urban districts. Provided free to support community development.',
                'design_file'   => 'designs/files/primary-school-6class.zip',
                'preview_image' => 'designs/previews/primary-school-6class.jpg',
                'price'         => 0,
                'is_free'       => true,
                'status'        => 'approved',
                'featured'      => false,
            ],

            // 8 — Health centre / clinic
            [
                'title'         => 'Community Health Centre Design',
                'user_id'       => 4,
                'service_id'    => 1,
                'category_id'   => $cat('institutional-public'),
                'description'   => 'A single-storey community health centre (Health Post level) designed in line with Rwanda Ministry of Health spatial standards. The layout includes a waiting area, triage room, consultation rooms ×3, maternity ward ×4 beds, pharmacy, lab, and staff room. Designed for infection control with separate clean and dirty corridors, hand-wash stations at every point of care, and natural ventilation. Adaptable for both urban neighbourhood clinics and rural sector health posts.',
                'design_file'   => 'designs/files/community-health-centre.zip',
                'preview_image' => 'designs/previews/community-health-centre.jpg',
                'price'         => 1200000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => false,
            ],

            // 9 — Warehouse / light industrial
            [
                'title'         => 'Light Industrial Warehouse — 1,500 m²',
                'user_id'       => 5,
                'service_id'    => 1,
                'category_id'   => $cat('industrial'),
                'description'   => 'A portal-frame steel warehouse of 1,500 m² gross floor area, designed for industrial plots in Bugesera SEZ, Kigali Special Economic Zone, or Nyandungu industrial park. Includes a truck loading dock with roller shutter doors ×4, mezzanine office block of 200 m², staff ablutions, security gatehouse, and perimeter drainage. Three-phase power and heavy water supply connections are detailed. Designed for fast construction with pre-engineered steel frames.',
                'design_file'   => 'designs/files/warehouse-1500sqm.zip',
                'preview_image' => 'designs/previews/warehouse-1500sqm.jpg',
                'price'         => 2800000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => true,
            ],

            // 10 — Mixed-use building (residential + retail)
            [
                'title'         => 'Mixed-Use Building — Retail Ground, 8 Apartments Above',
                'user_id'       => 5,
                'service_id'    => 1,
                'category_id'   => $cat('mixed-use'),
                'description'   => 'A G+2 mixed-use building with four retail units on the ground floor and eight one-bedroom apartments across two upper floors. Tailored for busy commercial corridors in Remera, Nyamirambo, or Musanze town. The design separates retail and residential circulation, includes covered parking for 8 vehicles at the rear, and features a modern façade with aluminium cladding panels. Generates strong rental income from both residential and commercial tenants.',
                'design_file'   => 'designs/files/mixed-use-retail-apartments.zip',
                'preview_image' => 'designs/previews/mixed-use-retail-apartments.jpg',
                'price'         => 3100000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => false,
            ],

            // 11 — Penthouse interior design package
            [
                'title'         => 'Luxury Penthouse Interior Design Package',
                'user_id'       => 1,
                'service_id'    => 1,
                'category_id'   => $cat('interior-design'),
                'description'   => 'A complete interior design package for a high-end penthouse or executive apartment in Kigali. Includes mood boards, furniture layout plans, 3D rendered views of all rooms, material and finish schedules, lighting design, and kitchen/bathroom joinery drawings. The design blends contemporary African aesthetics — woven textures, warm timbers, and earthy stone — with international luxury standards. Suitable for self-build clients, developers, or property investors staging for sale.',
                'design_file'   => 'designs/files/luxury-penthouse-interior.zip',
                'preview_image' => 'designs/previews/luxury-penthouse-interior.jpg',
                'price'         => 1800000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => true,
            ],

            // 12 — Urban residential masterplan
            [
                'title'         => 'Residential Estate Masterplan — 50 Plots',
                'user_id'       => 2,
                'service_id'    => 1,
                'category_id'   => $cat('urban-planning'),
                'description'   => 'A full masterplan for a 50-plot gated residential estate on a 3–5 hectare site. Includes site layout with internal road network, drainage masterplan, utility servicing strategy, plot subdivision schedule, landscaping concept, gatehouse design, perimeter wall specification, and a design code for plot purchasers. Designed in compliance with Rwanda Urban Planning Code and the Kigali City Infrastructure Design Manual. Suitable for private developers or housing cooperatives.',
                'design_file'   => 'designs/files/residential-estate-masterplan-50plots.zip',
                'preview_image' => 'designs/previews/residential-estate-masterplan.jpg',
                'price'         => 5500000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => true,
            ],

            // 13 — Church / worship centre
            [
                'title'         => 'Contemporary Church & Community Hall',
                'user_id'       => 3,
                'service_id'    => 1,
                'category_id'   => $cat('religious-cultural'),
                'description'   => 'A 500-seat contemporary church design with an attached multi-purpose community hall for 200 persons. The sanctuary features a dramatic folded roof inspired by praying hands, clear-span trusses eliminating internal columns, full acoustic treatment, and a baptismal pool. The community hall can be partitioned for classrooms, meetings, or events. Pastor\'s office, prayer rooms, and a catering kitchen are included. Designed for both urban congregation plots and large rural church compounds.',
                'design_file'   => 'designs/files/church-community-hall.zip',
                'preview_image' => 'designs/previews/church-community-hall.jpg',
                'price'         => 2200000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => false,
            ],

            // 14 — Renovation / extension package
            [
                'title'         => 'Home Extension & Renovation Design Package',
                'user_id'       => 4,
                'service_id'    => 1,
                'category_id'   => $cat('renovation-remodelling'),
                'description'   => 'A flexible renovation and extension design package for existing Rwandan homes. Covers common upgrade scenarios: adding a second storey, extending ground-floor living areas, converting a flat roof to a pitched roof, upgrading kitchen and bathroom layouts, and adding a servant\'s quarter or garage. Each scenario comes with before/after drawings, structural assessment checklist, material quantities, and a phased construction guide to allow owners to build incrementally as funds permit.',
                'design_file'   => 'designs/files/home-extension-renovation-pack.zip',
                'preview_image' => 'designs/previews/home-extension-renovation.jpg',
                'price'         => 650000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => false,
            ],

            // 15 — Landscape / outdoor garden design
            [
                'title'         => 'Tropical Garden & Outdoor Living Design',
                'user_id'       => 5,
                'service_id'    => 1,
                'category_id'   => $cat('landscape-outdoor'),
                'description'   => 'A complete outdoor landscape design package for mid-to-large residential plots in Rwanda\'s highland climate. Includes a planting plan using indigenous and tropical species (bougainvillea, frangipani, bamboo, musambara hedge), hardscape layout with paved terraces and pathways, outdoor kitchen and braai area, water feature or koi pond option, garden lighting scheme, and irrigation plan. Supplied with a plant species list sourced from local Kigali nurseries and a maintenance guide.',
                'design_file'   => 'designs/files/tropical-garden-outdoor-living.zip',
                'preview_image' => 'designs/previews/tropical-garden-outdoor.jpg',
                'price'         => 480000,
                'is_free'       => false,
                'status'        => 'approved',
                'featured'      => false,
            ],
        ];

        foreach ($designs as $design) {
            $design['slug'] = Str::slug($design['title']);
            ArchitecturalDesign::firstOrCreate(
                ['slug' => $design['slug']],
                $design
            );
        }
    }
}