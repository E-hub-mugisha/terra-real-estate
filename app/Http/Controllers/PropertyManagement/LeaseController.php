<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\TenantApplication;
use App\Models\Unit;
use App\Services\RentInvoiceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LeaseController extends Controller
{
    /**
     * Display leases.
     */
    public function index(Request $request)
    {
        $query = Lease::with([
            'tenant',
            'unit.floor.building.property',
            'application',
        ])->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('lease_number', 'like', "%{$search}%")

                    ->orWhereHas('tenant', function ($tenant) use ($search) {

                        $tenant
                            ->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    })

                    ->orWhereHas('unit', function ($unit) use ($search) {

                        $unit->where(
                            'unit_number',
                            'like',
                            "%{$search}%"
                        );
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $leases = $query
            ->paginate(15)
            ->withQueryString();

        return view(
            'property-management.leases.index',
            compact('leases')
        );
    }

    /**
     * Show lease creation form.
     */
    public function create(Request $request)
    {
        $application = null;

        if ($request->filled('application')) {

            $application = TenantApplication::with([
                'tenant',
                'unit.floor.building.property',
                'lease',
            ])->findOrFail(
                $request->application
            );

            if ($application->status !== 'approved') {
                return redirect()
                    ->route(
                        'property-management.applications.show',
                        $application
                    )
                    ->with(
                        'error',
                        'Only approved applications can create a lease.'
                    );
            }

            if ($application->lease) {
                return redirect()
                    ->route(
                        'property-management.leases.show',
                        $application->lease
                    )
                    ->with(
                        'error',
                        'A lease already exists for this application.'
                    );
            }
        }

        $tenants = Tenant::where('status', 'active')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $units = Unit::with([
            'floor.building.property',
        ])
            ->where('occupancy_status', 'vacant')
            ->where('availability', 'available')
            ->orderBy('unit_number')
            ->get();

        return view(
            'property-management.leases.create',
            compact(
                'application',
                'tenants',
                'units'
            )
        );
    }

    /**
     * Store lease.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => [
                'required',
                'exists:tenants,id',
            ],

            'unit_id' => [
                'required',
                'exists:units,id',
            ],

            'tenant_application_id' => [
                'nullable',
                'exists:tenant_applications,id',
            ],

            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'required',
                'date',
                'after:start_date',
            ],

            'monthly_rent' => [
                'required',
                'numeric',
                'min:0',
            ],

            'deposit_amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'payment_frequency' => [
                'required',
                Rule::in([
                    'monthly',
                    'quarterly',
                    'semi_annually',
                    'annually',
                ]),
            ],

            'terms' => [
                'nullable',
                'string',
            ],

            'special_conditions' => [
                'nullable',
                'string',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            $unit = Unit::lockForUpdate()
                ->findOrFail($validated['unit_id']);

            if (
                $unit->occupancy_status !== 'vacant' ||
                $unit->availability !== 'available'
            ) {
                abort(
                    422,
                    'The selected unit is no longer available.'
                );
            }

            $activeLeaseExists = Lease::where(
                'unit_id',
                $unit->id
            )
                ->whereIn('status', [
                    'pending_signature',
                    'active',
                ])
                ->exists();

            if ($activeLeaseExists) {
                abort(
                    422,
                    'This unit already has an active or pending lease.'
                );
            }

            $application = null;

            if (!empty($validated['tenant_application_id'])) {

                $application = TenantApplication::findOrFail(
                    $validated['tenant_application_id']
                );

                if ($application->status !== 'approved') {
                    abort(
                        422,
                        'The tenant application must be approved before creating a lease.'
                    );
                }

                if (
                    $application->tenant_id != $validated['tenant_id'] ||
                    $application->unit_id != $validated['unit_id']
                ) {
                    abort(
                        422,
                        'The selected tenant and unit do not match the approved application.'
                    );
                }
            }

            $lease = Lease::create([
                ...$validated,

                'lease_number' => $this->generateLeaseNumber(),

                'status' => 'draft',
            ]);
        });

        return redirect()
            ->route('property-management.leases.index')
            ->with(
                'success',
                'Lease created successfully.'
            );
    }

    /**
     * Show lease.
     */

    public function show(Lease $lease)
    {
        $lease->load([
            'tenant',
            'unit.floor.building.property',
            'application',
            'signer',
            'invoices' => function ($query) {
                $query->orderByDesc('issue_date');
            },
            'ledgerEntries' => function ($query) {
                $query->orderByDesc('entry_date')
                    ->orderByDesc('id');
            },
            'payments' => function ($query) {
                $query->orderByDesc('payment_date');
            },
        ]);

        return view(
            'property-management.leases.show',
            compact('lease')
        );
    }

    /**
     * Edit lease.
     */
    public function edit(Lease $lease)
    {
        if (
            in_array(
                $lease->status,
                ['active', 'terminated', 'expired']
            )
        ) {
            return back()->with(
                'error',
                'An active or completed lease cannot be edited.'
            );
        }

        return view(
            'property-management.leases.edit',
            compact('lease')
        );
    }

    /**
     * Update lease.
     */
    public function update(
        Request $request,
        Lease $lease
    ) {
        if (
            in_array(
                $lease->status,
                ['active', 'terminated', 'expired']
            )
        ) {
            return back()->with(
                'error',
                'An active or completed lease cannot be modified.'
            );
        }

        $validated = $request->validate([
            'start_date' => [
                'required',
                'date',
            ],

            'end_date' => [
                'required',
                'date',
                'after:start_date',
            ],

            'monthly_rent' => [
                'required',
                'numeric',
                'min:0',
            ],

            'deposit_amount' => [
                'required',
                'numeric',
                'min:0',
            ],

            'payment_frequency' => [
                'required',
                Rule::in([
                    'monthly',
                    'quarterly',
                    'semi_annually',
                    'annually',
                ]),
            ],

            'terms' => [
                'nullable',
                'string',
            ],

            'special_conditions' => [
                'nullable',
                'string',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $lease->update($validated);

        return redirect()
            ->route(
                'property-management.leases.show',
                $lease
            )
            ->with(
                'success',
                'Lease updated successfully.'
            );
    }

    /**
     * Send lease for signing.
     */
    public function sendForSignature(Lease $lease)
    {
        if ($lease->status !== 'draft') {
            return back()->with(
                'error',
                'Only draft leases can be sent for signature.'
            );
        }

        $lease->update([
            'status' => 'pending_signature',
        ]);

        return back()->with(
            'success',
            'Lease has been sent for signature.'
        );
    }

    /**
     * Sign / activate lease.
     */

    /**
     * Sign / activate lease and generate initial invoices.
     */
    public function activate(
        Lease $lease,
        RentInvoiceService $invoiceService
    ) {
        if ($lease->status !== 'pending_signature') {
            return back()->with(
                'error',
                'Only leases pending signature can be activated.'
            );
        }

        DB::transaction(function () use ($lease, $invoiceService) {
            $lease = Lease::whereKey($lease->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lease->status !== 'pending_signature') {
                abort(422, 'This lease is no longer pending signature.');
            }

            $unit = Unit::lockForUpdate()
                ->findOrFail($lease->unit_id);

            $activeLeaseExists = Lease::where('unit_id', $unit->id)
                ->where('id', '!=', $lease->id)
                ->where('status', 'active')
                ->exists();

            if ($activeLeaseExists) {
                abort(422, 'This unit already has an active lease.');
            }

            $lease->update([
                'status' => 'active',
                'signed_at' => now(),
                'signed_by' => Auth::id(),
            ]);

            $unit->update([
                'occupancy_status' => 'occupied',
                'availability' => 'unavailable',
            ]);

            // Generate the initial rent invoice and any required deposit invoice.
            $invoiceService->generateInitialInvoices($lease);
        });

        return back()->with(
            'success',
            'Lease signed and activated successfully. Initial invoices have been generated.'
        );
    }

    /**
     * Terminate lease.
     */
    public function terminate(
        Request $request,
        Lease $lease
    ) {
        $validated = $request->validate([
            'termination_reason' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        if ($lease->status !== 'active') {
            return back()->with(
                'error',
                'Only active leases can be terminated.'
            );
        }

        DB::transaction(function () use (
            $lease,
            $validated
        ) {

            $lease->update([
                'status' => 'terminated',
                'terminated_at' => now(),
                'termination_reason' =>
                $validated['termination_reason'],
            ]);

            $unit = Unit::lockForUpdate()
                ->findOrFail($lease->unit_id);

            $unit->update([
                'occupancy_status' => 'vacant',
                'availability' => 'available',
            ]);
        });

        return back()->with(
            'success',
            'Lease terminated successfully and the unit is now vacant.'
        );
    }

    /**
     * Delete draft lease.
     */
    public function destroy(Lease $lease)
    {
        if (
            !in_array(
                $lease->status,
                ['draft', 'cancelled']
            )
        ) {
            return back()->with(
                'error',
                'Only draft or cancelled leases can be deleted.'
            );
        }

        $lease->delete();

        return redirect()
            ->route('property-management.leases.index')
            ->with(
                'success',
                'Lease deleted successfully.'
            );
    }

    private function generateLeaseNumber(): string
    {
        do {
            $number = 'TRR-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(
                    substr(
                        str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'),
                        0,
                        6
                    )
                );
        } while (
            Lease::where(
                'lease_number',
                $number
            )->exists()
        );

        return $number;
    }
}
