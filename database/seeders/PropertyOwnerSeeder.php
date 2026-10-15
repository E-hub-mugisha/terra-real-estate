<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PropertyOwnerSeeder extends Seeder
{
    public function run(): void
    {
        $owners = [
            [
                'name'    => 'Jean Bosco Habimana',
                'email'   => 'jb.habimana@example.com',
                'owner'   => [
                    'owner_type'          => 'individual',
                    'phone'               => '+250788345120',
                    'national_id'         => '1197880034512134',
                    'company_name'        => null,
                    'tin'                 => null,
                    'address'             => 'KG 11 Ave, Kiyovu, Nyarugenge, Kigali',
                    'verification_status' => 'verified',
                    'notes'               => 'Owns two rental houses in Kiyovu. Prefers contact by phone in the morning.',
                ],
            ],
            [
                'name'    => 'Marie Claire Uwimana',
                'email'   => 'mc.uwimana@example.com',
                'owner'   => [
                    'owner_type'          => 'individual',
                    'phone'               => '+250722563401',
                    'national_id'         => '1198570125634012',
                    'company_name'        => null,
                    'tin'                 => '102345678',
                    'address'             => 'KG 9 Ave, Nyarutarama, Gasabo, Kigali',
                    'verification_status' => 'verified',
                    'notes'               => 'Apartment building with 8 units in Nyarutarama.',
                ],
            ],
            [
                'name'    => 'Emmanuel Ndayisaba',
                'email'   => 'e.ndayisaba@example.com',
                'owner'   => [
                    'owner_type'          => 'individual',
                    'phone'               => '+250789678210',
                    'national_id'         => '1197180067821145',
                    'company_name'        => null,
                    'tin'                 => null,
                    'address'             => 'KK 15 Rd, Kicukiro Centre, Kicukiro, Kigali',
                    'verification_status' => 'pending',
                    'notes'               => 'Documents submitted, awaiting verification.',
                ],
            ],
            [
                'name'    => 'Solange Mukamana',
                'email'   => 'solange@kivuheights.example.com',
                'owner'   => [
                    'owner_type'          => 'company',
                    'phone'               => '+250733349802',
                    'national_id'         => '1198870213498023',
                    'company_name'        => 'Kivu Heights Investments Ltd',
                    'tin'                 => '104521897',
                    'address'             => 'KG 7 Ave, Kacyiru, Gasabo, Kigali',
                    'verification_status' => 'verified',
                    'notes'               => 'Company representative. Portfolio of residential apartments across Kacyiru and Kimihurura.',
                ],
            ],
            [
                'name'    => 'Patrick Mugabo',
                'email'   => 'patrick@umugandaholdings.example.com',
                'owner'   => [
                    'owner_type'          => 'company',
                    'phone'               => '+250788017834',
                    'national_id'         => '1198280178340156',
                    'company_name'        => 'Umuganda Real Estate Holdings Ltd',
                    'tin'                 => '106389245',
                    'address'             => 'KN 3 Rd, Nyabugogo, Nyarugenge, Kigali',
                    'verification_status' => 'under_review',
                    'notes'               => 'Developer with a mixed-use building under construction in Gikondo.',
                ],
            ],
        ];

        DB::transaction(function () use ($owners) {
            foreach ($owners as $data) {
                $user = User::updateOrCreate(
                    ['email' => $data['email']],
                    [
                        'name'              => $data['name'],
                        'password'          => Hash::make('password'),
                        'email_verified_at' => now(),
                    ]
                );

                DB::table('property_owners')->updateOrInsert(
                    ['user_id' => $user->id],
                    array_merge($data['owner'], [
                        'updated_at' => now(),
                        'created_at' => now(),
                    ])
                );
            }
        });
    }
}