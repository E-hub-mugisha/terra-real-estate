<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\RentInvoice;
use App\Models\RentPayment;
use App\Models\Tenant;
use App\Services\PropertyManagement\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    /**
     * Display payments.
     */
    public function index(Request $request)
    {
        $payments = RentPayment::with([
            'tenant',
            'lease',
            'unit',
            'recorder',
        ])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {

                    $q->where(
                        'payment_number',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'transaction_id',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas('tenant', function ($tenant) use ($search) {

                            $tenant
                                ->where(
                                    'first_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'last_name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%"
                                );
                        });
                });
            })
            ->when(
                $request->payment_method,
                fn($q, $method) =>
                $q->where(
                    'payment_method',
                    $method
                )
            )
            ->latest('payment_date')
            ->paginate(15)
            ->withQueryString();

        return view(
            'property-management.payments.index',
            compact('payments')
        );
    }

    /**
     * Show payment creation form.
     */
    public function create(Request $request)
    {
        $tenants = Tenant::query()
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $leases = Lease::with([
            'tenant',
            'unit.floor.building.property',
        ])
            ->where('status', 'active')
            ->get();

        $invoices = RentInvoice::with([
            'tenant',
            'lease',
            'unit',
        ])
            ->whereIn('status', [
                'issued',
                'partially_paid',
                'overdue',
            ])
            ->where('balance', '>', 0)
            ->orderBy('due_date')
            ->get();

        return view(
            'property-management.payments.create',
            compact(
                'tenants',
                'leases',
                'invoices'
            )
        );
    }

    /**
     * Store payment.
     */
    public function store(
        Request $request,
        PaymentService $paymentService
    ) {
        $validated = $request->validate([
            'tenant_id' => [
                'required',
                'exists:tenants,id',
            ],

            'lease_id' => [
                'required',
                'exists:leases,id',
            ],

            /*
             * Unit is derived from the selected lease.
             * Therefore it is NOT required from the browser.
             */
            'unit_id' => [
                'nullable',
                'exists:units,id',
            ],

            'payment_method' => [
                'required',
                'in:cash,bank_transfer,mobile_money,card,payment_gateway,other',
            ],

            'provider' => [
                'nullable',
                'string',
                'max:255',
            ],

            'transaction_id' => [
                'nullable',
                'string',
                'max:255',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'currency' => [
                'required',
                'string',
                'size:3',
            ],

            'payment_date' => [
                'required',
                'date',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'allocations' => [
                'nullable',
                'array',
            ],

            'allocations.*.rent_invoice_id' => [
                'required',
                'exists:rent_invoices,id',
            ],

            'allocations.*.amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get lease
        |--------------------------------------------------------------------------
        */

        $lease = Lease::with([
            'tenant',
            'unit.floor.building.property',
        ])->findOrFail(
            $validated['lease_id']
        );

        /*
        |--------------------------------------------------------------------------
        | Make sure selected tenant matches lease tenant
        |--------------------------------------------------------------------------
        */

        if (
            (int) $lease->tenant_id !==
            (int) $validated['tenant_id']
        ) {
            throw ValidationException::withMessages([
                'lease_id' =>
                'The selected lease does not belong to the selected tenant.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure property belongs to authenticated owner
        |--------------------------------------------------------------------------
        */

        $property = $lease
            ->unit
            ?->floor
            ?->building
            ?->property;

        if (
            !$property ||
            (int) $property->user_id !== (int) Auth::id()
        ) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Automatically determine unit from lease
        |--------------------------------------------------------------------------
        */

        if (!$lease->unit_id) {
            throw ValidationException::withMessages([
                'lease_id' =>
                'The selected lease does not have a valid unit.',
            ]);
        }

        $validated['unit_id'] = $lease->unit_id;

        /*
        |--------------------------------------------------------------------------
        | Currency
        |--------------------------------------------------------------------------
        */

        $validated['currency'] = strtoupper(
            $validated['currency'] ?? 'RWF'
        );

        /*
        |--------------------------------------------------------------------------
        | Validate allocation total
        |--------------------------------------------------------------------------
        */

        $totalAllocation = collect(
            $validated['allocations'] ?? []
        )->sum(function ($allocation) {
            return (float) $allocation['amount'];
        });

        if (
            round($totalAllocation, 2) >
            round((float) $validated['amount'], 2)
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'allocations' =>
                    'The allocated amount cannot exceed the payment amount.',
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Record payment
        |--------------------------------------------------------------------------
        */

        $payment = $paymentService->recordPayment(
            $validated,
            $validated['allocations'] ?? []
        );

        return redirect()
            ->route(
                'property-management.payments.show',
                $payment
            )
            ->with(
                'success',
                'Payment recorded successfully.'
            );
    }

    /**
     * Display payment.
     */
    public function show(RentPayment $payment)
    {
        $payment->load([
            'tenant',
            'lease.unit.floor.building.property',
            'unit.floor.building.property',
            'recorder',
            'allocations.invoice',
        ]);

        $this->authorizePayment($payment);

        return view(
            'property-management.payments.show',
            compact('payment')
        );
    }

    /**
     * Authorize payment against property owner.
     */
    protected function authorizePayment(
        RentPayment $payment
    ): void {
        $payment->loadMissing([
            'unit.floor.building.property',
        ]);

        $property = $payment
            ->unit
            ?->floor
            ?->building
            ?->property;

        if (
            !$property ||
            (int) $property->user_id !== (int) Auth::id()
        ) {
            abort(403);
        }
    }

    public function confirm(
        RentPayment $payment,
        PaymentService $paymentService
    ) {
        try {
            $paymentService->confirmPayment($payment);

            return redirect()
                ->route('property-management.payments.show', $payment->id)
                ->with('success', 'Payment confirmed successfully.');
        } catch (ValidationException $e) {
            throw $e;
        }
    }

    public function reject(RentPayment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with(
                'error',
                'Only pending payments can be marked as failed.'
            );
        }

        $payment->update([
            'status' => 'failed',
        ]);

        return back()->with(
            'success',
            'Payment has been marked as failed.'
        );
    }
}
