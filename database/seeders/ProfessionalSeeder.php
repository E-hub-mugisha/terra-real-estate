<?php

namespace Database\Seeders;

use App\Models\Professional;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProfessionalSeeder extends Seeder
{
    public function run(): void
    {
        $professionals = [
            // 1 — Architect
            [
                'user' => [
                    'name'              => 'Innocent Nkurunziza',
                    'email'             => 'i.nkurunziza@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Innocent Nkurunziza',
                    'email'            => 'i.nkurunziza@pro.imari.rw',
                    'phone'            => '+250788111201',
                    'whatsapp'         => '+250788111201',
                    'profession'       => 'Architect',
                    'license_number'   => 'RCIC/ARCH/2014/0042',
                    'years_experience' => 11,
                    'rating'           => 4.8,
                    'bio'              => 'Innocent is a registered architect with 11 years of professional practice in Rwanda, specialising in residential villas, mixed-use developments, and green building design. He studied architecture at the University of Rwanda and completed a postgraduate diploma in Sustainable Design at the University of Nairobi. His portfolio includes award-winning projects in Nyarutarama, Kimihurura, and the Musanze eco-tourism corridor. He is a full member of the Rwanda Institute of Architects (RIA) and a EDGE Green Building accredited professional.',
                    'services'         => json_encode([
                        'Architectural Design',
                        'Building Permit Drawings',
                        'Site Supervision',
                        'Green Building Certification',
                        '3D Visualisation',
                    ]),
                    'portfolio_url'    => 'https://portfolio.nkurunziza-arch.rw',
                    'credentials_doc'  => 'professionals/credentials/nkurunziza-arch.pdf',
                    'linkedin'         => 'https://linkedin.com/in/innocent-nkurunziza-arch',
                    'website'          => 'https://nkurunziza-arch.rw',
                    'office_location'  => 'KG 9 Ave, Kimihurura, Gasabo, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'English', 'French']),
                    'profile_image'    => 'professionals/innocent-nkurunziza.jpg',
                    'is_verified'      => true,
                ],
            ],

            // 2 — Structural Engineer
            [
                'user' => [
                    'name'              => 'Vestine Uwamariya',
                    'email'             => 'v.uwamariya@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Vestine Uwamariya',
                    'email'            => 'v.uwamariya@pro.imari.rw',
                    'phone'            => '+250722112202',
                    'whatsapp'         => '+250722112202',
                    'profession'       => 'Structural Engineer',
                    'license_number'   => 'REB/STRUCT/2016/0118',
                    'years_experience' => 9,
                    'rating'           => 4.7,
                    'bio'              => 'Vestine is a licensed structural engineer with 9 years of experience in the design and supervision of reinforced concrete, steel, and masonry structures across Rwanda. She holds a BSc in Civil Engineering from the University of Rwanda and an MSc in Structural Engineering from the Université Catholique de Louvain (Belgium). Her experience spans residential buildings, multi-storey commercial blocks, bridges, and public infrastructure projects. Vestine is a registered member of the Rwanda Engineers Board (REB) and has worked on MININFRA-funded projects.',
                    'services'         => json_encode([
                        'Structural Design',
                        'Foundation Assessment',
                        'Load-Bearing Calculations',
                        'Structural Inspections',
                        'Retrofit & Seismic Assessment',
                    ]),
                    'portfolio_url'    => 'https://vestine-struct.rw',
                    'credentials_doc'  => 'professionals/credentials/uwamariya-struct.pdf',
                    'linkedin'         => 'https://linkedin.com/in/vestine-uwamariya',
                    'website'          => 'https://vestine-struct.rw',
                    'office_location'  => 'KN 5 Rd, Kiyovu, Nyarugenge, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'French', 'English']),
                    'profile_image'    => 'professionals/vestine-uwamariya.jpg',
                    'is_verified'      => true,
                ],
            ],

            // 3 — Land Surveyor
            [
                'user' => [
                    'name'              => 'Faustin Habiyaremye',
                    'email'             => 'f.habiyaremye@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Faustin Habiyaremye',
                    'email'            => 'f.habiyaremye@pro.imari.rw',
                    'phone'            => '+250738113203',
                    'whatsapp'         => '+250738113203',
                    'profession'       => 'Land Surveyor',
                    'license_number'   => 'RLMUA/SURV/2013/0027',
                    'years_experience' => 12,
                    'rating'           => 4.9,
                    'bio'              => 'Faustin is one of Rwanda\'s most sought-after licensed land surveyors, with 12 years of experience in cadastral survey, topographic mapping, and plot demarcation across all five provinces. He is certified by the Rwanda Land Management and Use Authority (RLMUA) and uses industry-leading GPS total stations and drone photogrammetry technology. Faustin has worked on major subdivision projects in Kigali, rural land formalisation programmes in Eastern Province, and SEZ infrastructure surveys in Bugesera.',
                    'services'         => json_encode([
                        'Cadastral Survey',
                        'Topographic Survey',
                        'Plot Demarcation',
                        'Subdivision & Amalgamation',
                        'Drone Aerial Mapping',
                        'UPI Registration Support',
                    ]),
                    'portfolio_url'    => null,
                    'credentials_doc'  => 'professionals/credentials/habiyaremye-surv.pdf',
                    'linkedin'         => 'https://linkedin.com/in/faustin-habiyaremye',
                    'website'          => null,
                    'office_location'  => 'KG 7 Ave, Kacyiru, Gasabo, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'French', 'English']),
                    'profile_image'    => 'professionals/faustin-habiyaremye.jpg',
                    'is_verified'      => true,
                ],
            ],

            // 4 — Property Valuer
            [
                'user' => [
                    'name'              => 'Marie-Claire Nyiraneza',
                    'email'             => 'm.nyiraneza@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Marie-Claire Nyiraneza',
                    'email'            => 'm.nyiraneza@pro.imari.rw',
                    'phone'            => '+250788114204',
                    'whatsapp'         => '+250788114204',
                    'profession'       => 'Property Valuer',
                    'license_number'   => 'IRPV/VAL/2015/0063',
                    'years_experience' => 10,
                    'rating'           => 4.6,
                    'bio'              => 'Marie-Claire is a certified property valuer and member of the Institute of Real Property Valuers in Rwanda (IRPV), with a decade of experience conducting property valuations for mortgage finance, insurance, taxation, compensation, and litigation purposes. She has worked with all major Rwandan commercial banks including BK, Equity, I&M, and Cogebanque, as well as international development finance institutions. Marie-Claire holds a Bachelor\'s degree in Land Economics from Makerere University, Uganda.',
                    'services'         => json_encode([
                        'Mortgage Valuation',
                        'Insurance Valuation',
                        'Compensation Valuation',
                        'Market Rent Assessment',
                        'Investment Appraisal',
                        'Expert Witness Reports',
                    ]),
                    'portfolio_url'    => null,
                    'credentials_doc'  => 'professionals/credentials/nyiraneza-valuer.pdf',
                    'linkedin'         => 'https://linkedin.com/in/marie-claire-nyiraneza',
                    'website'          => 'https://nyiraneza-valuation.rw',
                    'office_location'  => 'KN 3 Ave, Nyarugenge, Kigali CBD',
                    'languages'        => json_encode(['Kinyarwanda', 'English', 'French']),
                    'profile_image'    => 'professionals/marie-claire-nyiraneza.jpg',
                    'is_verified'      => true,
                ],
            ],

            // 5 — Interior Designer
            [
                'user' => [
                    'name'              => 'Leila Mukamana',
                    'email'             => 'l.mukamana@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Leila Mukamana',
                    'email'            => 'l.mukamana@pro.imari.rw',
                    'phone'            => '+250722115205',
                    'whatsapp'         => '+250722115205',
                    'profession'       => 'Interior Designer',
                    'license_number'   => 'RCIC/INT/2018/0201',
                    'years_experience' => 7,
                    'rating'           => 4.9,
                    'bio'              => 'Leila is Kigali\'s most followed interior designer, known for blending contemporary African aesthetics with international luxury standards. She has designed interiors for high-end residences in Nyarutarama and Kiyovu, boutique hotels in Rubavu and Musanze, and premium office spaces in the Kigali CBD. Leila trained at the Raffles Design Institute in Nairobi and is a certified member of the Interior Designers Association of East Africa (IDAEA). Her work has been featured in Rwanda\'s Architecture & Design Magazine.',
                    'services'         => json_encode([
                        'Residential Interior Design',
                        'Commercial & Office Interiors',
                        'Hospitality Design',
                        'Furniture & Finishing Specification',
                        '3D Interior Renders',
                        'Project Management',
                    ]),
                    'portfolio_url'    => 'https://leila-designs.rw',
                    'credentials_doc'  => 'professionals/credentials/mukamana-interior.pdf',
                    'linkedin'         => 'https://linkedin.com/in/leila-mukamana',
                    'website'          => 'https://leila-designs.rw',
                    'office_location'  => 'KG 200 St, Nyarutarama, Gasabo, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'English', 'French', 'Swahili']),
                    'profile_image'    => 'professionals/leila-mukamana.jpg',
                    'is_verified'      => true,
                ],
            ],

            // 6 — Building Contractor
            [
                'user' => [
                    'name'              => 'Alexis Bizimana',
                    'email'             => 'a.bizimana@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Alexis Bizimana',
                    'email'            => 'a.bizimana@pro.imari.rw',
                    'phone'            => '+250738116206',
                    'whatsapp'         => '+250738116206',
                    'profession'       => 'Building Contractor',
                    'license_number'   => 'RCIC/CONT/2012/0089',
                    'years_experience' => 13,
                    'rating'           => 4.5,
                    'bio'              => 'Alexis is a licensed Class A building contractor with 13 years of experience delivering residential, commercial, and institutional construction projects across Rwanda. His firm, Biz Construction Ltd, employs 45 permanent staff and has a track record of on-time, on-budget delivery. Notable completed projects include a 24-unit apartment block in Remera, the Gisozi Health Centre rehabilitation, and a commercial warehouse in Bugesera SEZ. Alexis is registered with RCIC in the highest building works category and complies with all Rwanda Occupational Safety and Health regulations.',
                    'services'         => json_encode([
                        'Residential Construction',
                        'Commercial Construction',
                        'Renovation & Fit-Out',
                        'Roofing & Waterproofing',
                        'External Works & Landscaping',
                        'Project Management',
                    ]),
                    'portfolio_url'    => 'https://bizconstruction.rw',
                    'credentials_doc'  => 'professionals/credentials/bizimana-contractor.pdf',
                    'linkedin'         => 'https://linkedin.com/in/alexis-bizimana',
                    'website'          => 'https://bizconstruction.rw',
                    'office_location'  => 'KG 15 Ave, Remera, Gasabo, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'French', 'English']),
                    'profile_image'    => 'professionals/alexis-bizimana.jpg',
                    'is_verified'      => true,
                ],
            ],

            // 7 — Real Estate Lawyer / Notary
            [
                'user' => [
                    'name'              => 'Julienne Ingabire',
                    'email'             => 'j.ingabire@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Julienne Ingabire',
                    'email'            => 'j.ingabire@pro.imari.rw',
                    'phone'            => '+250788117207',
                    'whatsapp'         => '+250788117207',
                    'profession'       => 'Real Estate Lawyer & Notary',
                    'license_number'   => 'RBA/LAW/2011/0034',
                    'years_experience' => 14,
                    'rating'           => 4.8,
                    'bio'              => 'Julienne is a senior advocate and accredited notary with 14 years of specialisation in real estate law, land transactions, and property dispute resolution in Rwanda. She advises buyers, sellers, developers, and financial institutions on due diligence, sale agreements, leasehold and freehold transfers, mortgage documentation, expropriation compensation, and co-ownership disputes. Julienne is a member of the Rwanda Bar Association (RBA) and has appeared before the High Court Commercial Division in numerous landmark land cases.',
                    'services'         => json_encode([
                        'Title Deed Transfer',
                        'Sale & Purchase Agreements',
                        'Due Diligence & Title Search',
                        'Mortgage Documentation',
                        'Lease Agreement Drafting',
                        'Property Dispute Resolution',
                        'Expropriation & Compensation',
                    ]),
                    'portfolio_url'    => null,
                    'credentials_doc'  => 'professionals/credentials/ingabire-lawyer.pdf',
                    'linkedin'         => 'https://linkedin.com/in/julienne-ingabire',
                    'website'          => 'https://ingabire-law.rw',
                    'office_location'  => 'KN 3 Ave, Nyarugenge, Kigali CBD',
                    'languages'        => json_encode(['Kinyarwanda', 'French', 'English']),
                    'profile_image'    => 'professionals/julienne-ingabire.jpg',
                    'is_verified'      => true,
                ],
            ],

            // 8 — MEP Engineer
            [
                'user' => [
                    'name'              => 'Cedric Nzeyimana',
                    'email'             => 'c.nzeyimana@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Cedric Nzeyimana',
                    'email'            => 'c.nzeyimana@pro.imari.rw',
                    'phone'            => '+250722118208',
                    'whatsapp'         => '+250722118208',
                    'profession'       => 'MEP Engineer',
                    'license_number'   => 'REB/MEP/2017/0155',
                    'years_experience' => 8,
                    'rating'           => 4.6,
                    'bio'              => 'Cedric is a licensed Mechanical, Electrical, and Plumbing (MEP) engineer with 8 years of experience delivering building services designs for residential, commercial, and hospitality projects in Rwanda. He is proficient in AutoCAD MEP, Revit MEP, and building energy simulation tools, enabling him to optimise HVAC, electrical, and plumbing systems for both performance and cost. Cedric holds a BSc in Electrical and Electronics Engineering from Kigali Independent University (ULK) and is a registered member of the Rwanda Engineers Board (REB).',
                    'services'         => json_encode([
                        'Electrical Design & Load Schedules',
                        'Plumbing & Drainage Design',
                        'HVAC & Ventilation Design',
                        'Solar PV System Design',
                        'Fire Detection & Suppression',
                        'MEP Site Supervision',
                    ]),
                    'portfolio_url'    => null,
                    'credentials_doc'  => 'professionals/credentials/nzeyimana-mep.pdf',
                    'linkedin'         => 'https://linkedin.com/in/cedric-nzeyimana',
                    'website'          => null,
                    'office_location'  => 'KG 7 Ave, Kacyiru, Gasabo, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'English', 'French']),
                    'profile_image'    => 'professionals/cedric-nzeyimana.jpg',
                    'is_verified'      => true,
                ],
            ],

            // 9 — Landscape Architect
            [
                'user' => [
                    'name'              => 'Sandrine Uwase',
                    'email'             => 's.uwase@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Sandrine Uwase',
                    'email'            => 's.uwase@pro.imari.rw',
                    'phone'            => '+250738119209',
                    'whatsapp'         => '+250738119209',
                    'profession'       => 'Landscape Architect',
                    'license_number'   => 'RCIC/LAND/2019/0278',
                    'years_experience' => 6,
                    'rating'           => 4.7,
                    'bio'              => 'Sandrine is a landscape architect and outdoor living specialist who designs gardens, courtyards, and public open spaces across Rwanda. She trained at the University of Cape Town and returned to Rwanda to build a practice that marries indigenous East African planting with contemporary outdoor design. Her projects include private villa gardens in Nyarutarama, the landscaped grounds of a Musanze eco-lodge, and public park design for Kigali City. Sandrine is certified in LEED Neighbourhood Development and advocates strongly for urban greening in Kigali\'s densifying sectors.',
                    'services'         => json_encode([
                        'Residential Garden Design',
                        'Outdoor Entertainment Areas',
                        'Swimming Pool Landscaping',
                        'Public Park & Plaza Design',
                        'Irrigation & Drainage Planning',
                        'Planting Plans (Indigenous Species)',
                    ]),
                    'portfolio_url'    => 'https://sandrine-landscape.rw',
                    'credentials_doc'  => 'professionals/credentials/uwase-landscape.pdf',
                    'linkedin'         => 'https://linkedin.com/in/sandrine-uwase',
                    'website'          => 'https://sandrine-landscape.rw',
                    'office_location'  => 'Kimironko Sector, Gasabo, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'English', 'French']),
                    'profile_image'    => 'professionals/sandrine-uwase.jpg',
                    'is_verified'      => true,
                ],
            ],

            // 10 — Urban Planner
            [
                'user' => [
                    'name'              => 'Théogène Rutayisire',
                    'email'             => 't.rutayisire@pro.imari.rw',
                    'password'          => Hash::make('Pro@1234'),
                    'email_verified_at' => now(),
                ],
                'professional' => [
                    'full_name'        => 'Théogène Rutayisire',
                    'email'            => 't.rutayisire@pro.imari.rw',
                    'phone'            => '+250788120210',
                    'whatsapp'         => '+250788120210',
                    'profession'       => 'Urban Planner',
                    'license_number'   => 'RCIC/PLAN/2010/0016',
                    'years_experience' => 15,
                    'rating'           => 4.9,
                    'bio'              => 'Théogène is one of Rwanda\'s most experienced urban planners, with 15 years of practice in land use planning, district master plans, and real estate development advisory. He has worked with Kigali City, Rwanda Housing Authority, and several district authorities on the preparation and revision of Detailed Physical Plans (DPPs). Théogène also advises private developers on zoning compliance, change-of-use applications, and environmental impact assessments. He holds an MSc in Urban and Regional Planning from ITC (Netherlands) and is a founding member of the Rwanda Urban Planners Association (RUPA).',
                    'services'         => json_encode([
                        'Detailed Physical Plan (DPP) Preparation',
                        'Zoning & Land Use Advice',
                        'Change of Use Applications',
                        'Environmental Impact Assessment',
                        'Estate Layout & Masterplanning',
                        'Building Permit Support',
                        'Urban Design Guidelines',
                    ]),
                    'portfolio_url'    => 'https://rutayisire-planning.rw',
                    'credentials_doc'  => 'professionals/credentials/rutayisire-planner.pdf',
                    'linkedin'         => 'https://linkedin.com/in/theogene-rutayisire',
                    'website'          => 'https://rutayisire-planning.rw',
                    'office_location'  => 'KN 3 Ave, Nyarugenge, Kigali CBD',
                    'languages'        => json_encode(['Kinyarwanda', 'French', 'English', 'Dutch']),
                    'profile_image'    => 'professionals/theogene-rutayisire.jpg',
                    'is_verified'      => true,
                ],
            ],
        ];

        foreach ($professionals as $entry) {
            $user = User::firstOrCreate(
                ['email' => $entry['user']['email']],
                $entry['user']
            );

            Professional::firstOrCreate(
                ['email' => $entry['professional']['email']],
                array_merge($entry['professional'], ['user_id' => $user->id])
            );
        }
    }
}