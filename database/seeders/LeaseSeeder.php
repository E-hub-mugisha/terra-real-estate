<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = Tenant::orderBy('id')->get();
        $units = Unit::orderBy('id')->get();
        $userId = User::whereIn('role', [
            'admin','property_owner'
        ], 'and', false)->value('id');

        if ($tenants->isEmpty() || $units->isEmpty()) {
            $this->command->warn('Seed tenants and units before leases.');
            return;
        }

        $leases = [
            [
                'number' => 'LSE-2026-0001',
                'tenant' => 0,
                'unit' => 0,
                'start' => now()->subMonths(5)->startOfMonth(),
                'end' => now()->addMonths(7)->endOfMonth(),
                'rent' => 250000,
                'deposit' => 250000,
                'due_day' => 5,
                'status' => 'active',
            ],
            [
                'number' => 'LSE-2026-0002',
                'tenant' => 1,
                'unit' => 1,
                'start' => now()->subMonths(2)->startOfMonth(),
                'end' => now()->addMonths(10)->endOfMonth(),
                'rent' => 300000,
                'deposit' => 300000,
                'due_day' => 1,
                'status' => 'active',
            ],
            [
                'number' => 'LSE-2026-0003',
                'tenant' => 2,
                'unit' => 2,
                'start' => now()->addMonth()->startOfMonth(),
                'end' => now()->addMonths(13)->endOfMonth(),
                'rent' => 200000,
                'deposit' => 200000,
                'due_day' => 5,
                'status' => 'draft',
            ],
            [
                'number' => 'LSE-2026-0004',
                'tenant' => 3,
                'unit' => 3,
                'start' => now()->subMonths(18)->startOfMonth(),
                'end' => now()->subMonths(6)->endOfMonth(),
                'rent' => 275000,
                'deposit' => 275000,
                'due_day' => 1,
                'status' => 'expired',
            ],
        ];

        DB::transaction(function () use ($leases, $tenants, $units, $userId) {
            foreach ($leases as $lease) {
                $tenant = $tenants->get($lease['tenant']);
                $unit = $units->get($lease['unit']);

                if (!$tenant || !$unit) {
                    continue;
                }

                DB::table('leases')->updateOrInsert(
                    ['lease_number' => $lease['number']],
                    [
                        'tenant_id' => $tenant->id,
                        'unit_id' => $unit->id,
                        'created_by' => $userId,
                        'start_date' => $lease['start']->toDateString(),
                        'end_date' => $lease['end']->toDateString(),
                        'monthly_rent' => $lease['rent'],
                        'security_deposit' => $lease['deposit'],
                        'rent_due_day' => $lease['due_day'],
                        'currency' => 'RWF',
                        'payment_frequency' => 'monthly',
                        'status' => $lease['status'],
                        'terminated_at' => null,
                        'termination_reason' => null,
                        'terms' => 'Rent is payable monthly in RWF. '
                            . 'The tenant must maintain the premises '
                            . 'and comply with the rental agreement.',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        });

        $this->command->info('Lease records seeded successfully.');
    }
}