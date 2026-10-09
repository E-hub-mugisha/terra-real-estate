<?php

namespace App\Services;

use App\Models\Lease;
use App\Models\RentInvoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RentInvoiceService
{
    /**
     * Generate initial rent and deposit invoices for an active lease.
     */
    public function generateInitialInvoices(Lease $lease): void
    {
        DB::transaction(function () use ($lease) {
            $lease = Lease::whereKey($lease->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lease->status !== 'active') {
                return;
            }

            $start = Carbon::parse($lease->start_date)->startOfDay();
            $leaseEnd = Carbon::parse($lease->end_date)->startOfDay();

            if ($start->gt($leaseEnd)) {
                return;
            }

            // Initial rent invoice.
            $periodEnd = $this->periodEnd($start, $lease);

            $this->createRentInvoiceIfMissing(
                $lease,
                $start,
                $periodEnd
            );

            // Deposit invoice, only when a deposit is required.
            if ((float) $lease->deposit_amount > 0) {
                $depositExists = RentInvoice::where('lease_id', $lease->id)
                    ->where('invoice_type', 'deposit')
                    ->where('status', '!=', 'cancelled')
                    ->exists();

                if (! $depositExists) {
                    $amount = round((float) $lease->deposit_amount, 2);

                    RentInvoice::create([
                        'invoice_number' => $this->generateInvoiceNumber(),
                        'lease_id' => $lease->id,
                        'tenant_id' => $lease->tenant_id,
                        'unit_id' => $lease->unit_id,
                        'invoice_type' => 'deposit',
                        'description' => 'Security deposit for lease '.$lease->lease_number,
                        'billing_period_start' => null,
                        'billing_period_end' => null,
                        'issue_date' => now()->toDateString(),
                        'due_date' => $start->toDateString(),
                        'amount' => $amount,
                        'paid_amount' => 0,
                        'balance' => $amount,
                        'status' => 'issued',
                        'notes' => 'Automatically generated when the lease was activated.',
                    ]);
                }
            }
        });
    }

    /**
     * Generate any recurring rent invoices that have become due for an active lease.
     * This method can also catch up if the scheduler missed a billing date.
     */
    public function generateRecurringInvoices(Lease $lease): int
    {
        if ($lease->status !== 'active') {
            return 0;
        }

        return DB::transaction(function () use ($lease) {
            $lease = Lease::whereKey($lease->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lease->status !== 'active') {
                return 0;
            }

            $leaseEnd = Carbon::parse($lease->end_date)->startOfDay();
            $today = Carbon::today();

            $lastInvoice = RentInvoice::where('lease_id', $lease->id)
                ->where('invoice_type', 'rent')
                ->whereNotNull('billing_period_end')
                ->orderByDesc('billing_period_end')
                ->first();

            if (! $lastInvoice) {
                // Recover safely if an active lease has no initial rent invoice.
                $start = Carbon::parse($lease->start_date)->startOfDay();

                if ($start->gt($today) || $start->gt($leaseEnd)) {
                    return 0;
                }

                $this->createRentInvoiceIfMissing(
                    $lease,
                    $start,
                    $this->periodEnd($start, $lease)
                );

                $lastInvoice = RentInvoice::where('lease_id', $lease->id)
                    ->where('invoice_type', 'rent')
                    ->whereNotNull('billing_period_end')
                    ->orderByDesc('billing_period_end')
                    ->first();
            }

            if (! $lastInvoice) {
                return 0;
            }

            $nextStart = Carbon::parse($lastInvoice->billing_period_end)
                ->addDay()
                ->startOfDay();

            $created = 0;

            while (
                $nextStart->lte($today) &&
                $nextStart->lte($leaseEnd)
            ) {
                $periodEnd = $this->periodEnd($nextStart, $lease);

                $invoice = $this->createRentInvoiceIfMissing(
                    $lease,
                    $nextStart,
                    $periodEnd
                );

                if ($invoice) {
                    $created++;
                }

                $nextStart = $periodEnd->copy()->addDay();
            }

            return $created;
        });
    }

    private function createRentInvoiceIfMissing(
        Lease $lease,
        Carbon $periodStart,
        Carbon $periodEnd
    ): ?RentInvoice {
        $exists = RentInvoice::where('lease_id', $lease->id)
            ->where('invoice_type', 'rent')
            ->whereDate('billing_period_start', $periodStart->toDateString())
            ->whereDate('billing_period_end', $periodEnd->toDateString())
            ->exists();

        if ($exists) {
            return null;
        }

        $months = $this->frequencyInMonths($lease->payment_frequency);

        // Rent is billed monthly, quarterly, semi-annually, or annually.
        $amount = round((float) $lease->monthly_rent * $months, 2);

        $description = $periodStart->format('F Y') === $periodEnd->format('F Y')
            ? $periodStart->format('F Y').' Rent'
            : $periodStart->format('d M Y').' - '.$periodEnd->format('d M Y').' Rent';

        return RentInvoice::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'lease_id' => $lease->id,
            'tenant_id' => $lease->tenant_id,
            'unit_id' => $lease->unit_id,
            'invoice_type' => 'rent',
            'description' => $description,
            'billing_period_start' => $periodStart->toDateString(),
            'billing_period_end' => $periodEnd->toDateString(),
            'issue_date' => now()->toDateString(),
            'due_date' => $periodStart->toDateString(),
            'amount' => $amount,
            'paid_amount' => 0,
            'balance' => $amount,
            'status' => 'issued',
            'notes' => 'Automatically generated from lease '.$lease->lease_number.'.',
        ]);
    }

    private function periodEnd(Carbon $periodStart, Lease $lease): Carbon
    {
        $months = $this->frequencyInMonths($lease->payment_frequency);

        $end = $periodStart->copy()
            ->addMonthsNoOverflow($months)
            ->subDay()
            ->startOfDay();

        $leaseEnd = Carbon::parse($lease->end_date)->startOfDay();

        return $end->gt($leaseEnd) ? $leaseEnd : $end;
    }

    private function frequencyInMonths(string $frequency): int
    {
        return match ($frequency) {
            'quarterly' => 3,
            'semi_annually' => 6,
            'annually' => 12,
            default => 1,
        };
    }

    private function generateInvoiceNumber(): string
    {
        do {
            $number = 'INV-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (RentInvoice::where('invoice_number', $number)->exists());

        return $number;
    }
}