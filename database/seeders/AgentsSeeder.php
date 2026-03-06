<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AgentsSeeder extends Seeder
{
    public function run(): void
    {
        $agents = [
            // 1
            [
                'user' => [
                    'name'              => 'Claudine Uwimana',
                    'email'             => 'claudine.uwimana@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Claudine Uwimana',
                    'email'            => 'claudine.uwimana@imari.rw',
                    'phone'            => '+250788101001',
                    'whatsapp'         => '+250788101001',
                    'years_experience' => 9,
                    'bio'              => 'Claudine is one of Kigali\'s most recognised real estate agents with over 9 years of experience specialising in high-end residential sales and leasing in Kiyovu, Nyarutarama, and Kimihurura. She has facilitated over 200 successful transactions and holds a diploma in Property Management from the Kigali Independent University (ULK). Known for her meticulous attention to detail and deep knowledge of the Kigali City master plan regulations.',
                    'linkedin'         => 'https://linkedin.com/in/claudine-uwimana',
                    'facebook'         => 'https://facebook.com/claudine.uwimana.agent',
                    'instagram'        => 'https://instagram.com/claudine_immo',
                    'twitter'          => 'https://twitter.com/claudine_immo',
                    'profile_image'    => 'agents/claudine-uwimana.jpg',
                    'office_location'  => 'KG 9 Ave, Kimihurura, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'French', 'English']),
                    'is_verified'      => true,
                ],
            ],

            // 2
            [
                'user' => [
                    'name'              => 'Jean-Pierre Habimana',
                    'email'             => 'jp.habimana@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Jean-Pierre Habimana',
                    'email'            => 'jp.habimana@imari.rw',
                    'phone'            => '+250722202002',
                    'whatsapp'         => '+250722202002',
                    'years_experience' => 12,
                    'bio'              => 'Jean-Pierre is a seasoned commercial real estate specialist with 12 years of experience in office leasing, retail space, and industrial property across Kigali\'s Central Business District and the Bugesera Special Economic Zone. He has brokered landmark deals for multinational companies entering the Rwandan market and provides comprehensive tenant representation and landlord advisory services. Jean-Pierre holds a Bachelor\'s degree in Business Administration from the University of Rwanda.',
                    'linkedin'         => 'https://linkedin.com/in/jp-habimana',
                    'facebook'         => 'https://facebook.com/jphabimana.realestate',
                    'instagram'        => 'https://instagram.com/jp_realestate_rw',
                    'twitter'          => null,
                    'profile_image'    => 'agents/jp-habimana.jpg',
                    'office_location'  => 'KN 3 Ave, Nyarugenge, Kigali CBD',
                    'languages'        => json_encode(['Kinyarwanda', 'English', 'Swahili']),
                    'is_verified'      => true,
                ],
            ],

            // 3
            [
                'user' => [
                    'name'              => 'Aline Murekatete',
                    'email'             => 'aline.murekatete@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Aline Murekatete',
                    'email'            => 'aline.murekatete@imari.rw',
                    'phone'            => '+250738303003',
                    'whatsapp'         => '+250738303003',
                    'years_experience' => 6,
                    'bio'              => 'Aline is a dynamic property consultant based in Gasabo District, specialising in residential rentals and property management for landlords with portfolio properties in Remera, Kibagabaga, and Kacyiru. She manages over 80 rental units on behalf of clients and provides monthly landlord reporting, tenant screening, and maintenance coordination. Aline is certified in Property Management by the Rwanda Institute of Real Estate Professionals (RIREP) and is fluent in four languages.',
                    'linkedin'         => 'https://linkedin.com/in/aline-murekatete',
                    'facebook'         => 'https://facebook.com/aline.murekatete.agent',
                    'instagram'        => 'https://instagram.com/aline_property_kigali',
                    'twitter'          => 'https://twitter.com/aline_property',
                    'profile_image'    => 'agents/aline-murekatete.jpg',
                    'office_location'  => 'KG 15 Ave, Remera, Gasabo, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'French', 'English', 'Swahili']),
                    'is_verified'      => true,
                ],
            ],

            // 4
            [
                'user' => [
                    'name'              => 'Patrick Nshimiyimana',
                    'email'             => 'patrick.nshimiyimana@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Patrick Nshimiyimana',
                    'email'            => 'patrick.nshimiyimana@imari.rw',
                    'phone'            => '+250788404004',
                    'whatsapp'         => '+250788404004',
                    'years_experience' => 4,
                    'bio'              => 'Patrick is an up-and-coming land and property agent operating primarily in Kicukiro and the emerging peri-urban areas of Gahanga and Kanombe. He specialises in land acquisition, plot subdivision guidance, and helping first-time buyers navigate the Rwanda Land Management and Use Authority (RLMUA) title transfer process. Patrick has a strong network of notaries, surveyors, and district land officers, enabling smooth and transparent transactions for his clients.',
                    'linkedin'         => 'https://linkedin.com/in/patrick-nshimiyimana',
                    'facebook'         => 'https://facebook.com/patrick.nshimi.land',
                    'instagram'        => 'https://instagram.com/patrick_land_rw',
                    'twitter'          => null,
                    'profile_image'    => 'agents/patrick-nshimiyimana.jpg',
                    'office_location'  => 'Gahanga Sector, Kicukiro, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'English']),
                    'is_verified'      => true,
                ],
            ],

            // 5
            [
                'user' => [
                    'name'              => 'Solange Ineza',
                    'email'             => 'solange.ineza@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Solange Ineza',
                    'email'            => 'solange.ineza@imari.rw',
                    'phone'            => '+250722505005',
                    'whatsapp'         => '+250722505005',
                    'years_experience' => 7,
                    'bio'              => 'Solange is a luxury property and hospitality real estate specialist covering Rubavu (Lake Kivu), Musanze (Volcanoes), and the broader Western Province tourism corridor. She advises investors on boutique hotel acquisitions, lakefront plot developments, and eco-lodge projects, and has direct relationships with RDB\'s tourism investment desk. Solange previously worked as a hospitality manager before transitioning to real estate, giving her a unique perspective on tourism property investment returns.',
                    'linkedin'         => 'https://linkedin.com/in/solange-ineza',
                    'facebook'         => 'https://facebook.com/solange.ineza.property',
                    'instagram'        => 'https://instagram.com/solange_luxury_rw',
                    'twitter'          => 'https://twitter.com/solange_luxury',
                    'profile_image'    => 'agents/solange-ineza.jpg',
                    'office_location'  => 'Lake Kivu Shore Rd, Rubavu District',
                    'languages'        => json_encode(['Kinyarwanda', 'French', 'English']),
                    'is_verified'      => true,
                ],
            ],

            // 6
            [
                'user' => [
                    'name'              => 'Emmanuel Mugabo',
                    'email'             => 'e.mugabo@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Emmanuel Mugabo',
                    'email'            => 'e.mugabo@imari.rw',
                    'phone'            => '+250738606006',
                    'whatsapp'         => '+250738606006',
                    'years_experience' => 10,
                    'bio'              => 'Emmanuel is a senior property investment advisor with 10 years of experience helping diaspora Rwandans and foreign investors acquire residential and commercial properties in Kigali. He is well-versed in the legal framework governing foreign ownership of property in Rwanda, the Condominium Law, and leasehold title structures. Emmanuel regularly attends the Rwanda Diaspora Global Convention and has built an extensive network of clients across the UK, Belgium, USA, and Canada.',
                    'linkedin'         => 'https://linkedin.com/in/emmanuel-mugabo',
                    'facebook'         => 'https://facebook.com/emmanuel.mugabo.invest',
                    'instagram'        => 'https://instagram.com/emmugabo_invest',
                    'twitter'          => 'https://twitter.com/emmugabo_invest',
                    'profile_image'    => 'agents/emmanuel-mugabo.jpg',
                    'office_location'  => 'KG 200 St, Nyarutarama, Gasabo, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'English', 'French', 'Dutch']),
                    'is_verified'      => true,
                ],
            ],

            // 7
            [
                'user' => [
                    'name'              => 'Diane Ishimwe',
                    'email'             => 'diane.ishimwe@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Diane Ishimwe',
                    'email'            => 'diane.ishimwe@imari.rw',
                    'phone'            => '+250788707007',
                    'whatsapp'         => '+250788707007',
                    'years_experience' => 5,
                    'bio'              => 'Diane is a property sales and valuation consultant based in Huye (Southern Province), serving clients across Huye, Nyanza, Muhanga, and Ruhango districts. She specialises in residential sales, agricultural land transactions, and commercial property for the university town market. Diane works closely with the University of Rwanda and local NGOs on staff accommodation sourcing and student housing developments. She holds a Bachelor\'s degree in Economics from the University of Rwanda Huye Campus.',
                    'linkedin'         => 'https://linkedin.com/in/diane-ishimwe',
                    'facebook'         => 'https://facebook.com/diane.ishimwe.agent',
                    'instagram'        => 'https://instagram.com/diane_huye_property',
                    'twitter'          => null,
                    'profile_image'    => 'agents/diane-ishimwe.jpg',
                    'office_location'  => 'Ngoma Sector, Huye District, Southern Province',
                    'languages'        => json_encode(['Kinyarwanda', 'English', 'French']),
                    'is_verified'      => true,
                ],
            ],

            // 8
            [
                'user' => [
                    'name'              => 'Thierry Nsengiyumva',
                    'email'             => 'thierry.nsengiyumva@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Thierry Nsengiyumva',
                    'email'            => 'thierry.nsengiyumva@imari.rw',
                    'phone'            => '+250722808008',
                    'whatsapp'         => '+250722808008',
                    'years_experience' => 8,
                    'bio'              => 'Thierry is an industrial and logistics real estate expert with 8 years of experience serving manufacturers, importers, and logistics companies seeking warehouse and industrial space in Kigali, Bugesera SEZ, and Nyandungu. He has strong relationships with the Rwanda Development Board (RDB) investment facilitation team and can support clients from property search through to investment certificate processing. Thierry is also a licensed building contractor and brings a technical edge to property assessment.',
                    'linkedin'         => 'https://linkedin.com/in/thierry-nsengiyumva',
                    'facebook'         => 'https://facebook.com/thierry.industrial.rw',
                    'instagram'        => null,
                    'twitter'          => 'https://twitter.com/thierry_rw_biz',
                    'profile_image'    => 'agents/thierry-nsengiyumva.jpg',
                    'office_location'  => 'Rilima Sector, Bugesera District, Eastern Province',
                    'languages'        => json_encode(['Kinyarwanda', 'French', 'English', 'Swahili']),
                    'is_verified'      => true,
                ],
            ],

            // 9
            [
                'user' => [
                    'name'              => 'Grace Akimana',
                    'email'             => 'grace.akimana@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Grace Akimana',
                    'email'            => 'grace.akimana@imari.rw',
                    'phone'            => '+250738909009',
                    'whatsapp'         => '+250738909009',
                    'years_experience' => 3,
                    'bio'              => 'Grace is a junior property consultant with 3 years of experience focusing on affordable housing and mid-market rentals in Nyamirambo, Gikondo, and Kicukiro. She is passionate about helping young Kigali professionals find quality accommodation within their budget and works transparently on a fixed-fee model rather than percentage commission. Grace is completing a Diploma in Real Estate at the Rwanda Polytechnic and is building a strong reputation for honest, client-first service.',
                    'linkedin'         => 'https://linkedin.com/in/grace-akimana',
                    'facebook'         => 'https://facebook.com/grace.akimana.property',
                    'instagram'        => 'https://instagram.com/grace_property_kigali',
                    'twitter'          => null,
                    'profile_image'    => 'agents/grace-akimana.jpg',
                    'office_location'  => 'KN 22 St, Nyamirambo, Nyarugenge, Kigali',
                    'languages'        => json_encode(['Kinyarwanda', 'English']),
                    'is_verified'      => false,
                ],
            ],

            // 10
            [
                'user' => [
                    'name'              => 'Bosco Niyonzima',
                    'email'             => 'bosco.niyonzima@imari.rw',
                    'password'          => Hash::make('Agent@1234'),
                    'email_verified_at' => now(),
                ],
                'agent' => [
                    'full_name'        => 'Bosco Niyonzima',
                    'email'            => 'bosco.niyonzima@imari.rw',
                    'phone'            => '+250788010010',
                    'whatsapp'         => '+250788010010',
                    'years_experience' => 15,
                    'bio'              => 'Bosco is one of Rwanda\'s most experienced real estate professionals with 15 years in the industry, having started his career in land surveying before moving into brokerage and investment advisory. He has deep expertise in agricultural land, rural property development, and peri-urban plots across the Eastern Province including Bugesera, Rwamagana, and Kayonza. Bosco sits on the advisory board of the Rwanda Real Estate Association (RREA) and frequently contributes to policy discussions on land use and affordable housing.',
                    'linkedin'         => 'https://linkedin.com/in/bosco-niyonzima',
                    'facebook'         => 'https://facebook.com/bosco.niyonzima.rrea',
                    'instagram'        => 'https://instagram.com/bosco_rrea',
                    'twitter'          => 'https://twitter.com/bosco_rrea',
                    'profile_image'    => 'agents/bosco-niyonzima.jpg',
                    'office_location'  => 'Rilima Sector, Bugesera District, Eastern Province',
                    'languages'        => json_encode(['Kinyarwanda', 'English', 'French', 'Swahili']),
                    'is_verified'      => true,
                ],
            ],
        ];

        foreach ($agents as $entry) {
            // Create or find the user
            $user = User::firstOrCreate(
                ['email' => $entry['user']['email']],
                $entry['user']
            );

            // Create or find the agent linked to that user
            Agent::firstOrCreate(
                ['email' => $entry['agent']['email']],
                array_merge($entry['agent'], ['user_id' => $user->id])
            );
        }
    }
}