<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\RentInvoice;
use App\Models\RentPayment;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Models\Lease;
use App\Services\PropertyManagement\PaymentService;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class TenantPaymentController extends Controller
{
    /**
     * Display the authenticated tenant's invoices and payments.
     */
    public function index(Request $request)
    {
        $tenant = Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();

        $invoices = RentInvoice::with([
            'lease',
            'unit.floor.building.property',
        ])
            ->where('tenant_id', $tenant->id)
            ->latest('issue_date')
            ->paginate(10, ['*'], 'invoices_page');

        $payments = RentPayment::with([
            'lease',
            'unit.floor.building.property',
        ])
            ->where('tenant_id', $tenant->id)
            ->latest('payment_date')
            ->paginate(10, ['*'], 'payments_page');

        $invoiceStats = RentInvoice::where('tenant_id', $tenant->id)
            ->whereNotIn('status', ['cancelled'])
            ->selectRaw('
                COALESCE(SUM(amount), 0) as total_invoiced,
                COALESCE(SUM(paid_amount), 0) as total_paid,
                COALESCE(SUM(balance), 0) as total_balance
            ')
            ->first();

        $successfulPayments = RentPayment::where('tenant_id', $tenant->id)
            ->where('status', 'confirmed')
            ->sum('amount');

        return view('tenant-portal.payments.index', compact(
            'tenant',
            'invoices',
            'payments',
            'invoiceStats',
            'successfulPayments'
        ));
    }

    /**
     * Display a payment receipt.
     */
    public function receipt(Request $request, RentPayment $payment)
    {
        $tenant = Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();

        abort_unless(
            (int) $payment->tenant_id === (int) $tenant->id,
            403
        );

        abort_unless($payment->status === 'confirmed', 404);

        $payment->load([
            'lease',
            'unit.floor.building.property',
            'allocations.invoice',
        ]);

        return view('tenant-portal.payments.receipt', compact('payment'));
    }

    /**
     * Show the payment form for one invoice.
     */
    public function create(Request $request, RentInvoice $invoice)
    {
        $tenant = Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();

        abort_unless(
            (int) $invoice->tenant_id === (int) $tenant->id,
            403
        );

        abort_unless(
            !in_array($invoice->status, ['draft', 'cancelled', 'paid']) &&
                (float) $invoice->balance > 0,
            404
        );

        $invoice->load(['lease', 'unit.floor.building.property']);

        return view('tenant-portal.payments.create', compact(
            'tenant',
            'invoice'
        ));
    }

    /**
     * Submit a payment for manager verification.
     */
    public function store(
        Request $request,
        RentInvoice $invoice,
        PaymentService $paymentService
    ) {
        $tenant = Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();

        abort_unless(
            (int) $invoice->tenant_id === (int) $tenant->id,
            403
        );

        abort_unless(
            !in_array($invoice->status, ['draft', 'cancelled', 'paid']) &&
                (float) $invoice->balance > 0,
            404
        );

        $validated = $request->validate([
            'payment_method' => [
                'required',
                Rule::in(['cash', 'bank_transfer', 'mobile_money', 'card', 'other']),
            ],
            'provider' => ['nullable', 'string', 'max:255'],
            'transaction_id' => ['nullable', 'string', 'max:255'],
            'amount' => ['required', 'numeric', 'gt:0', 'max:' . $invoice->balance],
            'payment_date' => ['required', 'date', 'before_or_equal:today'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        // Reload and lock the invoice to avoid accepting an amount
        // based on a stale balance.
        $payment = DB::transaction(function () use (
            $invoice,
            $tenant,
            $validated,
            $paymentService
        ) {
            $lockedInvoice = RentInvoice::query()
                ->whereKey($invoice->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (
                (int) $lockedInvoice->tenant_id !== (int) $tenant->id ||
                in_array($lockedInvoice->status, ['draft', 'cancelled', 'paid']) ||
                (float) $validated['amount'] > (float) $lockedInvoice->balance
            ) {
                throw ValidationException::withMessages([
                    'amount' => 'This invoice balance has changed. Please refresh the page and try again.',
                ]);
            }

            return $paymentService->recordPayment([
                'tenant_id' => $tenant->id,
                'lease_id' => $lockedInvoice->lease_id,
                'unit_id' => $lockedInvoice->unit_id,
                'payment_method' => $validated['payment_method'],
                'provider' => $validated['provider'] ?? null,
                'transaction_id' => $validated['transaction_id'] ?? null,
                'amount' => $validated['amount'],
                'currency' => 'RWF',
                'payment_date' => $validated['payment_date'],
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ], [
                [
                    'rent_invoice_id' => $lockedInvoice->id,
                    'amount' => $validated['amount'],
                ],
            ]);
        });

        return redirect()
            ->route('tenant-portal.payments.index')
            ->with(
                'success',
                'Your payment submission has been received and is awaiting verification. Reference: ' .
                    $payment->payment_number
            );
    }
}
