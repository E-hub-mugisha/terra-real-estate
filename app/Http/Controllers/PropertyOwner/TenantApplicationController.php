<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantApplication;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TenantApplicationController extends Controller
{
    public function index(Request $request)
    {
        $propertyIds = $request->user()
            ->propertyOwner()
            ->firstOrFail()
            ->properties()
            ->select('managed_properties.id');

        $applications = TenantApplication::query()
            ->whereHas('unit', function ($query) use ($propertyIds) {
                $query->whereIn('managed_property_id', $propertyIds);
            })
            ->with(['tenant', 'unit.managedProperty'])
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

        return view('property-owner.tenant-applications.index', compact('applications'));
    }

    public function create()
    {
        $application = new TenantApplication();

        $tenants = Tenant::where('status', 'active')
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $units = Unit::with('managedProperty')
            ->where('status', 'available')
            ->orderBy('unit_number')
            ->get();

        return view(
            'admin.property-management.applications.create',
            compact('application', 'tenants', 'units')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateApplication($request);

        $unit = Unit::findOrFail($validated['unit_id']);

        if ($unit->status !== 'available') {
            throw ValidationException::withMessages([
                'unit_id' => 'This unit is no longer available. Please select another unit.',
            ]);
        }

        $application = DB::transaction(function () use ($validated) {
            $applicationNumber = $this->generateApplicationNumber();

            return TenantApplication::create(array_merge($validated, [
                'application_number' => $applicationNumber,
                'application_date' => $validated['application_date']
                    ?? now()->toDateString(),
                'status' => 'pending',
            ]));
        });

        return redirect()
            ->route('admin.property-management.applications.show', $application)
            ->with('success', 'Tenant application created successfully.');
    }

    public function show(TenantApplication $application)
    {
        $application->load([
            'tenant',
            'unit.managedProperty.owner.user',
            'unit.building',
            'unit.floor',
            'reviewer',
        ]);

        return view(
            'admin.property-management.applications.show',
            compact('application')
        );
    }

    public function edit(TenantApplication $application)
    {
        if ($application->status !== 'pending') {
            return redirect()
                ->route('admin.property-management.applications.show', $application)
                ->with('error', 'Only pending applications can be edited.');
        }

        $tenants = Tenant::where('status', 'active')
            ->orWhere('id', $application->tenant_id)
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->get();

        $units = Unit::with('managedProperty')
            ->where(function ($query) use ($application) {
                $query->where('status', 'available')
                    ->orWhere('id', $application->unit_id);
            })
            ->orderBy('unit_number')
            ->get();

        return view(
            'admin.property-management.applications.edit',
            compact('application', 'tenants', 'units')
        );
    }

    public function update(Request $request, TenantApplication $application)
    {
        if ($application->status !== 'pending') {
            return redirect()
                ->route('admin.property-management.applications.show', $application)
                ->with('error', 'Only pending applications can be edited.');
        }

        $validated = $this->validateApplication($request, $application);

        $unit = Unit::findOrFail($validated['unit_id']);

        if (
            $unit->status !== 'available' &&
            (int) $unit->id !== (int) $application->unit_id
        ) {
            throw ValidationException::withMessages([
                'unit_id' => 'This unit is no longer available. Please select another unit.',
            ]);
        }

        $application->update($validated);

        return redirect()
            ->route('admin.property-management.applications.show', $application)
            ->with('success', 'Tenant application updated successfully.');
    }

    public function approve(Request $request, TenantApplication $application)
    {
        $validated = $request->validate([
            'decision_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        DB::transaction(function () use ($application, $validated) {
            $lockedApplication = TenantApplication::whereKey($application->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedApplication->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Only pending applications can be approved.',
                ]);
            }

            $unit = Unit::whereKey($lockedApplication->unit_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($unit->status !== 'available') {
                throw ValidationException::withMessages([
                    'unit_id' => 'This unit is no longer available. The application has not been approved.',
                ]);
            }

            $lockedApplication->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'decision_notes' => $validated['decision_notes'] ?? null,
            ]);

            // Reserve the unit until the lease is created.
            $unit->update(['status' => 'reserved']);
        });

        return redirect()
            ->route('admin.property-management.applications.show', $application)
            ->with('success', 'Application approved and unit reserved.');
    }

    public function reject(Request $request, TenantApplication $application)
    {
        $validated = $request->validate([
            'decision_notes' => ['required', 'string', 'max:5000'],
        ]);

        if ($application->status !== 'pending') {
            return redirect()
                ->route('admin.property-management.applications.show', $application)
                ->with('error', 'Only pending applications can be rejected.');
        }

        $application->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'decision_notes' => $validated['decision_notes'],
        ]);

        return redirect()
            ->route('admin.property-management.applications.show', $application)
            ->with('success', 'Application rejected.');
    }

    public function destroy(TenantApplication $application)
    {
        if ($application->status === 'approved') {
            return redirect()
                ->route('admin.property-management.applications.show', $application)
                ->with('error', 'Approved applications cannot be deleted. Keep them for your records.');
        }

        $application->delete();

        return redirect()
            ->route('admin.property-management.applications.index')
            ->with('success', 'Application deleted successfully.');
    }

    private function validateApplication(
        Request $request,
        ?TenantApplication $application = null
    ): array {
        return $request->validate([
            'tenant_id' => [
                'required',
                'integer',
                Rule::exists('tenants', 'id'),
            ],

            'unit_id' => [
                'required',
                'integer',
                Rule::exists('units', 'id'),
            ],

            'application_date' => ['nullable', 'date'],
            'desired_move_in_date' => ['required', 'date'],
            'number_of_occupants' => ['required', 'integer', 'min:1', 'max:100'],

            'offered_monthly_rent' => [
                'required',
                'numeric',
                'min:0',
                'max:999999999999.99',
            ],

            'currency' => ['required', Rule::in(['RWF', 'USD'])],

            'employment_status' => [
                'nullable',
                'string',
                'max:100',
            ],

            'additional_information' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);
    }

    private function generateApplicationNumber(): string
    {
        do {
            $number = 'APP-' . now()->format('Ymd') . '-'
                . strtoupper(bin2hex(random_bytes(3)));
        } while (
            TenantApplication::where('application_number', $number)->exists()
        );

        return $number;
    }
}
