<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestSeeder extends Seeder
{
    public function run(): void
    {
        $units = DB::table('units')->orderBy('id')->get();
        $tenants = DB::table('tenants')->orderBy('id')->get();

        $requesterId = User::whereIn('role', [
            'admin', 'property_owner'
        ], 'and', false)->value('id');

        $assigneeId = User::whereIn('role', [
            'property_owner', 'admin'
        ], 'and', false)->value('id');

        if ($units->isEmpty()) {
            $this->command->warn(
                'Seed units before maintenance requests.'
            );
            return;
        }

        $requests = [
            [
                'number' => 'MNT-2026-0001',
                'title' => 'Leaking bathroom pipe',
                'description' => 'Water is leaking beneath the bathroom sink.',
                'category' => 'plumbing',
                'priority' => 'high',
                'status' => 'in_progress',
                'estimated_cost' => 50000,
                'actual_cost' => null,
                'resolution_notes' => null,
            ],
            [
                'number' => 'MNT-2026-0002',
                'title' => 'Faulty electrical socket',
                'description' => 'A wall socket is not supplying electricity.',
                'category' => 'electrical',
                'priority' => 'urgent',
                'status' => 'assigned',
                'estimated_cost' => 35000,
                'actual_cost' => null,
                'resolution_notes' => null,
            ],
            [
                'number' => 'MNT-2026-0003',
                'title' => 'Repair front door lock',
                'description' => 'The main door lock is difficult to operate.',
                'category' => 'doors_and_locks',
                'priority' => 'medium',
                'status' => 'completed',
                'estimated_cost' => 20000,
                'actual_cost' => 18000,
                'resolution_notes' => 'Lock repaired and tested successfully.',
            ],
            [
                'number' => 'MNT-2026-0004',
                'title' => 'Repair damaged ceiling',
                'description' => 'A section of the ceiling needs repair.',
                'category' => 'structural',
                'priority' => 'low',
                'status' => 'submitted',
                'estimated_cost' => 70000,
                'actual_cost' => null,
                'resolution_notes' => null,
            ],
            [
                'number' => 'MNT-2026-0005',
                'title' => 'Water drainage inspection',
                'description' => 'Inspect slow drainage in the kitchen.',
                'category' => 'plumbing',
                'priority' => 'medium',
                'status' => 'cancelled',
                'estimated_cost' => 15000,
                'actual_cost' => null,
                'resolution_notes' => 'Request cancelled for demonstration purposes.',
            ],
        ];

        DB::transaction(function () use (
            $requests,
            $units,
            $tenants,
            $requesterId,
            $assigneeId
        ) {
            foreach ($requests as $index => $request) {
                $unit = $units->get($index % $units->count());

                $tenant = $tenants->firstWhere(
                    'user_id',
                    $unit->tenant_id ?? null
                );

                // If units do not have tenant_id, select an existing tenant.
                if (!$tenant && $tenants->isNotEmpty()) {
                    $tenant = $tenants->get(
                        $index % $tenants->count()
                    );
                }

                $requestedDate = now()->subDays(($index + 1) * 3);

                $completedDate = $request['status'] === 'completed'
                    ? $requestedDate->copy()->addDays(2)->toDateString()
                    : null;

                DB::table('maintenance_requests')->updateOrInsert(
                    ['request_number' => $request['number']],
                    [
                        'managed_property_id' => $unit->managed_property_id,
                        'unit_id' => $unit->id,
                        'tenant_id' => $tenant?->id,
                        'requested_by' => $tenant?->user_id ?? $requesterId,
                        'assigned_to' => in_array(
                            $request['status'],
                            ['assigned', 'in_progress', 'completed']
                        ) ? $assigneeId : null,
                        'title' => $request['title'],
                        'description' => $request['description'],
                        'category' => $request['category'],
                        'priority' => $request['priority'],
                        'status' => $request['status'],
                        'requested_date' => $requestedDate->toDateString(),
                        'scheduled_date' => in_array(
                            $request['status'],
                            ['assigned', 'in_progress', 'completed']
                        ) ? $requestedDate->copy()->addDay()->toDateString() : null,
                        'completed_date' => $completedDate,
                        'estimated_cost' => $request['estimated_cost'],
                        'actual_cost' => $request['actual_cost'],
                        'currency' => 'RWF',
                        'resolution_notes' => $request['resolution_notes'],
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        });

        $this->command->info(
            'Maintenance requests seeded successfully.'
        );
    }
}