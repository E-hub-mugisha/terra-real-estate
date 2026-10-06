<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    /**
     * Store unit.
     */
    public function store(
        Request $request,
        Floor $floor
    ) {
        $this->authorizeFloor($floor);

        $validated = $request->validate([
            'unit_number' => [
                'required',
                'string',
                'max:100',
            ],

            'unit_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'size' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'bedrooms' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

            'bathrooms' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

            'rent' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'deposit' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'availability' => [
                'required',
                'in:available,reserved,unavailable',
            ],

            'occupancy_status' => [
                'required',
                'in:vacant,occupied,under_maintenance',
            ],

            'utility_meter' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $floor->units()->create($validated);

        return back()->with(
            'success',
            'Unit created successfully.'
        );
    }


    /**
     * Edit unit.
     */
    public function edit(Unit $unit)
    {
        $this->authorizeUnit($unit);

        $unit->load('floor.building.property');

        return view(
            'property-management.units.edit',
            compact('unit')
        );
    }


    /**
     * Update unit.
     */
    public function update(
        Request $request,
        Unit $unit
    ) {
        $this->authorizeUnit($unit);

        $validated = $request->validate([
            'unit_number' => [
                'required',
                'string',
                'max:100',
            ],

            'unit_type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'size' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'bedrooms' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

            'bathrooms' => [
                'nullable',
                'integer',
                'min:0',
                'max:100',
            ],

            'rent' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'deposit' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'availability' => [
                'required',
                'in:available,reserved,unavailable',
            ],

            'occupancy_status' => [
                'required',
                'in:vacant,occupied,under_maintenance',
            ],

            'utility_meter' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $unit->update($validated);

        return redirect()
            ->route(
                'property-management.properties.show',
                $unit->floor->building->property_id
            )
            ->with(
                'success',
                'Unit updated successfully.'
            );
    }


    /**
     * Delete unit.
     */
    public function destroy(Unit $unit)
    {
        $this->authorizeUnit($unit);

        $propertyId =
            $unit->floor->building->property_id;

        $unit->delete();

        return redirect()
            ->route(
                'property-management.properties.show',
                $propertyId
            )
            ->with(
                'success',
                'Unit deleted successfully.'
            );
    }


    private function authorizeFloor(Floor $floor): void
    {
        $floor->loadMissing('building.property');

        abort_unless(
            $floor->building &&
            $floor->building->property &&
            $floor->building->property->user_id === Auth::id(),
            403
        );
    }


    private function authorizeUnit(Unit $unit): void
    {
        $unit->loadMissing('floor.building.property');

        abort_unless(
            $unit->floor &&
            $unit->floor->building &&
            $unit->floor->building->property &&
            $unit->floor->building->property->user_id === Auth::id(),
            403
        );
    }
}