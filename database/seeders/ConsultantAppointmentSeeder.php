<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultantAppointmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultant_appointments')->insert([
            [
                'id'             => 1,
                'consultant_id'  => 1, // Patrick - Surveyor
                'name'           => 'Jean-Bosco Niyonsaba',
                'email'          => 'jbosco@gmail.com',
                'date'           => now()->addDays(4)->format('Y-m-d'),
                'time'           => '08:00:00',
                'message'        => 'I need a cadastral survey for my 600 sqm plot in Nyagatovu. The boundary markers are unclear and I want to resolve this before selling. Please bring GPS equipment.',
                'created_at'     => now()->subDays(1),
                'updated_at'     => now(),
            ],
            [
                'id'             => 2,
                'consultant_id'  => 2, // Aimable - Attorney
                'name'           => 'Immaculée Nyirahabimana',
                'email'          => 'immaculee.n@gmail.com',
                'date'           => now()->addDays(6)->format('Y-m-d'),
                'time'           => '10:30:00',
                'message'        => 'I need legal assistance with transferring a title deed for a property in Bugesera. I am currently in Canada and my sister will attend on my behalf with a power of attorney.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 3,
                'consultant_id'  => 3, // Grace - Architect
                'name'           => 'Robert Bizimana',
                'email'          => 'robert.b@terra.rw',
                'date'           => now()->addDays(8)->format('Y-m-d'),
                'time'           => '14:00:00',
                'message'        => 'I need a custom house plan for a 4-bedroom villa on a hillside plot in Kacyiru. The plot is 800 sqm with a steep slope. I want a modern design with a panoramic view terrace.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'id'             => 4,
                'consultant_id'  => 4, // Théogène - Engineer
                'name'           => 'Chantal Mukamana',
                'email'          => 'chantal.m@gmail.com',
                'date'           => now()->addDays(3)->format('Y-m-d'),
                'time'           => '09:00:00',
                'message'        => 'I need a structural inspection of a building under construction in Rubavu. The contractor has raised concerns about the foundation. I want an independent assessment before proceeding.',
                'created_at'     => now()->subDays(1),
                'updated_at'     => now(),
            ],
            [
                'id'             => 5,
                'consultant_id'  => 5, // Valérie - Valuer
                'name'           => 'Jean-Pierre Habimana',
                'email'          => 'jeanpierre@terra.rw',
                'date'           => now()->addDays(10)->format('Y-m-d'),
                'time'           => '11:00:00',
                'message'        => 'I need a property valuation for mortgage purposes. The property is a commercial plot on KN 3 Road. Bank of Kigali requires a certified valuation report before approving the loan.',
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}