<?php

namespace Database\Seeders;

use App\Models\Tender;
use Illuminate\Database\Seeder;

class TenderSeeder extends Seeder
{
    public function run(): void
    {
        $tenders = [
            // 1 — Road construction, Gasabo
            [
                'user_id'             => 1,
                'title'               => 'Construction of Feeder Roads in Gasabo District — Phase II',
                'description'         => 'The Gasabo District invites sealed bids from eligible and qualified contractors for the construction of 12 km of feeder roads across Kimironko, Remera, and Nduba sectors. Scope of works includes earthworks and formation, sub-base and base course compaction, asphalt surface dressing, drainage culverts and side drains, road signage, and line markings. Bidders must possess a valid Rwanda Construction Industry Council (RCIC) registration in Road Works Category B or above, and demonstrate successful completion of at least two similar road projects of minimum RWF 500 million each within the past five years.',
                'reference_no'        => 'GD/INFRA/ROADS/2025/001',
                'budget'              => 1850000000.00,
                'submission_deadline' => now()->addDays(28)->toDateString(),
                'location'            => 'Gasabo District, Kigali City',
                'document_path'       => 'tenders/docs/GD-INFRA-ROADS-2025-001.pdf',
                'is_open'             => true,
            ],

            // 2 — School construction, Musanze
            [
                'user_id'             => 1,
                'title'               => 'Construction of 9-Classroom Secondary School Block, Musanze',
                'description'         => 'The Northern Province is seeking bids for the design and construction of a 9-classroom secondary school block in Muhoza Sector, Musanze District. Works include structural foundations, load-bearing masonry walls, roofing, doors and windows, electrical installations, sanitation blocks (separate for boys and girls), and landscaping. The project must be completed within 10 calendar months from the date of contract signing. Contractors must hold a valid RCIC Building Works Category C registration or higher.',
                'reference_no'        => 'NP/EDU/MUSANZE/2025/004',
                'budget'              => 620000000.00,
                'submission_deadline' => now()->addDays(21)->toDateString(),
                'location'            => 'Musanze District, Northern Province',
                'document_path'       => 'tenders/docs/NP-EDU-MUSANZE-2025-004.pdf',
                'is_open'             => true,
            ],

            // 3 — Office fit-out, Kigali CBD
            [
                'user_id'             => 2,
                'title'               => 'Interior Fit-Out of Government Office Premises — Kigali CBD',
                'description'         => 'A government institution invites proposals from interior design and fit-out firms for the complete refurbishment of a 1,400 m² open-plan office on the 5th and 6th floors of a building on KN 3 Avenue, Kigali. Scope includes: demolition of existing partitions, supply and installation of modular partition systems, raised access flooring, suspended ceilings, LED lighting upgrade, air conditioning units, server room fit-out, procurement of executive and operational furniture, and painting. Works must be executed without disruption to adjacent occupied floors.',
                'reference_no'        => 'GOV/WORKS/FITOUT/2025/011',
                'budget'              => 380000000.00,
                'submission_deadline' => now()->addDays(18)->toDateString(),
                'location'            => 'Nyarugenge District, Kigali City',
                'document_path'       => 'tenders/docs/GOV-WORKS-FITOUT-2025-011.pdf',
                'is_open'             => true,
            ],

            // 4 — Water supply, Nyamagabe
            [
                'user_id'             => 2,
                'title'               => 'Rural Piped Water Supply System — Nyamagabe District',
                'description'         => 'The Water and Sanitation Corporation (WASAC) invites bids for the construction of a rural gravity-fed piped water scheme serving approximately 8,500 households across four sectors of Nyamagabe District, Southern Province. Works include: intake construction, sedimentation and filtration chamber, service reservoir (capacity 500 m³), 38 km of uPVC distribution mains, community water kiosks ×22, household connection infrastructure, and a supervisory control system. Contractors must have demonstrable experience in rural WASH infrastructure projects in Rwanda or the EAC region.',
                'reference_no'        => 'WASAC/RUR/NYG/2025/007',
                'budget'              => 2400000000.00,
                'submission_deadline' => now()->addDays(35)->toDateString(),
                'location'            => 'Nyamagabe District, Southern Province',
                'document_path'       => 'tenders/docs/WASAC-RUR-NYG-2025-007.pdf',
                'is_open'             => true,
            ],

            // 5 — Real estate development consultancy
            [
                'user_id'             => 3,
                'title'               => 'Consultancy Services for Affordable Housing Feasibility Study — Kigali',
                'description'         => 'Rwanda Housing Authority (RHA) invites expressions of interest from qualified consultancy firms to conduct a comprehensive feasibility study for a 500-unit affordable housing development in Bumbogo Sector, Gasabo District. Services required include: land suitability assessment, demand and market analysis, financial modelling and investment appraisal, infrastructure servicing strategy, environmental and social impact screening, and preparation of a bankable project brief for submission to development finance institutions. Firms must demonstrate prior experience in affordable housing studies in Sub-Saharan Africa.',
                'reference_no'        => 'RHA/CONSULT/AHS/2025/003',
                'budget'              => 95000000.00,
                'submission_deadline' => now()->addDays(14)->toDateString(),
                'location'            => 'Gasabo District, Kigali City',
                'document_path'       => 'tenders/docs/RHA-CONSULT-AHS-2025-003.pdf',
                'is_open'             => true,
            ],

            // 6 — Solar installation, Eastern Province
            [
                'user_id'             => 3,
                'title'               => 'Supply and Installation of Solar Power Systems for 40 Public Buildings — Eastern Province',
                'description'         => 'The Eastern Province invites bids from licensed electrical and renewable energy contractors for the supply, installation, commissioning, and two-year maintenance of rooftop solar photovoltaic systems for 40 government buildings including schools, health centres, and sector offices across Rwamagana, Kayonza, and Kirehe districts. Each system is between 5 kWp and 30 kWp. Works include panel mounting, inverter and battery storage installation, grid-tie or hybrid configuration, earthing and surge protection, and operator training.',
                'reference_no'        => 'EP/ENERGY/SOLAR/2025/009',
                'budget'              => 1100000000.00,
                'submission_deadline' => now()->addDays(30)->toDateString(),
                'location'            => 'Eastern Province (Rwamagana, Kayonza, Kirehe)',
                'document_path'       => 'tenders/docs/EP-ENERGY-SOLAR-2025-009.pdf',
                'is_open'             => true,
            ],

            // 7 — Health centre construction, Nyanza
            [
                'user_id'             => 4,
                'title'               => 'Construction of Sector Health Post — Busasamana Sector, Nyanza',
                'description'         => 'Nyanza District invites bids for the construction of a new sector health post in Busasamana Sector in accordance with Ministry of Health standard designs. Scope of works: site clearance and excavation, reinforced concrete foundations, masonry walling, roof structure and sheeting, internal finishes, plumbing and sanitation, electrical installation including solar backup, and external works including access path, fence, and pit latrine block. The contractor must complete all works within 8 months and provide a 12-month defects liability period.',
                'reference_no'        => 'NYZ/HEALTH/HP/2025/006',
                'budget'              => 145000000.00,
                'submission_deadline' => now()->addDays(20)->toDateString(),
                'location'            => 'Nyanza District, Southern Province',
                'document_path'       => 'tenders/docs/NYZ-HEALTH-HP-2025-006.pdf',
                'is_open'             => true,
            ],

            // 8 — Property valuation services
            [
                'user_id'             => 4,
                'title'               => 'Framework Agreement for Property Valuation Services — RLMUA',
                'description'         => 'Rwanda Land Management and Use Authority (RLMUA) invites proposals from registered and certified property valuers and valuation firms for a 2-year framework agreement to provide mass and individual property valuation services across all five provinces. Services include land valuation for registration and taxation purposes, building valuation for insurance and compensation, market rent assessments, and expert witness valuation reports. Individual call-off assignments will be issued quarterly. All valuers must be registered with the Institute of Real Property Valuers in Rwanda (IRPV).',
                'reference_no'        => 'RLMUA/SRVCS/VALUATION/2025/002',
                'budget'              => null, // framework — variable
                'submission_deadline' => now()->addDays(25)->toDateString(),
                'location'            => 'Nationwide (All Provinces)',
                'document_path'       => 'tenders/docs/RLMUA-SRVCS-VALUATION-2025-002.pdf',
                'is_open'             => true,
            ],

            // 9 — Drainage & flood mitigation, Nyamirambo
            [
                'user_id'             => 5,
                'title'               => 'Storm Drainage & Flood Mitigation Works — Nyamirambo, Kigali',
                'description'         => 'Kigali City invites bids for storm drainage and flood mitigation infrastructure works in the low-lying areas of Nyamirambo and Biryogo sectors, Nyarugenge District. Scope includes: channel clearing and lining of 3.5 km of primary drains, construction of 6 reinforced concrete box culverts, installation of trash screens, retaining wall construction in erosion-prone areas, and community awareness works. This project is funded by the World Bank under the Kigali Urban Resilience Programme (KURP).',
                'reference_no'        => 'KCC/INFRA/DRAIN/2025/015',
                'budget'              => 870000000.00,
                'submission_deadline' => now()->addDays(22)->toDateString(),
                'location'            => 'Nyarugenge District, Kigali City',
                'document_path'       => 'tenders/docs/KCC-INFRA-DRAIN-2025-015.pdf',
                'is_open'             => true,
            ],

            // 10 — Market construction, Huye
            [
                'user_id'             => 5,
                'title'               => 'Construction of Modern Market Facility — Huye District',
                'description'         => 'Huye District invites bids for the construction of a two-phase modern market facility in Ngoma Sector to replace the existing informal market. Phase 1 (this contract) covers: site infrastructure, a covered trading hall of 2,400 m² with 180 lockable stalls, cold storage rooms, ablution blocks, waste management area, loading bay, perimeter fencing, and access roads. Phase 2 (future) will add an administration block and car park. The market design must incorporate passive ventilation and rainwater harvesting in compliance with Kigali Green City guidelines.',
                'reference_no'        => 'HUY/MARKET/NGOMA/2025/008',
                'budget'              => 950000000.00,
                'submission_deadline' => now()->addDays(32)->toDateString(),
                'location'            => 'Huye District, Southern Province',
                'document_path'       => 'tenders/docs/HUY-MARKET-NGOMA-2025-008.pdf',
                'is_open'             => true,
            ],

            // 11 — ICT infrastructure, university
            [
                'user_id'             => 1,
                'title'               => 'Supply and Installation of ICT Infrastructure — University of Rwanda Huye Campus',
                'description'         => 'The University of Rwanda invites bids from ICT system integrators for the supply, installation, and commissioning of a campus-wide ICT infrastructure upgrade at the Huye Campus. Scope includes: structured cabling (Cat6A) across 8 buildings, core and distribution network switching, campus Wi-Fi (400+ access points), CCTV and access control system, video conferencing equipment for 5 seminar rooms, a 20-rack data centre fit-out, and a 3-year support and maintenance contract. Bidders must be certified partners of recognised network vendors (Cisco, HPE, Huawei, or equivalent).',
                'reference_no'        => 'UR/ICT/HUYE/2025/012',
                'budget'              => 780000000.00,
                'submission_deadline' => now()->addDays(27)->toDateString(),
                'location'            => 'Huye District, Southern Province',
                'document_path'       => 'tenders/docs/UR-ICT-HUYE-2025-012.pdf',
                'is_open'             => true,
            ],

            // 12 — Closed / expired tender (historical record)
            [
                'user_id'             => 2,
                'title'               => 'Rehabilitation of Kicukiro–Gahanga Access Road',
                'description'         => 'Kicukiro District invited bids for the rehabilitation of a 4.2 km access road connecting Gahanga Sector to the main Kigali–Huye national highway. Works included: removal of failed pavement, road base reconstruction, double surface dressing, culvert replacement ×8, pedestrian footpath on one side, and street lighting for 1.5 km of the urban section. The project was financed under the Local Government Infrastructure Support Programme (LGISP). This tender is now closed; contract has been awarded.',
                'reference_no'        => 'KIC/ROADS/GAHANGA/2024/019',
                'budget'              => 540000000.00,
                'submission_deadline' => now()->subDays(15)->toDateString(),
                'location'            => 'Kicukiro District, Kigali City',
                'document_path'       => 'tenders/docs/KIC-ROADS-GAHANGA-2024-019.pdf',
                'is_open'             => false,
            ],
        ];

        foreach ($tenders as $tender) {
            Tender::create($tender);
        }
    }
}