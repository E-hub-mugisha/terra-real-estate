<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $leases = DB::table('leases')
            ->whereIn('lease_number', [
                'LSE-2026-0001',
                'LSE-2026-0002',
                'LSE-2026-0004',
            ])
            ->get();

        if ($leases->isEmpty()) {
            $this->command->warn('Seed leases before rent payments.');
            return;
        }

        $recordedBy = User::query()
            ->whereIn('role', ['admin', 'property_owner'], 'and', false)
            ->value('id');

        DB::transaction(function () use ($leases, $recordedBy) {
            $counter = 1;

            foreach ($leases as $lease) {
                $paymentDate = now()->subMonth()->startOfMonth();
                $periodStart = $paymentDate->copy()->startOfMonth();
                $periodEnd = $paymentDate->copy()->endOfMonth();

                $payments = [
                    [
                        'suffix' => 'RENT',
                        'amount' => $lease->monthly_rent,
                        'type' => 'rent',
                        'status' => 'completed',
                        'method' => 'mobile_money',
                        'date' => $paymentDate->copy()->day(5),
                        'notes' => 'Sample rent payment.',
                    ],
                    [
                        'suffix' => 'PENDING',
                        'amount' => $lease->monthly_rent,
                        'type' => 'rent',
                        'status' => 'pending',
                        'method' => 'bank_transfer',
                        'date' => now()->startOfMonth()->addDays(4),
                        'notes' => 'Sample payment awaiting confirmation.',
                    ],
                ];

                if ($lease->lease_number === 'LSE-2026-0001') {
                    $payments[] = [
                        'suffix' => 'DEPOSIT',
                        'amount' => $lease->security_deposit,
                        'type' => 'security_deposit',
                        'status' => 'completed',
                        'method' => 'bank_transfer',
                        'date' => now()->subMonths(5)->startOfMonth(),
                        'notes' => 'Security deposit received.',
                    ];
                }

                foreach ($payments as $payment) {
                    $receipt = sprintf(
                        'RCP-2026-%04d',
                        $counter
                    );

                    DB::table('rent_payments')->updateOrInsert(
                        ['receipt_number' => $receipt],
                        [
                            'lease_id' => $lease->id,
                            'recorded_by' => $recordedBy,
                            'transaction_reference' => 'TXN-' . $receipt,
                            'amount' => $payment['amount'],
                            'currency' => 'RWF',
                            'payment_method' => $payment['method'],
                            'payment_date' => $payment['date']->toDateString(),
                            'period_start' => $payment['type'] === 'rent'
                                ? $periodStart->toDateString()
                                : null,
                            'period_end' => $payment['type'] === 'rent'
                                ? $periodEnd->toDateString()
                                : null,
                            'payment_type' => $payment['type'],
                            'status' => $payment['status'],
                            'notes' => $payment['notes'],
                            'updated_at' => now(),
                            'created_at' => now(),
                        ]
                    );

                    $counter++;
                }
            }
        });

        $this->command->info('Rent payments seeded successfully.');
    }
}