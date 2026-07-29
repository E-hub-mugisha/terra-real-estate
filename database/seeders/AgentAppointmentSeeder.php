<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgentAppointmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('agent_appointments')->insert([
            [
                'id'         => 1,
                'agent_id'   => 1, // Marie-Claire
                'name'       => 'Jean de Dieu Habimana',
                'email'      => 'jdedieu@gmail.com',
                'date'       => now()->addDays(3)->format('Y-m-d'),
                'time'       => '10:00:00',
                'message'    => 'I am interested in the Kacyiru villa listing. I would like to schedule a viewing this week. I am available mornings.',
                'created_at' => now()->subDays(1),
                'updated_at' => now(),
            ],
            [
                'id'         => 2,
                'agent_id'   => 2, // Eric
                'name'       => 'Claudine Nirere',
                'email'      => 'claudine.n@gmail.com',
                'date'       => now()->addDays(5)->format('Y-m-d'),
                'time'       => '14:00:00',
                'message'    => 'I want to see the Nyagatovu plot. Can we meet at the site? I am a first-time buyer and need guidance on the process.',
                'created_at' => now()->subDays(2),
                'updated_at' => now(),
            ],
            [
                'id'         => 3,
                'agent_id'   => 4, // Robert
                'name'       => 'Dr. Emmanuel Kaberuka',
                'email'      => 'dr.kaberuka@gmail.com',
                'date'       => now()->addDays(7)->format('Y-m-d'),
                'time'       => '09:00:00',
                'message'    => 'I am looking for a luxury apartment in Kimihurura or Kiyovu for investment. Budget up to 150M RWF. Please prepare a shortlist before our meeting.',
                'created_at' => now()->subDays(1),
                'updated_at' => now(),
            ],
            [
                'id'         => 4,
                'agent_id'   => 5, // Anitha
                'name'       => 'François Mugenzi',
                'email'      => 'francois.m@outlook.com',
                'date'       => now()->addDays(4)->format('Y-m-d'),
                'time'       => '11:30:00',
                'message'    => 'I am a diaspora client based in Belgium. I will be visiting Rwanda next week and want to see the Rubavu lakefront plot. Can you arrange a site visit?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 5,
                'agent_id'   => 1, // Marie-Claire
                'name'       => 'Alice Uwimana',
                'email'      => 'alice.uw@gmail.com',
                'date'       => now()->addDays(2)->format('Y-m-d'),
                'time'       => '15:00:00',
                'message'    => 'I saw the Biryogo double storey listing. My husband and I would like to visit the property and discuss the payment plan. We are pre-approved for a mortgage at Bank of Kigali.',
                'created_at' => now()->subDays(1),
                'updated_at' => now(),
            ],
        ]);
    }
}