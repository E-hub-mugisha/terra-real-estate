<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ManagedProperty;

class FloorController extends Controller
{
    private function ownedBuilding(
        Request $request,
        ManagedProperty $property,
        Building $building
    ): Building {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $ownedProperty = $owner->properties()
            ->whereKey($property->id)
            ->firstOrFail();

        return $ownedProperty->buildings()
            ->whereKey($building->id)
            ->firstOrFail();
    }

    private function ownedFloor(
        Building $building,
        Floor $floor
    ): Floor {
        return $building->floors()
            ->whereKey($floor->id)
            ->firstOrFail();
    }

    public function index(
        Request $request,
        ManagedProperty $property,
        Building $building
    ) {
        $building = $this->ownedBuilding(
            $request,
            $property,
            $building
        );

        $floors = $building->floors()
            ->withCount('units')
            ->orderBy('floor_number')
            ->paginate(15);

        return view('property-owner.floors.index', compact(
            'property',
            'building',
            'floors'
        ));
    }

    public function create(
        Request $request,
        ManagedProperty $property,
        Building $building
    ) {
        $building = $this->ownedBuilding(
            $request,
            $property,
            $building
        );

        return view('property-owner.floors.create', compact(
            'property',
            'building'
        ));
    }

    public function store(
        Request $request,
        ManagedProperty $property,
        Building $building
    ) {
        $building = $this->ownedBuilding(
            $request,
            $property,
            $building
        );

        $validated = $request->validate([
            'floor_number' => [
                'required',
                'integer',
                'min:0',
                'max:200',
                Rule::unique('floors', 'floor_number')
                    ->where(fn ($query) =>
                        $query->where('building_id', $building->id)
                    ),
            ],
            'name' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $building->floors()->create($validated);

        return redirect()
            ->route('property-owner.floors.index', [
                $property,
                $building,
            ])
            ->with('success', 'Floor created successfully.');
    }

    public function show(
        Request $request,
        ManagedProperty $property,
        Building $building,
        Floor $floor
    ) {
        $building = $this->ownedBuilding(
            $request,
            $property,
            $building
        );

        $floor = $this->ownedFloor($building, $floor);

        $floor->load([
            'units' => fn ($query) => $query->orderBy('unit_number'),
        ]);

        return view('property-owner.floors.show', compact(
            'property',
            'building',
            'floor'
        ));
    }

    public function edit(
        Request $request,
        ManagedProperty $property,
        Building $building,
        Floor $floor
    ) {
        $building = $this->ownedBuilding(
            $request,
            $property,
            $building
        );

        $floor = $this->ownedFloor($building, $floor);

        return view('property-owner.floors.edit', compact(
            'property',
            'building',
            'floor'
        ));
    }

    public function update(
        Request $request,
        ManagedProperty $property,
        Building $building,
        Floor $floor
    ) {
        $building = $this->ownedBuilding(
            $request,
            $property,
            $building
        );

        $floor = $this->ownedFloor($building, $floor);

        $validated = $request->validate([
            'floor_number' => [
                'required',
                'integer',
                'min:0',
                'max:200',
                Rule::unique('floors', 'floor_number')
                    ->where(fn ($query) =>
                        $query->where('building_id', $building->id)
                    )
                    ->ignore($floor->id),
            ],
            'name' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $floor->update($validated);

        return redirect()
            ->route('property-owner.floors.index', [
                $property,
                $building,
            ])
            ->with('success', 'Floor updated successfully.');
    }

    public function destroy(
        Request $request,
        ManagedProperty $property,
        Building $building,
        Floor $floor
    ) {
        $building = $this->ownedBuilding(
            $request,
            $property,
            $building
        );

        $floor = $this->ownedFloor($building, $floor);

        if ($floor->units()->exists()) {
            return back()->with(
                'error',
                'This floor cannot be deleted because it contains units.'
            );
        }

        $floor->delete();

        return redirect()
            ->route('property-owner.floors.index', [
                $property,
                $building,
            ])
            ->with('success', 'Floor deleted successfully.');
    }
}