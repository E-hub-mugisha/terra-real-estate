<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\TenantApplication;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TenantApplicationController extends Controller
{
    /**
     * Applications belonging to the authenticated property owner.
     */
    private function applicationsQuery(Request $request)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $propertyIds = $owner->properties()
            ->select('managed_properties.id');

        return TenantApplication::query()
            ->whereHas('unit', function ($query) use ($propertyIds) {
                $query->whereIn('managed_property_id', $propertyIds);
            });
    }

    /**
     * Application listing.
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => [
                'nullable',
                Rule::in([
                    'pending',
                    'under_review',
                    'approved',
                    'rejected',
                    'withdrawn',
                ]),
            ],
        ]);

        $applications = $this->applicationsQuery($request)
            ->with([
                'tenant',
                'unit.managedProperty',
                'unit.building',
            ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->input('search'));

                $query->where(function ($q) use ($search) {
                    $q->where('application_number', 'like', "%{$search}%")
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
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->latest('application_date')
            ->paginate(15)
            ->withQueryString();

        return view(
            'property-owner.tenant-applications.index',
            compact('applications')
        );
    }

    /**
     * Application details.
     */
    public function show(Request $request, TenantApplication $application)
    {
        $application = $this->findOwnedApplication($request, $application);

        $application->load([
            'tenant.user',
            'unit.managedProperty',
            'unit.building',
            'unit.floor',
            'reviewer',
        ]);

        $lease = Lease::query()
            ->where('tenant_application_id', $application->id)
            ->first();

        return view(
            'property-owner.tenant-applications.show',
            compact('application', 'lease')
        );
    }

    /**
     * Mark an application as under review.
     */
    public function review(Request $request, TenantApplication $application)
    {
        $application = $this->findOwnedApplication($request, $application);

        if (! in_array($application->status, ['pending', 'under_review'], true)) {
            return back()->with(
                'error',
                'Only pending applications can be reviewed.'
            );
        }

        $application->update([
            'status' => 'under_review',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Application marked as under review.');
    }

    /**
     * Approve an application.
     */
    public function approve(Request $request, TenantApplication $application)
    {
        $application = $this->findOwnedApplication($request, $application);

        $validated = $request->validate([
            'decision_notes' => ['nullable', 'string', 'max:2000'],
        ]);

        if (! in_array($application->status, ['pending', 'under_review'], true)) {
            return back()->with(
                'error',
                'This application can no longer be approved.'
            );
        }

        DB::transaction(function () use ($request, $application, $validated) {
            $application = TenantApplication::query()
                ->whereKey($application->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array($application->status, ['pending', 'under_review'], true)) {
                throw ValidationException::withMessages([
                    'status' => 'This application has already been processed.',
                ]);
            }

            $application->update([
                'status' => 'approved',
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
                'decision_notes' => $validated['decision_notes'] ?? null,
            ]);

            $application->tenant()->update([
                'status' => 'active',
            ]);
        });

        return back()->with(
            'success',
            'Application approved. You can now create the lease.'
        );
    }

    /**
     * Reject an application.
     */
    public function reject(Request $request, TenantApplication $application)
    {
        $application = $this->findOwnedApplication($request, $application);

        $validated = $request->validate([
            'decision_notes' => ['required', 'string', 'max:2000'],
        ]);

        if (! in_array($application->status, ['pending', 'under_review'], true)) {
            return back()->with(
                'error',
                'Only pending or under-review applications can be rejected.'
            );
        }

        $application->update([
            'status' => 'rejected',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'decision_notes' => $validated['decision_notes'],
        ]);

        return back()->with('success', 'Application rejected.');
    }

    /**
     * Convert an approved application into a lease.
     */
    public function convertToLease(
        Request $request,
        TenantApplication $application
    ) {
        $application = $this->findOwnedApplication($request, $application);

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
            'terms' => ['nullable', 'string', 'max:20000'],
        ]);

        $lease = DB::transaction(function () use (
            $request,
            $application,
            $validated
        ) {
            $lockedApplication = TenantApplication::query()
                ->whereKey($application->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedApplication->status !== 'approved') {
                throw ValidationException::withMessages([
                    'application' => 'Only approved applications can be converted into leases.',
                ]);
            }

            if (Lease::where('tenant_application_id', $lockedApplication->id)->exists()) {
                throw ValidationException::withMessages([
                    'application' => 'A lease already exists for this application.',
                ]);
            }

            $unit = Unit::query()
                ->whereKey($lockedApplication->unit_id)
                ->lockForUpdate()
                ->firstOrFail();

            $startDate = $validated['start_date'];
            $endDate = $validated['end_date'] ?? null;

            // Reject overlapping leases that are already active.
            $overlappingActiveLease = Lease::query()
                ->where('unit_id', $unit->id)
                ->where('status', 'active')
                ->whereDate('start_date', '<=', $endDate ?? '9999-12-31')
                ->where(function ($query) use ($startDate) {
                    $query->whereNull('end_date')
                        ->orWhereDate('end_date', '>=', $startDate);
                })
                ->exists();

            if ($overlappingActiveLease) {
                throw ValidationException::withMessages([
                    'unit' => 'This unit already has an active lease that overlaps the requested dates.',
                ]);
            }

            return Lease::create([
                'tenant_application_id' => $lockedApplication->id,
                'tenant_id' => $lockedApplication->tenant_id,
                'unit_id' => $lockedApplication->unit_id,
                'created_by' => $request->user()->id,
                'lease_number' => 'LSE-' . now()->format('Ymd') . '-'
                    . Str::upper(Str::random(6)),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'monthly_rent' => $validated['monthly_rent'],
                'security_deposit' => $validated['security_deposit'],
                'rent_due_day' => $validated['rent_due_day'],
                'currency' => $lockedApplication->currency ?: 'RWF',
                'payment_frequency' => $validated['payment_frequency'],
                'status' => 'draft',
                'terms' => $validated['terms'] ?? null,
            ]);
        });

        return redirect()
            ->route('property-owner.leases.show', $lease)
            ->with('success', 'Draft lease created. Review the terms before activating it.');
    }

    /**
     * Resolve an application only if it belongs to this owner.
     */
    private function findOwnedApplication(
        Request $request,
        TenantApplication $application
    ): TenantApplication {
        return $this->applicationsQuery($request)
            ->whereKey($application->id)
            ->firstOrFail();
    }
}
