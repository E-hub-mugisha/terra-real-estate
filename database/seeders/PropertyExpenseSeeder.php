<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $properties = DB::table('managed_properties')
            ->orderBy('id')
            ->get();

        if ($properties->isEmpty()) {
            $this->command->warn(
                'Seed managed properties before property expenses.'
            );
            return;
        }

        $recordedBy = DB::table('users')
            ->whereIn('role', ['admin', 'property_owner'])
            ->value('id');

        $expenses = [
            [
                'reference' => 'EXP-2026-0001',
                'category' => 'repairs',
                'description' => 'Plumbing repair and replacement parts',
                'amount' => 45000,
                'vendor' => 'Kigali Plumbing Services',
                'status' => 'approved',
            ],
            [
                'reference' => 'EXP-2026-0002',
                'category' => 'utilities',
                'description' => 'Common-area electricity bill',
                'amount' => 65000,
                'vendor' => 'Utility Service Provider',
                'status' => 'recorded',
            ],
            [
                'reference' => 'EXP-2026-0003',
                'category' => 'cleaning',
                'description' => 'Monthly common-area cleaning',
                'amount' => 30000,
                'vendor' => 'Clean Homes Rwanda',
                'status' => 'pending',
            ],
            [
                'reference' => 'EXP-2026-0004',
                'category' => 'security',
                'description' => 'Security equipment maintenance',
                'amount' => 80000,
                'vendor' => 'Secure Property Services',
                'status' => 'approved',
            ],
            [
                'reference' => 'EXP-2026-0005',
                'category' => 'other',
                'description' => 'General property maintenance supplies',
                'amount' => 25000,
                'vendor' => 'Local Hardware Supplier',
                'status' => 'recorded',
            ],
        ];

        $units = DB::table('units')->orderBy('id')->get();

        DB::transaction(function () use (
            $expenses,
            $properties,
            $units,
            $recordedBy
        ) {
            foreach ($expenses as $index => $expense) {
                $property = $properties->get($index % $properties->count());

                $unit = $units->firstWhere(
                    'managed_property_id',
                    $property->id
                );

                DB::table('property_expenses')->updateOrInsert(
                    ['expense_reference' => $expense['reference']],
                    [
                        'managed_property_id' => $property->id,
                        'unit_id' => $unit?->id,
                        'recorded_by' => $recordedBy,
                        'category' => $expense['category'],
                        'description' => $expense['description'],
                        'amount' => $expense['amount'],
                        'currency' => 'RWF',
                        'expense_date' => now()
                            ->subDays(($index + 1) * 5)
                            ->toDateString(),
                        'vendor_name' => $expense['vendor'],
                        'receipt_path' => null,
                        'status' => $expense['status'],
                        'notes' => 'Development sample expense.',
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        });

        $this->command->info('Property expenses seeded successfully.');
    }
}