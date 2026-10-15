<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceRequestActivitySeeder extends Seeder
{
    public function run(): void
    {
        $requests = DB::table('maintenance_requests')
            ->whereIn('request_number', [
                'MNT-2026-0001',
                'MNT-2026-0002',
                'MNT-2026-0003',
                'MNT-2026-0004',
                'MNT-2026-0005',
            ])
            ->get();

        if ($requests->isEmpty()) {
            $this->command->warn(
                'Seed maintenance requests before their activities.'
            );
            return;
        }

        $userId = User::whereIn('role', [
            'admin', 'property_owner'
        ], 'and', false)->value('id');

        $history = [
            'MNT-2026-0001' => [
                ['from' => null, 'to' => 'submitted',
                    'notes' => 'Maintenance request submitted.'],
                ['from' => 'submitted', 'to' => 'assigned',
                    'notes' => 'Assigned to the maintenance team.'],
                ['from' => 'assigned', 'to' => 'in_progress',
                    'notes' => 'Plumbing repair has started.'],
            ],
            'MNT-2026-0002' => [
                ['from' => null, 'to' => 'submitted',
                    'notes' => 'Electrical issue reported.'],
                ['from' => 'submitted', 'to' => 'assigned',
                    'notes' => 'Assigned for urgent inspection.'],
            ],
            'MNT-2026-0003' => [
                ['from' => null, 'to' => 'submitted',
                    'notes' => 'Door lock repair requested.'],
                ['from' => 'submitted', 'to' => 'assigned',
                    'notes' => 'Lock repair assigned to technician.'],
                ['from' => 'assigned', 'to' => 'in_progress',
                    'notes' => 'Technician started the repair.'],
                ['from' => 'in_progress', 'to' => 'completed',
                    'notes' => 'Repair completed successfully.'],
            ],
            'MNT-2026-0004' => [
                ['from' => null, 'to' => 'submitted',
                    'notes' => 'Ceiling damage reported for assessment.'],
            ],
            'MNT-2026-0005' => [
                ['from' => null, 'to' => 'submitted',
                    'notes' => 'Drainage inspection requested.'],
                ['from' => 'submitted', 'to' => 'cancelled',
                    'notes' => 'Request cancelled.'],
            ],
        ];

        DB::transaction(function () use ($requests, $history, $userId) {
            foreach ($requests as $request) {
                $activities = $history[$request->request_number] ?? [];

                foreach ($activities as $index => $activity) {
                    $exists = DB::table('maintenance_request_activities')
                        ->where('maintenance_request_id', $request->id)
                        ->where('to_status', $activity['to'])
                        ->where('notes', $activity['notes'])
                        ->exists();

                    if ($exists) {
                        continue;
                    }

                    DB::table('maintenance_request_activities')->insert([
                        'maintenance_request_id' => $request->id,
                        'user_id' => $userId,
                        'from_status' => $activity['from'],
                        'to_status' => $activity['to'],
                        'notes' => $activity['notes'],
                        'created_at' => now()->subMinutes(
                            (count($activities) - $index) * 15
                        ),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        $this->command->info(
            'Maintenance request activities seeded successfully.'
        );
    }
}