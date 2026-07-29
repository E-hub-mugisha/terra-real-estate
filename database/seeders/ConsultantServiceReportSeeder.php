<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsultantServiceReportSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('consultant_service_reports')->insert([
            [
                'id'                     => 1,
                'consultant_id'          => 1, // Patrick - Surveyor
                'service_request_id'     => null,
                'service_id'             => 2, // Land Cadastral Survey
                'client_name'            => 'Jean-Bosco Niyonsaba',
                'client_phone'           => '+250788111222',
                'service_date'           => now()->subDays(10)->format('Y-m-d'),
                'service_time'           => '08:00:00',
                'location'               => 'Nyagatovu, Kimironko, Gasabo, Kigali',
                'amount'                 => 150000.00,
                'commission_type'        => 'percentage',
                'commission_value'       => 20.00,
                'terra_commission_amount'=> 30000.00,
                'consultant_amount'      => 120000.00,
                'status'                 => 'approved',
                'notes'                  => 'Cadastral survey completed successfully. UPI documentation submitted to RLMUA.',
                'admin_notes'            => 'Verified. Survey report attached.',
                'reviewed_by'            => 1,
                'reviewed_at'            => now()->subDays(8),
                'created_at'             => now()->subDays(12),
                'updated_at'             => now(),
            ],
            [
                'id'                     => 2,
                'consultant_id'          => 2, // Aimable - Attorney
                'service_request_id'     => null,
                'service_id'             => 3, // Title Deed Processing
                'client_name'            => 'Diane Ishimwe',
                'client_phone'           => '+250788456789',
                'service_date'           => now()->subDays(5)->format('Y-m-d'),
                'service_time'           => '10:00:00',
                'location'               => 'RLMUA Office, Kigali',
                'amount'                 => 85000.00,
                'commission_type'        => 'percentage',
                'commission_value'       => 25.00,
                'terra_commission_amount'=> 21250.00,
                'consultant_amount'      => 63750.00,
                'status'                 => 'pending',
                'notes'                  => 'Title deed transfer initiated. Awaiting RLMUA processing.',
                'admin_notes'            => null,
                'reviewed_by'            => null,
                'reviewed_at'            => null,
                'created_at'             => now()->subDays(5),
                'updated_at'             => now(),
            ],
            [
                'id'                     => 3,
                'consultant_id'          => 3, // Grace - Architect
                'service_request_id'     => null,
                'service_id'             => 5, // Custom House Plan
                'client_name'            => 'Robert Bizimana',
                'client_phone'           => '+250788789012',
                'service_date'           => now()->subDays(15)->format('Y-m-d'),
                'service_time'           => '14:00:00',
                'location'               => 'Kacyiru, Gasabo, Kigali',
                'amount'                 => 350000.00,
                'commission_type'        => 'percentage',
                'commission_value'       => 20.00,
                'terra_commission_amount'=> 70000.00,
                'consultant_amount'      => 280000.00,
                'status'                 => 'approved',
                'notes'                  => 'Custom 4-bedroom villa design completed. Floor plans and 3D renders delivered.',
                'admin_notes'            => 'Design quality verified. Approved for payout.',
                'reviewed_by'            => 1,
                'reviewed_at'            => now()->subDays(10),
                'created_at'             => now()->subDays(18),
                'updated_at'             => now(),
            ],
            [
                'id'                     => 4,
                'consultant_id'          => 4, // Théogène - Engineer
                'service_request_id'     => null,
                'service_id'             => 4, // Construction
                'client_name'            => 'Chantal Mukamana',
                'client_phone'           => '+250788222333',
                'service_date'           => now()->subDays(3)->format('Y-m-d'),
                'service_time'           => '09:00:00',
                'location'               => 'Rubavu, Western Province',
                'amount'                 => 50000.00,
                'commission_type'        => 'percentage',
                'commission_value'       => 25.00,
                'terra_commission_amount'=> 12500.00,
                'consultant_amount'      => 37500.00,
                'status'                 => 'draft',
                'notes'                  => 'Structural inspection in progress. Foundation concerns identified.',
                'admin_notes'            => null,
                'reviewed_by'            => null,
                'reviewed_at'            => null,
                'created_at'             => now()->subDays(3),
                'updated_at'             => now(),
            ],
            [
                'id'                     => 5,
                'consultant_id'          => 1, // Patrick - Surveyor
                'service_request_id'     => null,
                'service_id'             => 2, // Land Cadastral Survey
                'client_name'            => 'Jean-Pierre Habimana',
                'client_phone'           => '+250788123456',
                'service_date'           => now()->subDays(20)->format('Y-m-d'),
                'service_time'           => '07:30:00',
                'location'               => 'KN 3 Road, Nyarugenge, Kigali',
                'amount'                 => 200000.00,
                'commission_type'        => 'percentage',
                'commission_value'       => 15.00,
                'terra_commission_amount'=> 30000.00,
                'consultant_amount'      => 170000.00,
                'status'                 => 'approved',
                'notes'                  => 'Commercial plot survey completed. UPI verified and boundary markers placed.',
                'admin_notes'            => 'Commercial survey — higher rate applied. Approved.',
                'reviewed_by'            => 1,
                'reviewed_at'            => now()->subDays(17),
                'created_at'             => now()->subDays(22),
                'updated_at'             => now(),
            ],
        ]);
    }
}