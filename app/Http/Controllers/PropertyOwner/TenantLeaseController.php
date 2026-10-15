<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TenantLeaseController extends Controller
{
    public function index(Request $request)
    {
        $leases = Lease::with([
            'tenant',
            'unit.managedProperty',
        ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->search);

                $query->where(function ($q) use ($search) {
                    $q->where('lease_number', 'like', "%{$search}%")
                        ->orWhereHas('tenant', function ($tenantQuery) use ($search) {
                            $tenantQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('unit', function ($unitQuery) use ($search) {
                            $unitQuery->where('unit_number', 'like', "%{$search}%")
                                ->orWhereHas('managedProperty', function ($propertyQuery) use ($search) {
                                    $propertyQuery->where('name', 'like', "%{$search}%");
                                });
                        });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.property-management.leases.index', compact('leases'));
    }

    public function create()
    {
        $lease = new Lease([
            'currency' => 'RWF',
            'payment_frequency' => 'monthly',
            'rent_due_day' => 1,
            'security_deposit' => 0,
        ]);

        $tenants = Tenant::where('status', 'active')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        // New leases may use available units or units reserved
        // for an approved application.
        $units = Unit::with('managedProperty')
            ->whereIn('status', ['available', 'reserved'])
            ->orderBy('unit_number')
            ->get();

        return view(
            'admin.property-management.leases.create',
            compact('lease', 'tenants', 'units')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateLease($request);

        $lease = DB::transaction(function () use ($validated) {
            $unit = Unit::whereKey($validated['unit_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($unit->status, ['available', 'reserved'], true)) {
                throw ValidationException::withMessages([
                    'unit_id' => 'This unit is no longer available for a new lease.',
                ]);
            }

            $validated['lease_number'] = $this->generateLeaseNumber();
            $validated['created_by'] = auth()->id();
            $validated['status'] = 'draft';
            $validated['currency'] = $validated['currency'] ?? 'RWF';
            $validated['payment_frequency'] =
                $validated['payment_frequency'] ?? 'monthly';

            return Lease::create($validated);
        });

        return redirect()
            ->route('admin.property-management.leases.show', $lease)
            ->with('success', 'Lease created successfully.');
    }

    public function show(Lease $lease)
    {
        $lease->load([
            'tenant',
            'unit.managedProperty.owner.user',
            'unit.building',
            'unit.floor',
            'creator',
            'rentPayments' => fn ($query) => $query->latest('payment_date'),
        ]);

        return view('admin.property-management.leases.show', compact('lease'));
    }

    public function edit(Lease $lease)
    {
        if ($lease->status !== 'draft') {
            return redirect()
                ->route('admin.property-management.leases.show', $lease)
                ->with('error', 'Only draft leases can be edited.');
        }

        $tenants = Tenant::where('status', 'active')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $units = Unit::with('managedProperty')
            ->where(function ($query) use ($lease) {
                $query->whereIn('status', ['available', 'reserved'])
                    ->orWhere('id', $lease->unit_id);
            })
            ->orderBy('unit_number')
            ->get();

        return view(
            'admin.property-management.leases.edit',
            compact('lease', 'tenants', 'units')
        );
    }

    public function update(Request $request, Lease $lease)
    {
        if ($lease->status !== 'draft') {
            return redirect()
                ->route('admin.property-management.leases.show', $lease)
                ->with('error', 'Only draft leases can be edited.');
        }

        $validated = $this->validateLease($request, $lease);

        DB::transaction(function () use ($validated, $lease) {
            // Lock the selected unit to reduce concurrent allocation issues.
            $unit = Unit::whereKey($validated['unit_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if (
                ! in_array($unit->status, ['available', 'reserved'], true)
                && $unit->id !== $lease->unit_id
            ) {
                throw ValidationException::withMessages([
                    'unit_id' => 'The selected unit is not available.',
                ]);
            }

            unset($validated['lease_number']);

            $lease->update($validated);
        });

        return redirect()
            ->route('admin.property-management.leases.show', $lease)
            ->with('success', 'Lease updated successfully.');
    }

    public function activate(Lease $lease)
    {
        DB::transaction(function () use ($lease) {
            $lockedLease = Lease::whereKey($lease->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedLease->status !== 'draft') {
                throw ValidationException::withMessages([
                    'lease' => 'Only draft leases can be activated.',
                ]);
            }

            $unit = Unit::whereKey($lockedLease->unit_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($unit->status, ['available', 'reserved'], true)) {
                throw ValidationException::withMessages([
                    'lease' => 'The selected unit is not available for activation.',
                ]);
            }

            $overlap = Lease::where('unit_id', $unit->id)
                ->where('status', 'active')
                ->whereDate('start_date', '<=', $lockedLease->end_date)
                ->whereDate('end_date', '>=', $lockedLease->start_date)
                ->exists();

            if ($overlap) {
                throw ValidationException::withMessages([
                    'lease' => 'Another active lease overlaps these dates for this unit.',
                ]);
            }

            $lockedLease->update(['status' => 'active']);
            $unit->update(['status' => 'occupied']);
        });

        return redirect()
            ->route('admin.property-management.leases.show', $lease)
            ->with('success', 'Lease activated and unit marked as occupied.');
    }

    public function terminate(Request $request, Lease $lease)
    {
        $validated = $request->validate([
            'termination_reason' => ['required', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($lease, $validated) {
            $lockedLease = Lease::whereKey($lease->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedLease->status !== 'active') {
                throw ValidationException::withMessages([
                    'lease' => 'Only active leases can be terminated.',
                ]);
            }

            $unit = Unit::whereKey($lockedLease->unit_id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedLease->update([
                'status' => 'terminated',
                'terminated_at' => now(),
                'termination_reason' => $validated['termination_reason'],
            ]);

            $anotherActiveLease = Lease::where('unit_id', $unit->id)
                ->where('status', 'active')
                ->whereDate('start_date', '<=', $lockedLease->end_date)
                ->whereDate('end_date', '>=', $lockedLease->start_date)
                ->exists();

            if (! $anotherActiveLease) {
                $unit->update(['status' => 'available']);
            }
        });

        return redirect()
            ->route('admin.property-management.leases.show', $lease)
            ->with('success', 'Lease terminated successfully.');
    }

    public function destroy(Lease $lease)
    {
        if ($lease->status !== 'draft') {
            return redirect()
                ->route('admin.property-management.leases.show', $lease)
                ->with('error', 'Only draft leases can be deleted.');
        }

        if ($lease->rentPayments()->exists()) {
            return redirect()
                ->route('admin.property-management.leases.show', $lease)
                ->with('error', 'This lease has payment records and cannot be deleted.');
        }

        $lease->delete();

        return redirect()
            ->route('admin.property-management.leases.index')
            ->with('success', 'Draft lease deleted successfully.');
    }

    private function validateLease(
        Request $request,
        ?Lease $lease = null
    ): array {
        return $request->validate([
            'tenant_id' => [
                'required',
                'integer',
                Rule::exists('tenants', 'id')->where('status', 'active'),
            ],
            'unit_id' => ['required', 'integer', 'exists:units,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'monthly_rent' => ['required', 'numeric', 'min:0', 'max:999999999999.99'],
            'security_deposit' => ['nullable', 'numeric', 'min:0', 'max:999999999999.99'],
            'rent_due_day' => ['required', 'integer', 'between:1,31'],
            'currency' => ['required', Rule::in(['RWF', 'USD'])],
            'payment_frequency' => [
                'required',
                Rule::in(['monthly', 'quarterly', 'annually', 'weekly']),
            ],
            'terms' => ['nullable', 'string', 'max:10000'],
        ]);
    }

    private function generateLeaseNumber(): string
    {
        do {
            $number = 'LSE-' . now()->format('Ymd') . '-'
                . strtoupper(bin2hex(random_bytes(3)));
        } while (Lease::where('lease_number', $number)->exists());

        return $number;
    }
}