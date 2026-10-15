<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use App\Models\TenantApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TenantApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::query()
            ->where('status', 'active')
            ->orderBy('id')
            ->get();

        $units = Unit::query()
            ->where('status', 'available')
            ->orderBy('id')
            ->get();

        $reviewer = User::query()
            ->where(function ($query) {
                $query->where('role', 'admin')
                    ->orWhere('role', 'property_owner');
            })
            ->first();

        if ($tenants->isEmpty()) {
            $this->command->warn(
                'No active tenants found. Please seed tenants first.'
            );

            return;
        }

        if ($units->isEmpty()) {
            $this->command->warn(
                'No available units found. Please seed units first.'
            );

            return;
        }

        $applicationRecords = [
            [
                'application_number' => 'APP-2026-0001',
                'tenant_index' => 0,
                'unit_index' => 0,
                'application_date' => '2026-10-01',
                'desired_move_in_date' => '2026-11-01',
                'number_of_occupants' => 2,
                'offered_monthly_rent' => 250000,
                'currency' => 'RWF',
                'employment_status' => 'Employed',
                'additional_information' =>
                    'Looking for a comfortable residential unit close to work.',
                'status' => 'pending',
                'reviewed_at' => null,
                'decision_notes' => null,
            ],
            [
                'application_number' => 'APP-2026-0002',
                'tenant_index' => 1,
                'unit_index' => 1,
                'application_date' => '2026-10-02',
                'desired_move_in_date' => '2026-11-15',
                'number_of_occupants' => 1,
                'offered_monthly_rent' => 300000,
                'currency' => 'RWF',
                'employment_status' => 'Employed',
                'additional_information' =>
                    'Interested in a quiet apartment with reliable water and electricity.',
                'status' => 'under_review',
                'reviewed_at' => now()->subDay(),
                'decision_notes' => 'Application is being reviewed.',
            ],
            [
                'application_number' => 'APP-2026-0003',
                'tenant_index' => 2,
                'unit_index' => 2,
                'application_date' => '2026-10-03',
                'desired_move_in_date' => '2026-11-01',
                'number_of_occupants' => 4,
                'offered_monthly_rent' => 200000,
                'currency' => 'RWF',
                'employment_status' => 'Employed',
                'additional_information' =>
                    'Applying for a family residence.',
                'status' => 'approved',
                'reviewed_at' => now()->subDays(2),
                'decision_notes' => 'Approved subject to lease signing.',
            ],
            [
                'application_number' => 'APP-2026-0004',
                'tenant_index' => 3,
                'unit_index' => 3,
                'application_date' => '2026-10-04',
                'desired_move_in_date' => '2026-12-01',
                'number_of_occupants' => 2,
                'offered_monthly_rent' => 275000,
                'currency' => 'RWF',
                'employment_status' => 'Employed',
                'additional_information' =>
                    'Would prefer a long-term rental agreement.',
                'status' => 'rejected',
                'reviewed_at' => now()->subDay(),
                'decision_notes' =>
                    'The requested unit is not suitable for the applicant’s requirements.',
            ],
            [
                'application_number' => 'APP-2026-0005',
                'tenant_index' => 4,
                'unit_index' => 4,
                'application_date' => '2026-10-05',
                'desired_move_in_date' => '2026-11-10',
                'number_of_occupants' => 3,
                'offered_monthly_rent' => 180000,
                'currency' => 'RWF',
                'employment_status' => 'Employed',
                'additional_information' =>
                    'Seeking a family-friendly rental property.',
                'status' => 'withdrawn',
                'reviewed_at' => null,
                'decision_notes' => null,
            ],
        ];

        DB::transaction(function () use (
            $applicationRecords,
            $tenants,
            $units,
            $reviewer
        ) {
            foreach ($applicationRecords as $record) {
                // Select existing tenants and units safely, even if
                // fewer than five records are available.
                $tenant = $tenants->get(
                    $record['tenant_index'] % $tenants->count()
                );

                $unit = $units->get(
                    $record['unit_index'] % $units->count()
                );

                $status = $record['status'];

                TenantApplication::updateOrCreate(
                    [
                        'application_number' =>
                            $record['application_number'],
                    ],
                    [
                        'tenant_id' => $tenant->id,
                        'unit_id' => $unit->id,

                        'reviewed_by' => in_array(
                            $status,
                            ['under_review', 'approved', 'rejected']
                        ) ? $reviewer?->id : null,

                        'application_date' =>
                            $record['application_date'],

                        'desired_move_in_date' =>
                            $record['desired_move_in_date'],

                        'number_of_occupants' =>
                            $record['number_of_occupants'],

                        'offered_monthly_rent' =>
                            $record['offered_monthly_rent'],

                        'currency' => $record['currency'],

                        'employment_status' =>
                            $record['employment_status'],

                        'additional_information' =>
                            $record['additional_information'],

                        'status' => $status,

                        'reviewed_at' => in_array(
                            $status,
                            ['under_review', 'approved', 'rejected']
                        ) ? $record['reviewed_at'] : null,

                        'decision_notes' =>
                            $record['decision_notes'],
                    ]
                );
            }
        });

        $this->command->info(
            'Tenant applications seeded successfully.'
        );
    }
}