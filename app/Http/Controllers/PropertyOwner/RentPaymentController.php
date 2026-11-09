<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\RentPayment;
use App\Services\RentInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RentPaymentController extends Controller
{
    /**
     * Get leases belonging to the authenticated property owner.
     */
    private function ownedLeasesQuery(Request $request)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $propertyIds = $owner->properties()
            ->select('managed_properties.id');

        return Lease::query()->whereHas('unit', function ($query) use ($propertyIds) {
            $query->whereIn('managed_property_id', $propertyIds);
        });
    }

    /**
     * Get payments belonging to the authenticated property owner.
     */
    private function ownedPaymentsQuery(Request $request)
    {
        $leaseIds = $this->ownedLeasesQuery($request)
            ->select('leases.id');

        return RentPayment::query()
            ->whereIn('lease_id', $leaseIds);
    }

    /**
     * Resolve a payment while enforcing ownership.
     */
    private function findOwnedPayment(
        Request $request,
        RentPayment $payment
    ): RentPayment {
        return $this->ownedPaymentsQuery($request)
            ->whereKey($payment->id)
            ->firstOrFail();
    }

    /**
     * Display the owner's payments.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => [
                'nullable',
                Rule::in([
                    'pending',
                    'completed',
                    'failed',
                    'refunded',
                ]),
            ],
        ]);

        $payments = $this->ownedPaymentsQuery($request)
            ->with([
                'lease.tenant',
                'lease.unit.managedProperty',
                'recorder',
                'allocations.invoice',
            ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->input('search'));

                $query->where(function ($q) use ($search) {
                    $q->where('receipt_number', 'like', "%{$search}%")
                        ->orWhere('transaction_reference', 'like', "%{$search}%")
                        ->orWhereHas('lease.tenant', function ($tenantQuery) use ($search) {
                            $tenantQuery
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('lease', function ($leaseQuery) use ($search) {
                            $leaseQuery->where(
                                'lease_number',
                                'like',
                                "%{$search}%"
                            );
                        });
                });
            })
            ->when(
                $request->filled('status'),
                fn($query) => $query->where(
                    'status',
                    $request->input('status')
                )
            )
            ->latest('payment_date')
            ->paginate(15)
            ->withQueryString();

        return view('property-owner.payments.index', compact('payments'));
    }

    /**
     * Display the payment recording form.
     */
    public function create(Request $request)
    {
        $leases = $this->ownedLeasesQuery($request)
            ->where('status', 'active')
            ->with(['tenant', 'unit.managedProperty'])
            ->orderBy('lease_number')
            ->get();

        return view('property-owner.payments.create', compact('leases'));
    }

    /**
     * Record a payment and allocate it immediately if completed.
     */
    public function store(
        Request $request,
        RentInvoiceService $invoiceService
    ) {
        $validated = $request->validate([
            'lease_id' => ['required', 'integer'],
            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:9999999999999.99',
            ],
            'currency' => ['required', 'string', 'size:3'],
            'payment_method' => [
                'required',
                Rule::in([
                    'cash',
                    'bank_transfer',
                    'mobile_money',
                    'card',
                    'other',
                ]),
            ],
            'transaction_reference' => [
                'nullable',
                'string',
                'max:255',
                'unique:rent_payments,transaction_reference',
            ],
            'payment_date' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'period_start' => ['nullable', 'date'],
            'period_end' => [
                'nullable',
                'date',
                'after_or_equal:period_start',
            ],
            'payment_type' => [
                'required',
                Rule::in([
                    'rent',
                    'security_deposit',
                    'late_fee',
                    'other',
                ]),
            ],
            'status' => [
                'required',
                Rule::in(['pending', 'completed']),
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $lease = $this->ownedLeasesQuery($request)
            ->whereKey($validated['lease_id'])
            ->firstOrFail();

        if ($lease->status !== 'active') {
            throw ValidationException::withMessages([
                'lease_id' => 'Payments can only be recorded against an active lease.',
            ]);
        }

        if ($validated['currency'] !== $lease->currency) {
            throw ValidationException::withMessages([
                'currency' => 'The payment currency must match the lease currency.',
            ]);
        }

        $payment = DB::transaction(function () use (
            $request,
            $validated,
            $invoiceService
        ) {
            $payment = RentPayment::create([
                ...$validated,
                'recorded_by' => $request->user()->id,
                'receipt_number' => $this->generateReceiptNumber(),
            ]);

            if ($payment->status === 'completed') {
                $invoiceService->allocatePayment(
                    $payment,
                    $request->user()->id
                );
            }

            return $payment;
        });

        return redirect()
            ->route('property-owner.payments.show', $payment)
            ->with(
                'success',
                $payment->status === 'completed'
                    ? 'Payment recorded and allocated to outstanding invoices where applicable.'
                    : 'Pending payment recorded successfully.'
            );
    }

    /**
     * Display payment details and allocation history.
     */
    public function show(Request $request, RentPayment $payment)
    {
        $payment = $this->findOwnedPayment($request, $payment);

        $payment->load([
            'lease.tenant',
            'lease.unit.managedProperty',
            'recorder',
            'allocations.invoice',
            'allocations.allocator',
        ]);

        $allocatedAmount = (float) $payment->allocations
            ->sum(fn($allocation) => (float) $allocation->amount);

        $unallocatedAmount = max(
            0,
            (float) $payment->amount - $allocatedAmount
        );

        return view('property-owner.payments.show', compact(
            'payment',
            'allocatedAmount',
            'unallocatedAmount'
        ));
    }

    /**
     * Update a pending payment.
     *
     * Completion and invoice allocation happen atomically.
     */
    public function updateStatus(
        Request $request,
        RentPayment $payment,
        RentInvoiceService $invoiceService
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['completed', 'failed']),
            ],
        ]);

        DB::transaction(function () use (
            $request,
            $payment,
            $validated,
            $invoiceService
        ) {
            // Recheck ownership and lock the payment row to prevent
            // concurrent requests from processing it twice.
            $lockedPayment = $this->ownedPaymentsQuery($request)
                ->whereKey($payment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Only pending payments can be updated through this action.',
                ]);
            }

            $lockedPayment->status = $validated['status'];
            $lockedPayment->save();

            if ($validated['status'] === 'completed') {
                $invoiceService->allocatePayment(
                    $lockedPayment,
                    $request->user()->id
                );
            }
        });

        return redirect()
            ->route('property-owner.payments.show', $payment)
            ->with(
                'success',
                $validated['status'] === 'completed'
                    ? 'Payment completed and allocated to outstanding invoices where applicable.'
                    : 'Payment marked as failed.'
            );
    }

    /**
     * Display a receipt for a completed payment.
     */
    public function receipt(Request $request, RentPayment $payment)
    {
        $payment = $this->findOwnedPayment($request, $payment);

        abort_unless($payment->status === 'completed', 404);

        $payment->load([
            'lease.tenant',
            'lease.unit.managedProperty',
            'allocations.invoice',
        ]);

        return view('property-owner.payments.receipt', compact('payment'));
    }

    /**
     * Generate a unique receipt number.
     */
    private function generateReceiptNumber(): string
    {
        do {
            $number = 'RCP-'
                . now()->format('Ymd')
                . '-'
                . Str::upper(Str::random(6));
        } while (
            RentPayment::query()
            ->where('receipt_number', $number)
            ->exists()
        );

        return $number;
    }
}
