<?php

namespace Database\Seeders;

use App\Models\Consultant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ConsultantSeeder extends Seeder
{
    public function run(): void
    {
        $consultants = [
            // 1 — Real Estate Investment Consultant
            [
                'user' => [
                    'name'              => 'Olivier Habimana',
                    'email'             => 'o.habimana@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Olivier Habimana',
                    'title'     => 'Real Estate Investment Consultant',
                    'email'     => 'o.habimana@consult.imari.rw',
                    'phone'     => '+250788201001',
                    'photo'     => 'consultants/olivier-habimana.jpg',
                    'bio'       => 'Olivier is a senior real estate investment consultant with 14 years of experience advising institutional investors, private equity firms, and high-net-worth individuals on property acquisitions, portfolio management, and market entry strategies in Rwanda and the broader East African region. He has advised on transactions exceeding RWF 50 billion and holds an MBA in Finance from the University of Cape Town. Olivier is a board member of the Rwanda Real Estate Association (RREA) and a regular contributor to the Kigali Finance Centre investment forums.',
                    'is_active' => true,
                ],
            ],

            // 2 — Property Finance & Mortgage Consultant
            [
                'user' => [
                    'name'              => 'Chantal Mukeshimana',
                    'email'             => 'c.mukeshimana@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Chantal Mukeshimana',
                    'title'     => 'Property Finance & Mortgage Consultant',
                    'email'     => 'c.mukeshimana@consult.imari.rw',
                    'phone'     => '+250722202002',
                    'photo'     => 'consultants/chantal-mukeshimana.jpg',
                    'bio'       => 'Chantal is a certified property finance consultant with a decade of experience helping individuals and businesses navigate mortgage products, home equity financing, and construction loans offered by Rwandan commercial banks and microfinance institutions. She has deep knowledge of BK, Equity Bank, I&M, Cogebanque, and Urwego Bank lending criteria, interest structures, and approval processes. Chantal previously worked as a credit analyst and brings a banker\'s rigour to helping clients secure the best possible financing terms for their property purchases.',
                    'is_active' => true,
                ],
            ],

            // 3 — Land Use & Zoning Consultant
            [
                'user' => [
                    'name'              => 'Placide Ntwari',
                    'email'             => 'p.ntwari@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Placide Ntwari',
                    'title'     => 'Land Use & Zoning Consultant',
                    'email'     => 'p.ntwari@consult.imari.rw',
                    'phone'     => '+250738203003',
                    'photo'     => 'consultants/placide-ntwari.jpg',
                    'bio'       => 'Placide is a specialist land use and zoning consultant with 11 years of experience interpreting and applying Rwanda\'s Detailed Physical Plans (DPPs), Kigali City Master Plan, and district-level spatial plans for developers, investors, and landowners. He guides clients through change-of-use applications, plot amalgamation, variance requests, and building permit compliance. Placide previously served as a planner within Kigali City\'s Department of Urbanisation and Infrastructure, giving him unmatched insight into the regulatory decision-making process.',
                    'is_active' => true,
                ],
            ],

            // 4 — Property Development Consultant
            [
                'user' => [
                    'name'              => 'Yvonne Ingabire',
                    'email'             => 'y.ingabire@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Yvonne Ingabire',
                    'title'     => 'Property Development Consultant',
                    'email'     => 'y.ingabire@consult.imari.rw',
                    'phone'     => '+250788204004',
                    'photo'     => 'consultants/yvonne-ingabire.jpg',
                    'bio'       => 'Yvonne is a property development consultant specialising in guiding developers from site acquisition through planning, design, contractor procurement, construction management, and final sales or leasing. She has overseen the delivery of over 15 residential and mixed-use projects in Kigali, including apartment blocks in Remera and Kimihurura, and a gated estate in Gahanga. Yvonne holds a BSc in Quantity Surveying from the University of Rwanda and a Postgraduate Certificate in Property Development from RICS.',
                    'is_active' => true,
                ],
            ],

            // 5 — Tourism & Hospitality Property Consultant
            [
                'user' => [
                    'name'              => 'Serge Nkusi',
                    'email'             => 's.nkusi@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Serge Nkusi',
                    'title'     => 'Tourism & Hospitality Property Consultant',
                    'email'     => 's.nkusi@consult.imari.rw',
                    'phone'     => '+250722205005',
                    'photo'     => 'consultants/serge-nkusi.jpg',
                    'bio'       => 'Serge is a tourism and hospitality property consultant with 9 years of experience advising investors on hotel acquisitions, eco-lodge developments, and serviced apartment projects in Rwanda\'s key tourism destinations — Lake Kivu, Volcanoes National Park, Nyungwe Forest, and Kigali. He works closely with the Rwanda Development Board (RDB) tourism investment desk and has facilitated RDB tourism investment certificates for seven projects. Serge holds a degree in Hospitality Management from Glion Institute (Switzerland) and speaks five languages.',
                    'is_active' => true,
                ],
            ],

            // 6 — Diaspora Property Consultant
            [
                'user' => [
                    'name'              => 'Annonciata Uwimana',
                    'email'             => 'a.uwimana@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Annonciata Uwimana',
                    'title'     => 'Diaspora Property & Relocation Consultant',
                    'email'     => 'a.uwimana@consult.imari.rw',
                    'phone'     => '+250738206006',
                    'photo'     => 'consultants/annonciata-uwimana.jpg',
                    'bio'       => 'Annonciata is Rwanda\'s leading diaspora property consultant, assisting Rwandans living in the UK, Belgium, USA, Canada, and Australia to invest in property back home. She manages the end-to-end process remotely — from market briefing and property shortlisting to legal due diligence, title transfer, and post-purchase management — so that diaspora clients never need to be physically present for their transaction. Annonciata spent 8 years in Brussels before returning to Kigali and understands firsthand the challenges diaspora investors face.',
                    'is_active' => true,
                ],
            ],

            // 7 — Affordable Housing Consultant
            [
                'user' => [
                    'name'              => 'Dieudonne Gasana',
                    'email'             => 'd.gasana@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Dieudonne Gasana',
                    'title'     => 'Affordable Housing & Social Development Consultant',
                    'email'     => 'd.gasana@consult.imari.rw',
                    'phone'     => '+250788207007',
                    'photo'     => 'consultants/dieudonne-gasana.jpg',
                    'bio'       => 'Dieudonne is a housing and social development consultant with 12 years of experience advising the Rwanda Housing Authority (RHA), district administrations, NGOs, and cooperative housing societies on affordable and social housing programmes. He has contributed to the design of Rwanda\'s National Housing Policy and has field experience implementing incremental housing projects in Kigali\'s informal settlements. Dieudonne holds an MSc in Housing and Urban Development from IHS Rotterdam (Netherlands) and advocates for community-led housing solutions.',
                    'is_active' => true,
                ],
            ],

            // 8 — Commercial Real Estate Consultant
            [
                'user' => [
                    'name'              => 'Fabiola Nyirahabimana',
                    'email'             => 'f.nyirahabimana@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Fabiola Nyirahabimana',
                    'title'     => 'Commercial Real Estate Consultant',
                    'email'     => 'f.nyirahabimana@consult.imari.rw',
                    'phone'     => '+250722208008',
                    'photo'     => 'consultants/fabiola-nyirahabimana.jpg',
                    'bio'       => 'Fabiola is a commercial real estate consultant with 8 years of experience in office leasing, retail strategy, and commercial property investment across Kigali\'s Central Business District, Kimihurura, and Kacyiru. She advises multinational companies, embassies, and NGOs on office space requirements, lease negotiations, and workspace strategy. Fabiola has represented tenants and landlords in over 120 commercial transactions and holds a Bachelor\'s degree in Business Administration and a RICS-accredited Commercial Real Estate certificate.',
                    'is_active' => true,
                ],
            ],

            // 9 — Environmental & Sustainability Consultant
            [
                'user' => [
                    'name'              => 'Honorine Kayitesi',
                    'email'             => 'h.kayitesi@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Honorine Kayitesi',
                    'title'     => 'Environmental & Green Building Consultant',
                    'email'     => 'h.kayitesi@consult.imari.rw',
                    'phone'     => '+250738209009',
                    'photo'     => 'consultants/honorine-kayitesi.jpg',
                    'bio'       => 'Honorine is an environmental and green building consultant specialising in Environmental and Social Impact Assessments (ESIAs), EDGE green building certifications, and sustainable construction advisory for property developers in Rwanda. She has prepared over 30 ESIAs submitted to the Rwanda Environment Management Authority (REMA) and has guided six buildings through the EDGE certification process. Honorine holds an MSc in Environmental Management from Makerere University and is an accredited EDGE Expert and REMA-registered environmental practitioner.',
                    'is_active' => true,
                ],
            ],

            // 10 — Property Tax & Legal Compliance Consultant (inactive)
            [
                'user' => [
                    'name'              => 'Amedee Nzabonimpa',
                    'email'             => 'am.nzabonimpa@consult.imari.rw',
                    'password'          => Hash::make('Consult@1234'),
                    'email_verified_at' => now(),
                ],
                'consultant' => [
                    'name'      => 'Amedee Nzabonimpa',
                    'title'     => 'Property Tax & Legal Compliance Consultant',
                    'email'     => 'am.nzabonimpa@consult.imari.rw',
                    'phone'     => '+250788210010',
                    'photo'     => 'consultants/amedee-nzabonimpa.jpg',
                    'bio'       => 'Amedee is a property tax and legal compliance consultant with 13 years of experience advising property owners, landlords, and developers on Rwanda Revenue Authority (RRA) property taxes, rental income declarations, capital gains tax on property disposals, and compliance with the Condominium Law. He has represented clients in RRA tax dispute resolution processes and has published extensively on the intersection of Rwanda\'s land law and tax regime. Amedee holds an LLM in Tax Law from the University of Pretoria and is a member of the Rwanda Bar Association.',
                    'is_active' => false, // currently on sabbatical
                ],
            ],
        ];

        foreach ($consultants as $entry) {
            $user = User::firstOrCreate(
                ['email' => $entry['user']['email']],
                $entry['user']
            );

            Consultant::firstOrCreate(
                ['email' => $entry['consultant']['email']],
                array_merge($entry['consultant'], ['user_id' => $user->id])
            );
        }
    }
}