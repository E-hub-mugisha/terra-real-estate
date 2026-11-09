
<?php

namespace App\Services;

use App\Models\Lease;
use App\Models\RentInvoice;
use App\Models\RentPayment;
use App\Models\RentPaymentAllocation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RentInvoiceService
{
    /**
     * Generate initial rent and security deposit invoices
     * for an active lease.
     */
    public function generateInitialInvoices(Lease $lease): void
    {
        DB::transaction(function () use ($lease) {
            $lease = Lease::query()
                ->whereKey($lease->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lease->status !== 'active') {
                return;
            }

            $start = Carbon::parse($lease->start_date)->startOfDay();

            $leaseEnd = $lease->end_date
                ? Carbon::parse($lease->end_date)->startOfDay()
                : null;

            if ($leaseEnd && $start->gt($leaseEnd)) {
                return;
            }

            // Generate the initial rent invoice.
            $periodEnd = $this->periodEnd($start, $lease);

            $this->createRentInvoiceIfMissing(
                $lease,
                $start,
                $periodEnd
            );

            // Generate a deposit invoice only if a deposit is required.
            $depositAmount = (float) (
                $lease->deposit_amount
                ?? $lease->security_deposit
                ?? 0
            );

            if ($depositAmount > 0) {
                $depositExists = RentInvoice::query()
                    ->where('lease_id', $lease->id)
                    ->where('invoice_type', 'deposit')
                    ->where('status', '!=', 'cancelled')
                    ->exists();

                if (! $depositExists) {
                    $amount = round($depositAmount, 2);

                    RentInvoice::create([
                        'invoice_number' => $this->generateInvoiceNumber(),
                        'lease_id' => $lease->id,
                        'tenant_id' => $lease->tenant_id,
                        'unit_id' => $lease->unit_id,
                        'invoice_type' => 'deposit',
                        'description' => 'Security deposit for lease '
                            . $lease->lease_number,
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
     * Generate recurring invoices for an active lease.
     *
     * Catches up on missed billing periods but does not generate
     * a future period before its start date.
     *
     * Returns the number of invoices created.
     */
    public function generateRecurringInvoices(Lease $lease): int
    {
        if ($lease->status !== 'active') {
            return 0;
        }

        return DB::transaction(function () use ($lease) {
            $lease = Lease::query()
                ->whereKey($lease->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lease->status !== 'active') {
                return 0;
            }

            $today = Carbon::today();

            $leaseEnd = $lease->end_date
                ? Carbon::parse($lease->end_date)->startOfDay()
                : null;

            if ($leaseEnd && Carbon::parse($lease->start_date)->gt($leaseEnd)) {
                return 0;
            }

            $lastInvoice = RentInvoice::query()
                ->where('lease_id', $lease->id)
                ->where('invoice_type', 'rent')
                ->whereNotNull('billing_period_end')
                ->orderByDesc('billing_period_end')
                ->orderByDesc('id')
                ->first();

            if (! $lastInvoice) {
                // Recover an initial invoice if it was never generated.
                $start = Carbon::parse($lease->start_date)->startOfDay();

                if ($start->gt($today)) {
                    return 0;
                }

                if ($leaseEnd && $start->gt($leaseEnd)) {
                    return 0;
                }

                $this->createRentInvoiceIfMissing(
                    $lease,
                    $start,
                    $this->periodEnd($start, $lease)
                );

                $lastInvoice = RentInvoice::query()
                    ->where('lease_id', $lease->id)
                    ->where('invoice_type', 'rent')
                    ->whereNotNull('billing_period_end')
                    ->orderByDesc('billing_period_end')
                    ->orderByDesc('id')
                    ->first();
            }

            if (! $lastInvoice) {
                return 0;
            }

            $nextStart = Carbon::parse(
                $lastInvoice->billing_period_end
            )->addDay()->startOfDay();

            $created = 0;

            while (
                $nextStart->lte($today)
                && (! $leaseEnd || $nextStart->lte($leaseEnd))
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

                // Always advance to avoid an infinite loop.
                $nextStart = $periodEnd->copy()->addDay()->startOfDay();
            }

            return $created;
        });
    }

    /**
     * Create a rent invoice only if its billing period does not exist.
     */
    private function createRentInvoiceIfMissing(
        Lease $lease,
        Carbon $periodStart,
        Carbon $periodEnd
    ): ?RentInvoice {
        $exists = RentInvoice::query()
            ->where('lease_id', $lease->id)
            ->where('invoice_type', 'rent')
            ->whereDate(
                'billing_period_start',
                $periodStart->toDateString()
            )
            ->whereDate(
                'billing_period_end',
                $periodEnd->toDateString()
            )
            ->exists();

        if ($exists) {
            return null;
        }

        $months = $this->frequencyInMonths(
            $lease->payment_frequency
        );

        $amount = round(
            (float) $lease->monthly_rent * $months,
            2
        );

        $description = $periodStart->format('F Y')
            === $periodEnd->format('F Y')
            ? $periodStart->format('F Y') . ' Rent'
            : $periodStart->format('d M Y')
                . ' - '
                . $periodEnd->format('d M Y')
                . ' Rent';

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
            'currency' => $lease->currency ?? 'RWF',
            'amount' => $amount,
            'paid_amount' => 0,
            'balance' => $amount,
            'status' => 'issued',
            'notes' => 'Automatically generated from lease '
                . $lease->lease_number . '.',
        ]);
    }

    /**
     * Calculate the end date of a billing period without exceeding
     * the lease end date.
     */
    private function periodEnd(
        Carbon $periodStart,
        Lease $lease
    ): Carbon {
        $months = $this->frequencyInMonths(
            $lease->payment_frequency
        );

        $end = $periodStart->copy()
            ->addMonthsNoOverflow($months)
            ->subDay()
            ->startOfDay();

        if (! $lease->end_date) {
            return $end;
        }

        $leaseEnd = Carbon::parse($lease->end_date)->startOfDay();

        return $end->gt($leaseEnd) ? $leaseEnd : $end;
    }

    /**
     * Convert the lease billing frequency to a month count.
     */
    private function frequencyInMonths(string $frequency): int
    {
        return match ($frequency) {
            'quarterly' => 3,
            'semi_annually' => 6,
            'annually' => 12,
            default => 1,
        };
    }

    /**
     * Allocate a completed payment to the oldest outstanding
     * invoices for the same lease.
     *
     * A payment may cover multiple invoices. Partial invoice
     * payments are supported. Any excess remains unallocated.
     *
     * Returns the amount allocated during this operation.
     */
    public function allocatePayment(
        RentPayment $payment,
        ?int $allocatedBy = null
    ): float {
        return DB::transaction(function () use (
            $payment,
            $allocatedBy
        ) {
            $payment = RentPayment::query()
                ->whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($payment->status !== 'completed') {
                throw ValidationException::withMessages([
                    'payment' => 'Only completed payments can be allocated.',
                ]);
            }

            $lease = Lease::query()
                ->whereKey($payment->lease_id)
                ->firstOrFail();

            $paymentCurrency = $payment->currency
                ?? $lease->currency
                ?? 'RWF';

            $leaseCurrency = $lease->currency ?? 'RWF';

            if ($paymentCurrency !== $leaseCurrency) {
                throw ValidationException::withMessages([
                    'payment' => 'Payment currency must match the lease currency.',
                ]);
            }

            // Prevent allocating more than the payment amount.
            $alreadyAllocated = (float) RentPaymentAllocation::query()
                ->where('rent_payment_id', $payment->id)
                ->sum('amount');

            $remaining = round(
                (float) $payment->amount - $alreadyAllocated,
                2
            );

            if ($remaining <= 0) {
                return 0.0;
            }

            // Oldest due invoice first. Deposits are also eligible
            // because they are outstanding financial obligations.
            $invoices = RentInvoice::query()
                ->where('lease_id', $lease->id)
                ->where('currency', $paymentCurrency)
                ->whereIn('status', [
                    'issued',
                    'partially_paid',
                    'overdue',
                ])
                ->where('balance', '>', 0)
                ->orderBy('due_date')
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            $allocatedNow = 0.0;

            foreach ($invoices as $invoice) {
                if ($remaining <= 0) {
                    break;
                }

                $balance = round((float) $invoice->balance, 2);

                if ($balance <= 0) {
                    continue;
                }

                $amount = round(min($remaining, $balance), 2);

                if ($amount <= 0) {
                    continue;
                }

                // One allocation per payment/invoice pair.
                // If a pair already exists, increase it rather than
                // attempting to insert a duplicate row.
                $allocation = RentPaymentAllocation::query()
                    ->where('rent_payment_id', $payment->id)
                    ->where('rent_invoice_id', $invoice->id)
                    ->lockForUpdate()
                    ->first();

                if ($allocation) {
                    $allocation->amount = round(
                        (float) $allocation->amount + $amount,
                        2
                    );

                    $allocation->allocated_by = $allocatedBy;
                    $allocation->allocated_at = now();
                    $allocation->save();
                } else {
                    RentPaymentAllocation::create([
                        'rent_payment_id' => $payment->id,
                        'rent_invoice_id' => $invoice->id,
                        'amount' => $amount,
                        'allocated_by' => $allocatedBy,
                        'allocated_at' => now(),
                    ]);
                }

                $invoice->paid_amount = round(
                    (float) $invoice->paid_amount + $amount,
                    2
                );

                $invoice->balance = max(
                    0,
                    round(
                        (float) $invoice->amount
                            - (float) $invoice->paid_amount,
                        2
                    )
                );

                $invoice->status = $this->calculateInvoiceStatus(
                    $invoice->amount,
                    $invoice->paid_amount,
                    $invoice->due_date,
                    $invoice->status
                );

                $invoice->save();

                $remaining = round($remaining - $amount, 2);
                $allocatedNow = round($allocatedNow + $amount, 2);
            }

            return $allocatedNow;
        });
    }

    /**
     * Recalculate invoice balances from completed payment allocations.
     *
     * Useful after a properly audited allocation correction.
     */
    public function recalculateInvoiceBalance(
        RentInvoice $invoice
    ): void {
        DB::transaction(function () use ($invoice) {
            $invoice = RentInvoice::query()
                ->whereKey($invoice->id)
                ->lockForUpdate()
                ->firstOrFail();

            $paid = (float) RentPaymentAllocation::query()
                ->where('rent_invoice_id', $invoice->id)
                ->whereHas('payment', function ($query) {
                    $query->where('status', 'completed');
                })
                ->sum('amount');

            $invoice->paid_amount = round($paid, 2);

            $invoice->balance = max(
                0,
                round(
                    (float) $invoice->amount - $invoice->paid_amount,
                    2
                )
            );

            $invoice->status = $this->calculateInvoiceStatus(
                $invoice->amount,
                $invoice->paid_amount,
                $invoice->due_date,
                $invoice->status
            );

            $invoice->save();
        });
    }

    /**
     * Determine the invoice status from its balance and due date.
     *
     * Cancelled invoices remain cancelled.
     */
    private function calculateInvoiceStatus(
        float|string $amount,
        float|string $paidAmount,
        mixed $dueDate,
        ?string $currentStatus = null
    ): string {
        if ($currentStatus === 'cancelled') {
            return 'cancelled';
        }

        $amount = round((float) $amount, 2);
        $paidAmount = round((float) $paidAmount, 2);
        $balance = max(0, round($amount - $paidAmount, 2));

        if ($balance <= 0) {
            return 'paid';
        }

        if (
            $dueDate
            && Carbon::parse($dueDate)->startOfDay()->lt(Carbon::today())
        ) {
            return 'overdue';
        }

        if ($paidAmount > 0) {
            return 'partially_paid';
        }

        return 'issued';
    }

    /**
     * Generate a unique invoice number.
     */
    private function generateInvoiceNumber(): string
    {
        do {
            $number = 'INV-'
                . now()->format('Ymd')
                . '-'
                . Str::upper(Str::random(6));
        } while (
            RentInvoice::query()
                ->where('invoice_number', $number)
                ->exists()
        );

        return $number;
    }
}
