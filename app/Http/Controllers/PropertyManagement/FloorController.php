<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FloorController extends Controller
{
    /**
     * Create floor.
     */
    public function store(
        Request $request,
        Building $building
    ) {
        $this->authorizeBuilding($building);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'floor_number' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $building->floors()->create($validated);

        return back()->with(
            'success',
            'Floor created successfully.'
        );
    }


    /**
     * Edit floor.
     */
    public function edit(Floor $floor)
    {
        $this->authorizeFloor($floor);

        $floor->load('building');

        return view(
            'property-management.floors.edit',
            compact('floor')
        );
    }


    /**
     * Update floor.
     */
    public function update(
        Request $request,
        Floor $floor
    ) {
        $this->authorizeFloor($floor);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'floor_number' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $floor->update($validated);

        return redirect()
            ->route(
                'property-management.properties.show',
                $floor->building->property_id
            )
            ->with(
                'success',
                'Floor updated successfully.'
            );
    }


    /**
     * Delete floor.
     */
    public function destroy(Floor $floor)
    {
        $this->authorizeFloor($floor);

        $propertyId = $floor->building->property_id;

        $floor->delete();

        return redirect()
            ->route(
                'property-management.properties.show',
                $propertyId
            )
            ->with(
                'success',
                'Floor deleted successfully.'
            );
    }


    private function authorizeBuilding(Building $building): void
    {
        $building->loadMissing('property');

        abort_unless(
            $building->property &&
            $building->property->user_id === Auth::id(),
            403
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
}