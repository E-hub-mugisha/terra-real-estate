<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\RentPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RentPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = RentPayment::with([
            'lease.tenant',
            'lease.unit.managedProperty',
            'recorder',
        ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);

                $query->where(function ($q) use ($search) {
                    $q->where('receipt_number', 'like', "%{$search}%")
                        ->orWhere('transaction_reference', 'like', "%{$search}%")
                        ->orWhereHas('lease', function ($leaseQuery) use ($search) {
                            $leaseQuery->where('lease_number', 'like', "%{$search}%")
                                ->orWhereHas('tenant', function ($tenantQuery) use ($search) {
                                    $tenantQuery->where('first_name', 'like', "%{$search}%")
                                        ->orWhere('last_name', 'like', "%{$search}%")
                                        ->orWhere('email', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('payment_method'), function ($query) use ($request) {
                $query->where('payment_method', $request->payment_method);
            })
            ->when($request->filled('from'), function ($query) use ($request) {
                $query->whereDate('payment_date', '>=', $request->from);
            })
            ->when($request->filled('to'), function ($query) use ($request) {
                $query->whereDate('payment_date', '<=', $request->to);
            })
            ->latest('payment_date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.property-management.payments.index', compact('payments'));
    }

    public function create()
    {
        $payment = new RentPayment([
            'currency' => 'RWF',
            'payment_method' => 'mobile_money',
            'payment_type' => 'rent',
            'payment_date' => now()->toDateString(),
            'status' => 'completed',
        ]);

        $leases = $this->eligibleLeases();

        return view(
            'admin.property-management.payments.create',
            compact('payment', 'leases')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayment($request);

        $payment = DB::transaction(function () use ($validated) {
            $lease = Lease::whereKey($validated['lease_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($lease->status === 'draft') {
                throw ValidationException::withMessages([
                    'lease_id' => 'Payments cannot be recorded against a draft lease.',
                ]);
            }

            if ($validated['currency'] !== $lease->currency) {
                throw ValidationException::withMessages([
                    'currency' => 'Payment currency must match the lease currency.',
                ]);
            }

            $validated['receipt_number'] = $this->generateReceiptNumber();
            $validated['recorded_by'] = auth()->id();

            return RentPayment::create($validated);
        });

        return redirect()
            ->route('admin.property-management.payments.show', $payment)
            ->with('success', 'Payment recorded successfully.');
    }

    public function show(RentPayment $payment)
    {
        $payment->load([
            'lease.tenant',
            'lease.unit.managedProperty',
            'lease.unit.building',
            'lease.unit.floor',
            'recorder',
        ]);

        return view('admin.property-management.payments.show', compact('payment'));
    }

    public function receipt(RentPayment $payment)
    {
        $payment->load([
            'lease.tenant',
            'lease.unit.managedProperty',
            'recorder',
        ]);

        return view('admin.property-management.payments.receipt', compact('payment'));
    }

    public function edit(RentPayment $payment)
    {
        if ($payment->status === 'completed') {
            return redirect()
                ->route('admin.property-management.payments.show', $payment)
                ->with('error', 'Completed payments cannot be edited. Use a refund or adjustment workflow.');
        }
        $leases = $this->eligibleLeases($payment->lease_id);

        return view(
            'admin.property-management.payments.edit',
            compact('payment', 'leases')
        );
    }

    public function update(Request $request, RentPayment $payment)
    {
        if ($payment->status === 'completed') {
            return redirect()
                ->route('admin.property-management.payments.show', $payment)
                ->with('error', 'Completed payments cannot be edited. Use a refund or adjustment workflow.');
        }
        $validated = $this->validatePayment($request, $payment);

        DB::transaction(function () use ($validated, $payment) {
            $lease = Lease::whereKey($validated['lease_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($lease->status === 'draft') {
                throw ValidationException::withMessages([
                    'lease_id' => 'Payments cannot be recorded against a draft lease.',
                ]);
            }

            if ($validated['currency'] !== $lease->currency) {
                throw ValidationException::withMessages([
                    'currency' => 'Payment currency must match the lease currency.',
                ]);
            }

            // Preserve the original receipt number and recorder.
            unset($validated['receipt_number'], $validated['recorded_by']);

            $payment->update($validated);
        });

        return redirect()
            ->route('admin.property-management.payments.show', $payment)
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(RentPayment $payment)
    {
        // Preserve completed financial transactions for audit purposes.
        if ($payment->status === 'completed') {
            return redirect()
                ->route('admin.property-management.payments.show', $payment)
                ->with(
                    'error',
                    'Completed payments cannot be deleted. Use a refund or adjustment workflow instead.'
                );
        }

        $payment->delete();

        return redirect()
            ->route('admin.property-management.payments.index')
            ->with('success', 'Payment record deleted successfully.');
    }

    private function eligibleLeases(?int $currentLeaseId = null)
    {
        return Lease::with(['tenant', 'unit.managedProperty'])
            ->where(function ($query) use ($currentLeaseId) {
                $query->whereIn('status', ['active', 'expired', 'terminated']);

                if ($currentLeaseId) {
                    $query->orWhere('id', $currentLeaseId);
                }
            })
            ->orderByDesc('id')
            ->get();
    }

    private function validatePayment(
        Request $request,
        ?RentPayment $payment = null
    ): array {
        return $request->validate([
            'lease_id' => ['required', 'integer', 'exists:leases,id'],

            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'max:999999999999.99',
            ],

            'currency' => [
                'required',
                Rule::in(['RWF', 'USD']),
            ],

            'payment_method' => [
                'required',
                Rule::in([
                    'cash',
                    'bank_transfer',
                    'mobile_money',
                    'card',
                    'payment_gateway',
                    'other',
                ]),
            ],

            'payment_date' => ['required', 'date'],
            'period_start' => ['nullable', 'date'],
            'period_end' => [
                'nullable',
                'date',
                'after_or_equal:period_start',
            ],

            'payment_type' => [
                'required',
                Rule::in(['rent', 'deposit', 'service_charge', 'other']),
            ],

            'status' => [
                'required',
                Rule::in(['pending', 'completed', 'failed']),
            ],

            'transaction_reference' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('rent_payments', 'transaction_reference')
                    ->ignore($payment?->id),
            ],

            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }

    private function generateReceiptNumber(): string
    {
        do {
            $number = 'RCP-' . now()->format('Ymd') . '-'
                . strtoupper(bin2hex(random_bytes(4)));
        } while (RentPayment::where('receipt_number', $number)->exists());

        return $number;
    }
}
