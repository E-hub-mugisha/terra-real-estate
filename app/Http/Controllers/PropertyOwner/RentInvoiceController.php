<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use App\Models\RentInvoice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RentInvoiceController extends Controller
{
    /**
     * Get invoices belonging only to properties managed by this owner.
     */
    private function ownedInvoicesQuery(Request $request)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $propertyIds = $owner->properties()
            ->select('managed_properties.id');

        return RentInvoice::query()
            ->whereHas('unit', function ($query) use ($propertyIds) {
                $query->whereIn('managed_property_id', $propertyIds);
            });
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],

            'status' => [
                'nullable',
                Rule::in([
                    'issued',
                    'partially_paid',
                    'paid',
                    'overdue',
                    'cancelled',
                ]),
            ],

            'invoice_type' => [
                'nullable',
                Rule::in([
                    'rent',
                    'deposit',
                    'security_deposit',
                    'service_charge',
                    'late_fee',
                    'other',
                ]),
            ],

            'due_from' => ['nullable', 'date'],
            'due_to' => ['nullable', 'date', 'after_or_equal:due_from'],
        ]);

        $invoices = $this->ownedInvoicesQuery($request)
            ->with([
                'tenant',
                'lease',
                'unit.managedProperty',
            ])
            ->when(
                ! empty($validated['search']),
                function ($query) use ($validated) {
                    $search = trim($validated['search']);

                    $query->where(function ($q) use ($search) {
                        $q->where('invoice_number', 'like', "%{$search}%")
                            ->orWhere('description', 'like', "%{$search}%")
                            ->orWhereHas('tenant', function ($tenantQuery) use ($search) {
                                $tenantQuery
                                    ->where('first_name', 'like', "%{$search}%")
                                    ->orWhere('last_name', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%")
                                    ->orWhere('phone', 'like', "%{$search}%");
                            })
                            ->orWhereHas('lease', function ($leaseQuery) use ($search) {
                                $leaseQuery->where(
                                    'lease_number',
                                    'like',
                                    "%{$search}%"
                                );
                            })
                            ->orWhereHas('unit', function ($unitQuery) use ($search) {
                                $unitQuery->where(
                                    'unit_number',
                                    'like',
                                    "%{$search}%"
                                );
                            });
                    });
                }
            )
            ->when(
                ! empty($validated['invoice_type']),
                fn ($query) => $query->where(
                    'invoice_type',
                    $validated['invoice_type']
                )
            )
            ->when(
                ! empty($validated['due_from']),
                fn ($query) => $query->whereDate(
                    'due_date',
                    '>=',
                    $validated['due_from']
                )
            )
            ->when(
                ! empty($validated['due_to']),
                fn ($query) => $query->whereDate(
                    'due_date',
                    '<=',
                    $validated['due_to']
                )
            )
            ->when(
                ($validated['status'] ?? null) === 'overdue',
                function ($query) {
                    $query->whereDate('due_date', '<', today())
                        ->where('balance', '>', 0)
                        ->whereNotIn('status', ['paid', 'cancelled']);
                }
            )
            ->when(
                ! empty($validated['status'])
                    && $validated['status'] !== 'overdue',
                fn ($query) => $query->where(
                    'status',
                    $validated['status']
                )
            )
            ->orderByDesc('issue_date')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('property-owner.invoices.index', compact('invoices'));
    }

    public function show(Request $request, RentInvoice $invoice)
    {
        // Resolve the invoice again through the authenticated owner's scope.
        $invoice = $this->ownedInvoicesQuery($request)
            ->whereKey($invoice->id)
            ->with([
                'tenant',
                'lease',
                'unit.managedProperty',
                'allocations.payment.recorder',
                'allocations.allocator',
            ])
            ->firstOrFail();

        return view('property-owner.invoices.show', compact('invoice'));
    }
}