<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use App\Models\ManagedProperty;
use App\Models\Tenant;
use App\Models\TenantApplication;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    private function ownerProperties(Request $request)
    {
        return $request->user()
            ->propertyOwner()
            ->firstOrFail()
            ->properties();
    }

    private function ownedTenantQuery(Request $request)
    {
        $propertyIds = $this->ownerProperties($request)
            ->select('managed_properties.id');

        return Tenant::query()
            ->where(function ($query) use ($propertyIds) {
                $query->whereHas('applications.unit', function ($unitQuery) use ($propertyIds) {
                    $unitQuery->whereIn('managed_property_id', $propertyIds);
                })->orWhereHas('leases.unit', function ($unitQuery) use ($propertyIds) {
                    $unitQuery->whereIn('managed_property_id', $propertyIds);
                });
            });
    }

    private function ownedTenant(Request $request, Tenant $tenant): Tenant
    {
        return $this->ownedTenantQuery($request)
            ->whereKey($tenant->id)
            ->firstOrFail();
    }

    private function ownedUnit(Request $request, int $unitId): Unit
    {
        $propertyIds = $this->ownerProperties($request)
            ->select('managed_properties.id');

        return Unit::query()
            ->whereIn('managed_property_id', $propertyIds)
            ->whereKey($unitId)
            ->firstOrFail();
    }

    public function index(Request $request)
    {
        $tenants = $this->ownedTenantQuery($request)
            ->withCount('applications', 'leases')
            ->with('user')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = trim($request->input('search'));

                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('tenant_code', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->orderBy('first_name')
            ->paginate(15)
            ->withQueryString();

        return view('property-owner.tenants.index', compact('tenants'));
    }

    public function create(Request $request)
    {
        $propertyIds = $this->ownerProperties($request)
            ->select('managed_properties.id');

        $units = Unit::query()
            ->with(['managedProperty', 'building', 'floor'])
            ->whereIn('managed_property_id', $propertyIds)
            ->orderBy('unit_number')
            ->get();

        return view('property-owner.tenants.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => ['required', 'integer'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'alternative_phone' => ['nullable', 'string', 'max:30'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'max:30'],
            'occupation' => ['nullable', 'string', 'max:150'],
            'employer' => ['nullable', 'string', 'max:150'],
            'emergency_contact_name' => ['nullable', 'string', 'max:150'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'],
            'desired_move_in_date' => ['nullable', 'date'],
            'number_of_occupants' => ['required', 'integer', 'min:1', 'max:100'],
            'additional_information' => ['nullable', 'string', 'max:3000'],
            'notes' => ['nullable', 'string', 'max:3000'],
        ]);

        // Never trust a unit ID submitted by the browser.
        $unit = $this->ownedUnit($request, (int) $validated['unit_id']);

        $tenant = DB::transaction(function () use ($validated, $unit) {
            $tenant = Tenant::create([
                'tenant_code' => $this->generateTenantCode(),
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'alternative_phone' => $validated['alternative_phone'] ?? null,
                'national_id' => $validated['national_id'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'occupation' => $validated['occupation'] ?? null,
                'employer' => $validated['employer'] ?? null,
                'emergency_contact_name' => $validated['emergency_contact_name'] ?? null,
                'emergency_contact_phone' => $validated['emergency_contact_phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            TenantApplication::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $unit->id,
                'application_number' => $this->generateApplicationNumber(),
                'application_date' => now()->toDateString(),
                'desired_move_in_date' => $validated['desired_move_in_date'] ?? null,
                'number_of_occupants' => $validated['number_of_occupants'],
                'offered_monthly_rent' => $unit->monthly_rent,
                'currency' => $unit->currency ?: 'RWF',
                'employment_status' => null,
                'additional_information' => $validated['additional_information'] ?? null,
                'status' => 'pending',
            ]);

            return $tenant;
        });

        return redirect()
            ->route('property-owner.tenants.show', $tenant)
            ->with('success', 'Tenant registered and application created successfully.');
    }

    public function show(Request $request, Tenant $tenant)
    {
        $tenant = $this->ownedTenant($request, $tenant);

        $tenant->load([
            'applications.unit.managedProperty',
            'applications.unit.building',
            'applications.unit.floor',
            'applications.reviewer',
            'leases.unit.managedProperty',
            'leases.unit.building',
            'leases.unit.floor',
        ]);

        return view('property-owner.tenants.show', compact('tenant'));
    }

    public function edit(Request $request, Tenant $tenant)
    {
        $tenant = $this->ownedTenant($request, $tenant);

        return view('property-owner.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $tenant = $this->ownedTenant($request, $tenant);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('tenants', 'email')->ignore($tenant->id),
            ],
            'phone' => ['required', 'string', 'max:30'],
            'alternative_phone' => ['nullable', 'string', 'max:30'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'max:30'],
            'occupation' => ['nullable', 'string', 'max:150'],
            'employer' => ['nullable', 'string', 'max:150'],
            'emergency_contact_name' => ['nullable', 'string', 'max:150'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', Rule::in(['pending', 'active', 'inactive'])],
            'notes' => ['nullable', 'string', 'max:3000'],
        ]);

        $tenant->update($validated);

        return redirect()
            ->route('property-owner.tenants.show', $tenant)
            ->with('success', 'Tenant details updated successfully.');
    }

    private function generateTenantCode(): string
    {
        do {
            $code = 'TEN-' . Str::upper(Str::random(8));
        } while (Tenant::where('tenant_code', $code)->exists());

        return $code;
    }

    private function generateApplicationNumber(): string
    {
        do {
            $number = 'APP-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (TenantApplication::where('application_number', $number)->exists());

        return $number;
    }
}