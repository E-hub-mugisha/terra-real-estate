<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\TenantApplication;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class ApplicationController extends Controller
{
    public function create(Request $request, Unit $unit): View
    {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403);

        // Only allow applications for available units.
        abort_unless($unit->status === 'available', 404);

        return view('tenant-portal.applications.create', [
            'unit' => $unit->load([
                'managedProperty',
                'building',
                'floor',
            ]),
        ]);
    }

    public function store(Request $request, Unit $unit): RedirectResponse
    {
        $tenant = $request->user()->tenantProfile;

        abort_unless($tenant, 403);
        abort_unless($unit->status === 'available', 404);

        $validated = $request->validate([
            'preferred_move_in_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
            'offered_rent' => [
                'required',
                'numeric',
                'min:0',
            ],
            'offered_deposit' => [
                'required',
                'numeric',
                'min:0',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ]);

        // Prevent duplicate active applications for the same unit.
        $existingApplication = $tenant->applications()
            ->where('unit_id', $unit->id)
            ->whereIn('status', [
                'pending',
                'under_review',
                'approved',
            ])
            ->exists();

        if ($existingApplication) {
            throw ValidationException::withMessages([
                'unit_id' => 'You already have an active application for this unit.',
            ]);
        }

        TenantApplication::create([
            'tenant_id' => $tenant->id,
            'unit_id' => $unit->id,
            'application_date' => now()->toDateString(),
            'preferred_move_in_date' =>
                $validated['preferred_move_in_date'] ?? null,
            'offered_rent' => $validated['offered_rent'],
            'offered_deposit' => $validated['offered_deposit'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('tenant-portal.applications.index')
            ->with('success', 'Your property application has been submitted successfully.');
    }

    // Keep your existing index() and show() methods here.
}