<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $tenants = Tenant::with('user')
            ->withCount(['applications', 'leases'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('tenant_code', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.property-management.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $tenant = new Tenant();

        $users = User::whereDoesntHave('tenantProfile')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.property-management.tenants.create', compact(
            'tenant',
            'users'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateTenant($request);

        // Generate a unique tenant reference automatically.
        do {
            $tenantCode = 'TEN-' . Str::upper(Str::random(8));
        } while (Tenant::where('tenant_code', $tenantCode)->exists());

        $validated['tenant_code'] = $tenantCode;

        $tenant = Tenant::create($validated);

        return redirect()
            ->route('admin.property-management.tenants.show', $tenant)
            ->with('success', 'Tenant registered successfully.');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load([
            'user',
            'applications.unit.managedProperty',
            'leases.unit.managedProperty',
        ]);

        return view('admin.property-management.tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        $users = User::whereDoesntHave('tenantProfile')
            ->orWhere('id', $tenant->user_id)
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.property-management.tenants.edit', compact(
            'tenant',
            'users'
        ));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $this->validateTenant($request, $tenant);

        // Keep the existing tenant reference unchanged.
        unset($validated['tenant_code']);

        $tenant->update($validated);

        return redirect()
            ->route('admin.property-management.tenants.show', $tenant)
            ->with('success', 'Tenant details updated successfully.');
    }

    public function destroy(Tenant $tenant)
    {
        if (
            $tenant->applications()->exists() ||
            $tenant->leases()->exists() ||
            $tenant->maintenanceRequests()->exists()
        ) {
            return redirect()
                ->route('admin.property-management.tenants.show', $tenant)
                ->with(
                    'error',
                    'This tenant cannot be deleted because applications, leases, or maintenance records are linked to the profile.'
                );
        }

        $tenant->delete();

        return redirect()
            ->route('admin.property-management.tenants.index')
            ->with('success', 'Tenant deleted successfully.');
    }

    private function validateTenant(
        Request $request,
        ?Tenant $tenant = null
    ): array {
        return $request->validate([
            'user_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id'),
                Rule::unique('tenants', 'user_id')->ignore($tenant?->id),
            ],

            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'alternate_phone' => ['nullable', 'string', 'max:30'],

            'national_id' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('tenants', 'national_id')->ignore($tenant?->id),
            ],

            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => [
                'nullable',
                Rule::in(['male', 'female', 'other', 'prefer_not_to_say']),
            ],

            'occupation' => ['nullable', 'string', 'max:150'],
            'employer' => ['nullable', 'string', 'max:150'],

            'emergency_contact_name' => ['nullable', 'string', 'max:150'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:30'],

            'address' => ['nullable', 'string', 'max:1000'],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],

            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }
}
