<?php

namespace Database\Seeders;

use App\Models\Consultant;
use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;

class ConsultantServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Resolve all category IDs by slug once
        $categories = ServiceCategory::pluck('id', 'slug');

        // Short aliases for readability
        $marketplace   = $categories['buying-selling-renting-marketplace']          ?? null;
        $designs       = $categories['architectural-designs-house-plans-marketplace'] ?? null;
        $marketing     = $categories['marketing-advertising-marketplace']             ?? null;
        $professionals = $categories['professionals-marketplace']                     ?? null;
        $agents        = $categories['terra-agents-room']                             ?? null;

        /**
         * Mapping: consultant email => category IDs they should be linked to.
         *
         * Rationale per consultant:
         *  1. Olivier Habimana      — Investment Consultant: operates across buying/selling marketplace + agents room
         *  2. Chantal Mukeshimana  — Mortgage/Finance: buying/selling marketplace + professionals marketplace
         *  3. Placide Ntwari       — Land Use/Zoning: buying/selling + professionals marketplace
         *  4. Yvonne Ingabire      — Property Development: all five (touches every service category)
         *  5. Serge Nkusi          — Tourism/Hospitality: buying/selling + marketing + professionals
         *  6. Annonciata Uwimana   — Diaspora/Relocation: buying/selling + marketing + agents room
         *  7. Dieudonne Gasana     — Affordable Housing: buying/selling + professionals marketplace
         *  8. Fabiola Nyirahabimana— Commercial RE: buying/selling + marketing + agents room
         *  9. Honorine Kayitesi    — Environmental/Green: architectural designs + professionals marketplace
         * 10. Amedee Nzabonimpa    — Tax/Legal Compliance: professionals marketplace + agents room
         */
        $mappings = [
            'o.habimana@consult.imari.rw' => array_filter([
                $marketplace,
                $agents,
            ]),
            'c.mukeshimana@consult.imari.rw' => array_filter([
                $marketplace,
                $professionals,
            ]),
            'p.ntwari@consult.imari.rw' => array_filter([
                $marketplace,
                $professionals,
            ]),
            'y.ingabire@consult.imari.rw' => array_filter([
                $marketplace,
                $designs,
                $marketing,
                $professionals,
                $agents,
            ]),
            's.nkusi@consult.imari.rw' => array_filter([
                $marketplace,
                $marketing,
                $professionals,
            ]),
            'a.uwimana@consult.imari.rw' => array_filter([
                $marketplace,
                $marketing,
                $agents,
            ]),
            'd.gasana@consult.imari.rw' => array_filter([
                $marketplace,
                $professionals,
            ]),
            'f.nyirahabimana@consult.imari.rw' => array_filter([
                $marketplace,
                $marketing,
                $agents,
            ]),
            'h.kayitesi@consult.imari.rw' => array_filter([
                $designs,
                $professionals,
            ]),
            'am.nzabonimpa@consult.imari.rw' => array_filter([
                $professionals,
                $agents,
            ]),
        ];

        foreach ($mappings as $email => $categoryIds) {
            $consultant = Consultant::where('email', $email)->first();

            if (! $consultant || empty($categoryIds)) {
                continue;
            }

            // syncWithoutDetaching keeps any manually added links intact
            $consultant->serviceCategories()->syncWithoutDetaching($categoryIds);
        }
    }
}