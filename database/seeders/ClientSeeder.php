<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('clients')->insert([
            [
                'id'           => 1,
                'full_name'    => 'Jean-Bosco Niyonsaba',
                'phone'        => '+250788111222',
                'email'        => 'jbosco@gmail.com',
                'national_id'  => '1199780001234567',
                'province'     => 'Kigali City',
                'district'     => 'Gasabo',
                'sector'       => 'Kacyiru',
                'client_type'  => 'owner',
                'company_name' => null,
                'notes'        => 'Long-time property owner in Kacyiru with multiple residential plots.',
                'is_active'    => 1,
                'created_by'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => 2,
                'full_name'    => 'Chantal Mukamana',
                'phone'        => '+250788222333',
                'email'        => 'chantal.m@gmail.com',
                'national_id'  => '1199800002345678',
                'province'     => 'Western Province',
                'district'     => 'Rubavu',
                'sector'       => 'Gisenyi',
                'client_type'  => 'developer',
                'company_name' => 'Lakeview Properties Ltd',
                'notes'        => 'Developer specializing in lakefront properties near Lake Kivu.',
                'is_active'    => 1,
                'created_by'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => 3,
                'full_name'    => 'Dr. Samuel Habarugira',
                'phone'        => '+250788333444',
                'email'        => 'dr.habarugira@gmail.com',
                'national_id'  => '1199750003456789',
                'province'     => 'Southern Province',
                'district'     => 'Huye',
                'sector'       => 'Tumba',
                'client_type'  => 'owner',
                'company_name' => null,
                'notes'        => 'Owns agricultural land in Huye district looking to subdivide.',
                'is_active'    => 1,
                'created_by'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => 4,
                'full_name'    => 'Urwego Development Corporation',
                'phone'        => '+250788444555',
                'email'        => 'info@urwego.rw',
                'national_id'  => null,
                'province'     => 'Kigali City',
                'district'     => 'Nyarugenge',
                'sector'       => 'Nyarugenge',
                'client_type'  => 'company',
                'company_name' => 'Urwego Development Corporation',
                'notes'        => 'Major real estate developer with projects in Kigali and Bugesera.',
                'is_active'    => 1,
                'created_by'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'id'           => 5,
                'full_name'    => 'Immaculée Nyirahabimana',
                'phone'        => '+250788555666',
                'email'        => 'immaculee.n@gmail.com',
                'national_id'  => '1199850005678901',
                'province'     => 'Eastern Province',
                'district'     => 'Bugesera',
                'sector'       => 'Nyamata',
                'client_type'  => 'agent',
                'company_name' => null,
                'notes'        => 'Diaspora returnee from Canada looking to invest in Bugesera real estate.',
                'is_active'    => 1,
                'created_by'   => 1,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}