<?php

namespace App\Services\PropertyManagement;

use App\Models\RentInvoice;
use App\Models\RentLedgerEntries;
use App\Models\RentPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function recordPayment(
        array $data,
        array $allocations = []
    ): RentPayment {
        return DB::transaction(function () use (
            $data,
            $allocations
        ) {

            $totalAllocation = collect($allocations)
                ->sum(fn ($allocation) =>
                    (float) $allocation['amount']
                );

            $paymentAmount = (float) $data['amount'];

            if (
                round($totalAllocation, 2) >
                round($paymentAmount, 2)
            ) {
                throw ValidationException::withMessages([
                    'allocations' =>
                        'The allocated amount cannot exceed the payment amount.'
                ]);
            }

            $payment = RentPayment::create([
                'payment_number' =>
                    $this->generatePaymentNumber(),

                'tenant_id' =>
                    $data['tenant_id'],

                'lease_id' =>
                    $data['lease_id'],

                'unit_id' =>
                    $data['unit_id'],

                'payment_method' =>
                    $data['payment_method'],

                'provider' =>
                    $data['provider'] ?? null,

                'transaction_id' =>
                    $data['transaction_id'] ?? null,

                'amount' =>
                    $paymentAmount,

                'currency' =>
                    $data['currency'] ?? 'RWF',

                'payment_date' =>
                    $data['payment_date'],

                'status' =>
                    $data['status'] ?? 'confirmed',

                'notes' =>
                    $data['notes'] ?? null,

                'recorded_by' =>
                    auth()->id(),
            ]);

            foreach ($allocations as $allocation) {

                $invoice = RentInvoice::lockForUpdate()
                    ->findOrFail(
                        $allocation['rent_invoice_id']
                    );

                /*
                 * Make sure invoice belongs to tenant.
                 */
                if (
                    (int) $invoice->tenant_id !==
                    (int) $payment->tenant_id
                ) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'One of the selected invoices does not belong to this tenant.'
                    ]);
                }

                /*
                 * Make sure invoice belongs to lease.
                 */
                if (
                    (int) $invoice->lease_id !==
                    (int) $payment->lease_id
                ) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'One of the selected invoices does not belong to this lease.'
                    ]);
                }

                /*
                 * Make sure invoice belongs to unit.
                 */
                if (
                    (int) $invoice->unit_id !==
                    (int) $payment->unit_id
                ) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'One of the selected invoices does not belong to this unit.'
                    ]);
                }

                $amount = round(
                    (float) $allocation['amount'],
                    2
                );

                if ($amount <= 0) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'Payment allocation must be greater than zero.'
                    ]);
                }

                $balance = round(
                    (float) $invoice->balance,
                    2
                );

                if ($amount > $balance) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'Payment allocation cannot exceed the outstanding invoice balance.'
                    ]);
                }

                /*
                 * Prevent duplicate allocation.
                 */
                $alreadyAllocated =
                    $payment->allocations()
                        ->where(
                            'rent_invoice_id',
                            $invoice->id
                        )
                        ->exists();

                if ($alreadyAllocated) {
                    throw ValidationException::withMessages([
                        'allocations' =>
                            'The same invoice cannot be allocated twice.'
                    ]);
                }

                $newPaidAmount = round(
                    (float) $invoice->paid_amount +
                    $amount,
                    2
                );

                $newBalance = max(
                    0,
                    round(
                        (float) $invoice->amount -
                        $newPaidAmount,
                        2
                    )
                );

                if ($newBalance <= 0) {
                    $invoiceStatus = 'paid';
                } else {
                    $invoiceStatus = 'partially_paid';
                }

                $invoice->update([
                    'paid_amount' =>
                        $newPaidAmount,

                    'balance' =>
                        $newBalance,

                    'status' =>
                        $invoiceStatus,
                ]);

                $payment->allocations()->create([
                    'rent_invoice_id' =>
                        $invoice->id,

                    'amount' =>
                        $amount,
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

    protected function createLedgerEntry(
        RentPayment $payment,
        RentInvoice $invoice,
        float $amount
    ): RentLedgerEntries {

        /*
         * Get latest tenant ledger balance.
         */
        $lastBalance = RentLedgerEntries::where(
            'tenant_id',
            $payment->tenant_id
        )
        ->orderByDesc('id')
        ->lockForUpdate()
        ->value('balance');

        $lastBalance = (float) ($lastBalance ?? 0);

        /*
         * Payment is a credit.
         */
        $newBalance = max(
            0,
            round(
                $lastBalance - $amount,
                2
            )
        );

        return RentLedgerEntries::create([
            'tenant_id' =>
                $payment->tenant_id,

            'lease_id' =>
                $payment->lease_id,

            'unit_id' =>
                $payment->unit_id,

            'rent_invoice_id' =>
                $invoice->id,

            'rent_payment_id' =>
                $payment->id,

            'entry_type' =>
                'payment',

            'entry_date' =>
                $payment->payment_date,

            'description' =>
                'Payment received for invoice ' .
                $invoice->invoice_number,

            'debit' =>
                0,

            'credit' =>
                $amount,

            'balance' =>
                $newBalance,
        ]);
    }

    protected function generatePaymentNumber(): string
    {
        do {

            $number =
                'TRP-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(
                    substr(
                        str_shuffle(
                            'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'
                        ),
                        0,
                        6
                    )
                );

        } while (
            RentPayment::where(
                'payment_number',
                $number
            )->exists()
        );

        return $number;
    }
}