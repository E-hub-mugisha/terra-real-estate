<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuildingController extends Controller
{
    /**
     * Store a new building.
     */
    public function store(Request $request, Property $property)
    {
        $this->authorizeProperty($property);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'reference' => [
                'nullable',
                'string',
                'max:100',
            ],

            'number_of_floors' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],
        ]);

        $building = $property->buildings()->create($validated);

        /*
        |--------------------------------------------------------------------------
        | Automatically create floors
        |--------------------------------------------------------------------------
        */

        for ($i = 0; $i < $building->number_of_floors; $i++) {

            $floorName = $i === 0
                ? 'Ground Floor'
                : 'Floor ' . $i;

            $building->floors()->create([
                'name' => $floorName,
                'floor_number' => $i,
            ]);
        }

        return back()->with(
            'success',
            'Building and floors created successfully.'
        );
    }


    /**
     * Edit building.
     */
    public function edit(Building $building)
    {
        $this->authorizeBuilding($building);

        $building->load('property');

        return view(
            'property-management.buildings.edit',
            compact('building')
        );
    }


    /**
     * Update building.
     */
    public function update(
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

            'reference' => [
                'nullable',
                'string',
                'max:100',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                'string',
                'in:active,inactive,maintenance',
            ],
        ]);

        $building->update($validated);

        return redirect()
            ->route(
                'property-management.properties.show',
                $building->property_id
            )
            ->with(
                'success',
                'Building updated successfully.'
            );
    }


    /**
     * Delete building.
     */
    public function destroy(Building $building)
    {
        $this->authorizeBuilding($building);

        $propertyId = $building->property_id;

        $building->delete();

        return redirect()
            ->route(
                'property-management.properties.show',
                $propertyId
            )
            ->with(
                'success',
                'Building deleted successfully.'
            );
    }


    /**
     * Make sure the building belongs to the
     * authenticated user's property.
     */
    private function authorizeBuilding(Building $building): void
    {
        abort_unless(
            $building->property &&
            $building->property->user_id === Auth::id(),
            403
        );
    }


    private function authorizeProperty(Property $property): void
    {
        abort_unless(
            $property->user_id === Auth::id(),
            403
        );
    }
}