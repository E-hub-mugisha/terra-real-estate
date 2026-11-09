<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LeaseController extends Controller
{
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

    private function findOwnedLease(Request $request, Lease $lease): Lease
    {
        return $this->ownedLeasesQuery($request)
            ->whereKey($lease->id)
            ->firstOrFail();
    }

    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:draft,active,expired,terminated'],
        ]);

        $leases = $this->ownedLeasesQuery($request)
            ->with(['tenant', 'unit.managedProperty', 'unit.building'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->input('search'));

                $query->where(function ($q) use ($search) {
                    $q->where('lease_number', 'like', "%{$search}%")
                        ->orWhereHas('tenant', function ($tenantQuery) use ($search) {
                            $tenantQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        })
                        ->orWhereHas('unit', function ($unitQuery) use ($search) {
                            $unitQuery->where('unit_number', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('status'), fn ($query) =>
                $query->where('status', $request->input('status'))
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('property-owner.leases.index', compact('leases'));
    }

    public function show(Request $request, Lease $lease)
    {
        $lease = $this->findOwnedLease($request, $lease);

        $lease->load([
            'tenant',
            'unit.managedProperty',
            'unit.building',
            'unit.floor',
            'creator',
            'tenantApplication',
        ]);

        return view('property-owner.leases.show', compact('lease'));
    }

    public function edit(Request $request, Lease $lease)
    {
        $lease = $this->findOwnedLease($request, $lease);

        if ($lease->status !== 'draft') {
            return redirect()
                ->route('property-owner.leases.show', $lease)
                ->with('error', 'Only draft leases can be edited.');
        }

        return view('property-owner.leases.edit', compact('lease'));
    }

    public function update(Request $request, Lease $lease)
    {
        $lease = $this->findOwnedLease($request, $lease);

        if ($lease->status !== 'draft') {
            return back()->with('error', 'Only draft leases can be edited.');
        }

        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
            'monthly_rent' => ['required', 'numeric', 'min:0', 'max:9999999999999.99'],
            'security_deposit' => ['required', 'numeric', 'min:0', 'max:9999999999999.99'],
            'rent_due_day' => ['required', 'integer', 'between:1,28'],
            'payment_frequency' => [
                'required',
                'in:monthly,weekly,quarterly,yearly',
            ],
            'currency' => ['required', 'string', 'size:3'],
            'terms' => ['nullable', 'string', 'max:20000'],
        ]);

        $lease->update($validated);

        return redirect()
            ->route('property-owner.leases.show', $lease)
            ->with('success', 'Draft lease updated successfully.');
    }

    public function activate(Request $request, Lease $lease)
    {
        $lease = $this->findOwnedLease($request, $lease);

        DB::transaction(function () use ($lease) {
            $lockedLease = Lease::query()
                ->whereKey($lease->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedLease->status !== 'draft') {
                throw ValidationException::withMessages([
                    'status' => 'Only draft leases can be activated.',
                ]);
            }

            if ($lockedLease->start_date->isFuture()) {
                throw ValidationException::withMessages([
                    'start_date' => 'A lease cannot be activated before its start date.',
                ]);
            }

            if (
                $lockedLease->end_date &&
                $lockedLease->end_date->lt(today())
            ) {
                throw ValidationException::withMessages([
                    'end_date' => 'This lease has already passed its end date.',
                ]);
            }

            $overlap = Lease::query()
                ->where('unit_id', $lockedLease->unit_id)
                ->where('status', 'active')
                ->where('id', '!=', $lockedLease->id)
                ->whereDate('start_date', '<=', $lockedLease->end_date ?? '9999-12-31')
                ->where(function ($query) use ($lockedLease) {
                    $query->whereNull('end_date')
                        ->orWhereDate('end_date', '>=', $lockedLease->start_date);
                })
                ->exists();

            if ($overlap) {
                throw ValidationException::withMessages([
                    'unit' => 'Another active lease overlaps these dates for this unit.',
                ]);
            }

            $lockedLease->update(['status' => 'active']);

            // Only activate a tenant whose application created this lease.
            if ($lockedLease->tenant_application_id) {
                $lockedLease->tenant()->update(['status' => 'active']);
            }
        });

        return back()->with('success', 'Lease activated successfully.');
    }

    public function terminate(Request $request, Lease $lease)
    {
        $lease = $this->findOwnedLease($request, $lease);

        $validated = $request->validate([
            'terminated_at' => ['required', 'date'],
            'termination_reason' => ['required', 'string', 'max:5000'],
        ]);

        if ($lease->status !== 'active') {
            return back()->with('error', 'Only active leases can be terminated.');
        }

        $lease->update([
            'status' => 'terminated',
            'terminated_at' => $validated['terminated_at'],
            'termination_reason' => $validated['termination_reason'],
        ]);

        return back()->with('success', 'Lease terminated successfully.');
    }
}