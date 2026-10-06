<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TenantController extends Controller
{
    /**
     * Display tenants.
     */
    public function index(Request $request)
    {
        $query = Tenant::query()
            ->with('user')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('national_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kyc_status')) {
            $query->where(
                'kyc_status',
                $request->kyc_status
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $tenants = $query->paginate(15)->withQueryString();

        return view(
            'property-management.tenants.index',
            compact('tenants')
        );
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view(
            'property-management.tenants.create'
        );
    }

    /**
     * Store tenant.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'national_id' => [
                'nullable',
                'string',
                'max:100',
                'unique:tenants,national_id',
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'nullable',
                'string',
                'max:50',
            ],

            'district' => [
                'nullable',
                'string',
                'max:100',
            ],

            'sector' => [
                'nullable',
                'string',
                'max:100',
            ],

            'cell' => [
                'nullable',
                'string',
                'max:100',
            ],

            'village' => [
                'nullable',
                'string',
                'max:100',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'emergency_contact_name' => [
                'nullable',
                'string',
                'max:150',
            ],

            'emergency_contact_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'emergency_contact_relationship' => [
                'nullable',
                'string',
                'max:100',
            ],

            'kyc_status' => [
                'required',
                Rule::in([
                    'pending',
                    'verified',
                    'rejected',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'blacklisted',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        Tenant::create($validated);

        return redirect()
            ->route('property-management.tenants.index')
            ->with(
                'success',
                'Tenant registered successfully.'
            );
    }

    /**
     * Display tenant.
     */
    public function show(Tenant $tenant)
    {
        $tenant->load([
            'user',
            'leases',
        ]);

        return view(
            'property-management.tenants.show',
            compact('tenant')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(Tenant $tenant)
    {
        return view(
            'property-management.tenants.edit',
            compact('tenant')
        );
    }

    /**
     * Update tenant.
     */
    public function update(
        Request $request,
        Tenant $tenant
    ) {
        $validated = $request->validate([
            'first_name' => [
                'required',
                'string',
                'max:100',
            ],

            'last_name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:30',
            ],

            'national_id' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('tenants', 'national_id')
                    ->ignore($tenant->id),
            ],

            'date_of_birth' => [
                'nullable',
                'date',
            ],

            'gender' => [
                'nullable',
                'string',
                'max:50',
            ],

            'district' => [
                'nullable',
                'string',
                'max:100',
            ],

            'sector' => [
                'nullable',
                'string',
                'max:100',
            ],

            'cell' => [
                'nullable',
                'string',
                'max:100',
            ],

            'village' => [
                'nullable',
                'string',
                'max:100',
            ],

            'address' => [
                'nullable',
                'string',
            ],

            'emergency_contact_name' => [
                'nullable',
                'string',
                'max:150',
            ],

            'emergency_contact_phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'emergency_contact_relationship' => [
                'nullable',
                'string',
                'max:100',
            ],

            'kyc_status' => [
                'required',
                Rule::in([
                    'pending',
                    'verified',
                    'rejected',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'blacklisted',
                ]),
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $tenant->update($validated);

        return redirect()
            ->route(
                'property-management.tenants.show',
                $tenant
            )
            ->with(
                'success',
                'Tenant updated successfully.'
            );
    }

    /**
     * Delete tenant.
     */
    public function destroy(Tenant $tenant)
    {
        /*
         * Once leases exist, we should prevent deletion
         * when the tenant has historical lease records.
         */
        if ($tenant->leases()->exists()) {
            return back()->with(
                'error',
                'This tenant cannot be deleted because they have lease records.'
            );
        }

        $tenant->delete();

        return redirect()
            ->route('property-management.tenants.index')
            ->with(
                'success',
                'Tenant deleted successfully.'
            );
    }

    /**
     * Update KYC status.
     */
    public function updateKycStatus(
        Request $request,
        Tenant $tenant
    ) {
        $validated = $request->validate([
            'kyc_status' => [
                'required',
                Rule::in([
                    'pending',
                    'verified',
                    'rejected',
                ]),
            ],
        ]);

        $tenant->update([
            'kyc_status' => $validated['kyc_status'],
        ]);

        return back()->with(
            'success',
            'Tenant KYC status updated successfully.'
        );
    }
}