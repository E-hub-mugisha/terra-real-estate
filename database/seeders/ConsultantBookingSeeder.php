<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConsultantBookingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultant_bookings')->insert([
            [
                'id'                 => 1,
                'reference'          => 'TRB-' . strtoupper(Str::random(8)),
                'consultant_id'      => 1, // Patrick - Surveyor
                'service_id'         => 2, // Land Cadastral Survey
                'user_id'            => 4,
                'client_name'        => 'Diane Ishimwe',
                'client_email'       => 'diane@terra.rw',
                'client_phone'       => '+250788456789',
                'province'           => 'Kigali City',
                'district'           => 'Gasabo',
                'appointment_date'   => now()->addDays(4)->format('Y-m-d'),
                'notes'              => 'Cadastral survey for 600 sqm residential plot in Nyagatovu. Boundary markers need re-establishment.',
                'fee'                => 150000.00,
                'payment_method'     => 'momo',
                'payment_reference'  => 'MTN20260725001',
                'payment_status'     => 'paid',
                'status'             => 'confirmed',
                'confirmed_at'       => now()->subDays(1),
                'created_at'         => now()->subDays(3),
                'updated_at'         => now(),
            ],
            [
                'id'                 => 2,
                'reference'          => 'TRB-' . strtoupper(Str::random(8)),
                'consultant_id'      => 2, // Aimable - Attorney
                'service_id'         => 3, // Title Deed Processing
                'user_id'            => 5,
                'client_name'        => 'Immaculée Nyirahabimana',
                'client_email'       => 'immaculee.n@gmail.com',
                'client_phone'       => '+250788555666',
                'province'           => 'Eastern Province',
                'district'           => 'Bugesera',
                'appointment_date'   => now()->addDays(6)->format('Y-m-d'),
                'notes'              => 'Title deed transfer for property in Nyamata. Power of attorney will be provided by sister Consolée.',
                'fee'                => 85000.00,
                'payment_method'     => 'momo',
                'payment_reference'  => 'MTN20260726002',
                'payment_status'     => 'paid',
                'status'             => 'pending',
                'confirmed_at'       => null,
                'created_at'         => now()->subDays(1),
                'updated_at'         => now(),
            ],
            [
                'id'                 => 3,
                'reference'          => 'TRB-' . strtoupper(Str::random(8)),
                'consultant_id'      => 3, // Grace - Architect
                'service_id'         => 5, // Custom House Plan Design
                'user_id'            => 2,
                'client_name'        => 'Marie-Claire Uwimana',
                'client_email'       => 'marieclaire@terra.rw',
                'client_phone'       => '+250788234567',
                'province'           => 'Kigali City',
                'district'           => 'Gasabo',
                'appointment_date'   => now()->addDays(8)->format('Y-m-d'),
                'notes'              => 'Custom house plan for a 4-bedroom villa on a hillside plot in Kacyiru. 800 sqm, steep slope, panoramic view required.',
                'fee'                => 350000.00,
                'payment_method'     => 'momo',
                'payment_reference'  => null,
                'payment_status'     => 'unpaid',
                'status'             => 'pending',
                'confirmed_at'       => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'id'                 => 4,
                'reference'          => 'TRB-' . strtoupper(Str::random(8)),
                'consultant_id'      => 4, // Théogène - Engineer
                'service_id'         => 4, // Residential Construction
                'user_id'            => 4,
                'client_name'        => 'Chantal Mukamana',
                'client_email'       => 'chantal.m@gmail.com',
                'client_phone'       => '+250788222333',
                'province'           => 'Western Province',
                'district'           => 'Rubavu',
                'appointment_date'   => now()->addDays(3)->format('Y-m-d'),
                'notes'              => 'Structural inspection of building under construction in Rubavu. Foundation concerns raised by contractor.',
                'fee'                => 50000.00,
                'payment_method'     => 'momo',
                'payment_reference'  => 'MTN20260727004',
                'payment_status'     => 'paid',
                'status'             => 'confirmed',
                'confirmed_at'       => now()->subHours(6),
                'created_at'         => now()->subDays(1),
                'updated_at'         => now(),
            ],
            [
                'id'                 => 5,
                'reference'          => 'TRB-' . strtoupper(Str::random(8)),
                'consultant_id'      => 1, // Patrick - Surveyor
                'service_id'         => 2, // Land Cadastral Survey
                'user_id'            => 1,
                'client_name'        => 'Jean-Pierre Habimana',
                'client_email'       => 'jeanpierre@terra.rw',
                'client_phone'       => '+250788123456',
                'province'           => 'Kigali City',
                'district'           => 'Nyarugenge',
                'appointment_date'   => now()->subDays(10)->format('Y-m-d'),
                'notes'              => 'Completed cadastral survey for commercial plot on KN 3 Road. UPI documentation submitted to RLMUA.',
                'fee'                => 150000.00,
                'payment_method'     => 'momo',
                'payment_reference'  => 'MTN20260715005',
                'payment_status'     => 'paid',
                'status'             => 'completed',
                'confirmed_at'       => now()->subDays(12),
                'created_at'         => now()->subDays(15),
                'updated_at'         => now(),
            ],
        ]);
    }
}