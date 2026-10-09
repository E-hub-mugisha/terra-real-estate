<?php

namespace App\Http\Controllers\TenantPortal;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\TenantApplication;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PropertyBrowseController extends Controller
{
    /**
     * Display units available for rental.
     */
    public function index()
    {
        $units = Unit::with([
            'floor.building.property',
        ])
            ->where('availability', 'available')
            ->where('occupancy_status', 'vacant')
            ->whereHas('floor', function ($floorQuery) {
                $floorQuery->whereHas('building', function ($buildingQuery) {
                    $buildingQuery->whereHas('property', function ($propertyQuery) {
                        $propertyQuery
                            ->where('is_managed', true)
                            ->where('is_approved', true)
                            ->where('management_status', 'active');
                    });
                });
            })
            ->orderByDesc('id')
            ->paginate(12);

        return view('tenant-portal.properties.index', compact('units'));
    }

    /**
     * Display details for one available unit.
     */
    public function show(Unit $unit)
    {
        $unit->load('floor.building.property');

        abort_unless($this->isAvailableForApplication($unit), 404);

        return view('tenant-portal.properties.show', compact('unit'));
    }

    /**
     * Submit a rental application.
     */
    public function apply(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'preferred_move_in_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
            'offered_rent' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
            'offered_deposit' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999999999.99',
            ],
            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $tenant = Tenant::where('user_id', $request->user()->id)
            ->firstOrFail();

        $application = DB::transaction(function () use (
            $unit,
            $tenant,
            $validated
        ) {
            /*
             * Lock the unit row while checking availability and creating
             * the application, reducing the risk of concurrent submissions.
             */
            $lockedUnit = Unit::whereKey($unit->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedUnit->load('floor.building.property');

            if (! $this->isAvailableForApplication($lockedUnit)) {
                throw ValidationException::withMessages([
                    'unit' => 'This unit is no longer available. Please choose another unit.',
                ]);
            }

            $existingApplication = TenantApplication::where(
                'tenant_id',
                $tenant->id
            )
                ->where('unit_id', $lockedUnit->id)
                ->whereIn('status', [
                    'pending',
                    'under_review',
                    'approved',
                ])
                ->exists();

            if ($existingApplication) {
                throw ValidationException::withMessages([
                    'unit' => 'You already have an active application for this unit.',
                ]);
            }

            return TenantApplication::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $lockedUnit->id,
                'application_date' => now()->toDateString(),
                'preferred_move_in_date' =>
                $validated['preferred_move_in_date'] ?? null,
                'offered_rent' => $validated['offered_rent'] ?? null,
                'offered_deposit' => $validated['offered_deposit'] ?? null,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()
            ->route('tenant-portal.applications.show', $application)
            ->with('success', 'Your rental application has been submitted successfully.');
    }

    /**
     * Confirm the unit and its property meet portal availability rules.
     */
    private function isAvailableForApplication(Unit $unit): bool
    {
        $property = $unit->floor?->building?->property;

        return $property !== null
            && $unit->availability === 'available'
            && $unit->occupancy_status === 'vacant'
            && $property->management_status === 'active'
            && (bool) $property->is_managed
            && (bool) $property->is_approved;
    }
}
