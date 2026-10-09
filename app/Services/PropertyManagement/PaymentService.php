<?php

namespace App\Services\PropertyManagement;

use App\Models\RentInvoice;
use App\Models\RentLedgerEntries;
use App\Models\RentPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    /**
     * Record a payment and allocate it to invoices.
     *
     * Pending payments are recorded without updating invoice
     * balances or the rent ledger until they are confirmed.
     */
    public function recordPayment(
        array $data,
        array $allocations = []
    ): RentPayment {
        return DB::transaction(function () use ($data, $allocations) {
            $paymentAmount = round((float) $data['amount'], 2);
            $status = $data['status'] ?? 'confirmed';

            if ($paymentAmount <= 0) {
                throw ValidationException::withMessages([
                    'amount' => 'Payment amount must be greater than zero.',
                ]);
            }

            if (!in_array($status, [
                'pending',
                'confirmed',
                'failed',
                'reversed',
                'cancelled',
            ], true)) {
                throw ValidationException::withMessages([
                    'status' => 'Invalid payment status.',
                ]);
            }

            $totalAllocation = collect($allocations)->sum(
                fn ($allocation) => round(
                    (float) ($allocation['amount'] ?? 0),
                    2
                )
            );

            if (
                round($totalAllocation, 2) >
                $paymentAmount
            ) {
                throw ValidationException::withMessages([
                    'allocations' =>
                        'The allocated amount cannot exceed the payment amount.',
                ]);
            }

            $payment = RentPayment::create([
                'payment_number' => $this->generatePaymentNumber(),
                'tenant_id' => $data['tenant_id'],
                'lease_id' => $data['lease_id'],
                'unit_id' => $data['unit_id'],
                'payment_method' => $data['payment_method'],
                'provider' => $data['provider'] ?? null,
                'transaction_id' => $data['transaction_id'] ?? null,
                'amount' => $paymentAmount,
                'currency' => strtoupper($data['currency'] ?? 'RWF'),
                'payment_date' => $data['payment_date'],
                'status' => $status,
                'description' => $data['description'] ?? null,
                'notes' => $data['notes'] ?? null,
                'recorded_by' => auth()->id(),
            ]);

            foreach ($allocations as $allocation) {
                $invoiceId = $allocation['rent_invoice_id'] ?? null;
                $amount = round((float) ($allocation['amount'] ?? 0), 2);

                if (!$invoiceId || $amount <= 0) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'Each allocation must have an invoice and an amount greater than zero.',
                    ]);
                }

                $invoice = RentInvoice::query()
                    ->whereKey($invoiceId)
                    ->lockForUpdate()
                    ->firstOrFail();

                // Verify tenant, lease, and unit ownership.
                if (
                    (int) $invoice->tenant_id !== (int) $payment->tenant_id ||
                    (int) $invoice->lease_id !== (int) $payment->lease_id ||
                    (int) $invoice->unit_id !== (int) $payment->unit_id
                ) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'The selected invoice does not belong to this tenant, lease, and unit.',
                    ]);
                }

                if (in_array($invoice->status, [
                    'draft',
                    'cancelled',
                    'paid',
                ], true)) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'This invoice is not available for payment.',
                    ]);
                }

                // Prevent overpayment.
                $invoiceBalance = round((float) $invoice->balance, 2);

                if ($amount > $invoiceBalance) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'Payment allocation cannot exceed the outstanding invoice balance.',
                    ]);
                }

                // Prevent allocating the same invoice twice to one payment.
                $alreadyAllocated = $payment->allocations()
                    ->where('rent_invoice_id', $invoice->id)
                    ->exists();

                if ($alreadyAllocated) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'The same invoice cannot be allocated twice.',
                    ]);
                }

                // Link the payment to the invoice exactly once.
                $payment->allocations()->create([
                    'rent_invoice_id' => $invoice->id,
                    'amount' => $amount,
                ]);

                // Do not apply unverified or unsuccessful payments.
                if ($payment->status !== 'confirmed') {
                    continue;
                }

                $newPaidAmount = round(
                    (float) $invoice->paid_amount + $amount,
                    2
                );

                $newBalance = max(
                    0,
                    round((float) $invoice->amount - $newPaidAmount, 2)
                );

                $invoice->update([
                    'paid_amount' => $newPaidAmount,
                    'balance' => $newBalance,
                    'status' => $newBalance <= 0
                        ? 'paid'
                        : 'partially_paid',
                ]);

                $this->createLedgerEntry(
                    $payment,
                    $invoice,
                    $amount
                );
            }

            return $payment->fresh([
                'tenant',
                'lease',
                'unit',
                'recorder',
                'allocations.invoice',
            ]);
        });
    }

    /**
     * Confirm a pending payment and apply its invoice allocations.
     *
     * Call this only after a property manager has verified receipt
     * of the money or a payment provider has confirmed the transaction.
     */
    public function confirmPayment(RentPayment $payment): RentPayment
    {
        return DB::transaction(function () use ($payment) {
            $payment = RentPayment::query()
                ->whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($payment->status !== 'pending') {
                throw ValidationException::withMessages([
                    'payment' => 'Only pending payments can be confirmed.',
                ]);
            }

            $allocations = $payment->allocations()
                ->orderBy('id')
                ->get();

            if ($allocations->isEmpty()) {
                throw ValidationException::withMessages([
                    'payment' => 'This payment has no invoice allocations.',
                ]);
            }

            $totalAllocated = round(
                (float) $allocations->sum('amount'),
                2
            );

            if ($totalAllocated > (float) $payment->amount) {
                throw ValidationException::withMessages([
                    'payment' => 'Allocated amounts exceed the payment amount.',
                ]);
            }

            // Validate all allocations before changing any invoice.
            $invoices = [];

            foreach ($allocations as $allocation) {
                $invoice = RentInvoice::query()
                    ->whereKey($allocation->rent_invoice_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (
                    (int) $invoice->tenant_id !== (int) $payment->tenant_id ||
                    (int) $invoice->lease_id !== (int) $payment->lease_id ||
                    (int) $invoice->unit_id !== (int) $payment->unit_id
                ) {
                    throw ValidationException::withMessages([
                        'payment' =>
                            'An allocated invoice does not match this payment.',
                    ]);
                }

                $amount = round((float) $allocation->amount, 2);

                if (
                    $amount <= 0 ||
                    in_array($invoice->status, [
                        'draft',
                        'cancelled',
                        'paid',
                    ], true) ||
                    $amount > round((float) $invoice->balance, 2)
                ) {
                    throw ValidationException::withMessages([
                        'payment' =>
                            'An invoice balance or status has changed. Review this payment before confirming it.',
                    ]);
                }

                $invoices[] = [
                    'invoice' => $invoice,
                    'amount' => $amount,
                ];
            }

            // All validations passed. Apply the allocations.
            foreach ($invoices as $item) {
                /** @var RentInvoice $invoice */
                $invoice = $item['invoice'];
                $amount = $item['amount'];

                $newPaidAmount = round(
                    (float) $invoice->paid_amount + $amount,
                    2
                );

                $newBalance = max(
                    0,
                    round((float) $invoice->amount - $newPaidAmount, 2)
                );

                $invoice->update([
                    'paid_amount' => $newPaidAmount,
                    'balance' => $newBalance,
                    'status' => $newBalance <= 0
                        ? 'paid'
                        : 'partially_paid',
                ]);

                $this->createLedgerEntry(
                    $payment,
                    $invoice,
                    $amount
                );
            }

            $payment->update([
                'status' => 'confirmed',
                'recorded_by' => auth()->id(),
            ]);

            return $payment->fresh([
                'tenant',
                'lease',
                'unit',
                'recorder',
                'allocations.invoice',
            ]);
        });
    }

    /**
     * Create the payment credit in the rent ledger.
     */
    protected function createLedgerEntry(
        RentPayment $payment,
        RentInvoice $invoice,
        float $amount
    ): RentLedgerEntries {
        $lastBalance = RentLedgerEntries::query()
            ->where('tenant_id', $payment->tenant_id)
            ->orderByDesc('id')
            ->lockForUpdate()
            ->value('balance');

        $lastBalance = (float) ($lastBalance ?? 0);

        // Running balance = previous balance + debit - credit.
        $newBalance = round($lastBalance - $amount, 2);

        return RentLedgerEntries::create([
            'tenant_id' => $payment->tenant_id,
            'lease_id' => $payment->lease_id,
            'unit_id' => $payment->unit_id,
            'rent_invoice_id' => $invoice->id,
            'rent_payment_id' => $payment->id,
            'entry_type' => 'payment',
            'entry_date' => $payment->payment_date,
            'description' => 'Payment received for invoice ' .
                $invoice->invoice_number,
            'debit' => 0,
            'credit' => $amount,
            'balance' => $newBalance,
        ]);
    }

    /**
     * Generate a unique payment reference.
     */
    protected function generatePaymentNumber(): string
    {
        do {
            $number = 'TRP-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(substr(
                    str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),
                    0,
                    6
                ));
        } while (
            RentPayment::where('payment_number', $number)->exists()
        );

        return $number;
    }
}