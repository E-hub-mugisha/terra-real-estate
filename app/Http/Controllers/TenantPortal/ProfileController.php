<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    private function tenantForUser(Request $request): Tenant
    {
        return Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();
    }

    public function edit(Request $request): View
    {
        $tenant = $this->tenantForUser($request);

        return view('tenant-portal.profile.edit', compact('tenant'));
    }

    public function update(Request $request): RedirectResponse
    {
        $tenant = $this->tenantForUser($request);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'phone' => ['required', 'string', 'max:30'],

            'national_id' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('tenants', 'national_id')
                    ->ignore($tenant->id),
            ],

            'date_of_birth' => [
                'nullable',
                'date',
                'before:today',
            ],

            'gender' => ['nullable', 'string', 'max:50'],

            'district' => ['nullable', 'string', 'max:255'],
            'sector' => ['nullable', 'string', 'max:255'],
            'cell' => ['nullable', 'string', 'max:255'],
            'village' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:2000'],

            'emergency_contact_name' => [
                'nullable',
                'string',
                'max:255',
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
        ]);

        $tenant->update($validated);

        return redirect()
            ->route('tenant-portal.profile.edit')
            ->with('success', 'Your profile has been updated successfully.');
    }
}