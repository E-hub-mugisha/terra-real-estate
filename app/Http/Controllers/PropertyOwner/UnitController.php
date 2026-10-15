<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use App\Models\ManagedProperty;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UnitController extends Controller
{
    private function ownedProperty(
        Request $request,
        ManagedProperty $property
    ): ManagedProperty {
        return $request->user()
            ->propertyOwner()
            ->firstOrFail()
            ->properties()
            ->whereKey($property->id)
            ->firstOrFail();
    }

    private function ownedBuilding(
        ManagedProperty $property,
        Building $building
    ): Building {
        return $property->buildings()
            ->whereKey($building->id)
            ->firstOrFail();
    }

    private function ownedUnit(
        Building $building,
        Unit $unit
    ): Unit {
        return $building->units()
            ->whereKey($unit->id)
            ->firstOrFail();
    }

    public function index(
        Request $request,
        ManagedProperty $property,
        Building $building
    ) {
        $property = $this->ownedProperty($request, $property);
        $building = $this->ownedBuilding($property, $building);

        $units = $building->units()
            ->with('floor')
            ->latest()
            ->paginate(10);

        return view('property-owner.units.index', compact(
            'property',
            'building',
            'units'
        ));
    }

    public function create(
        Request $request,
        ManagedProperty $property,
        Building $building
    ) {
        $property = $this->ownedProperty($request, $property);
        $building = $this->ownedBuilding($property, $building);

        $floors = $building->floors()
            ->orderBy('floor_number')
            ->get();

        return view('property-owner.units.create', compact(
            'property',
            'building',
            'floors'
        ));
    }

    public function store(
        Request $request,
        ManagedProperty $property,
        Building $building
    ) {
        $property = $this->ownedProperty($request, $property);
        $building = $this->ownedBuilding($property, $building);

        $validated = $request->validate([
            'floor_id' => [
                'required',
                'integer',
                Rule::exists('floors', 'id')->where(
                    fn ($query) => $query->where(
                        'building_id',
                        $building->id
                    )
                ),
            ],
            'unit_number' => ['required', 'string', 'max:100'],
            'unit_type' => [
                'nullable',
                'string',
                'max:100',
            ],
            'size' => ['nullable', 'numeric', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'rent' => ['required', 'numeric', 'min:0'],
            'deposit' => ['nullable', 'numeric', 'min:0'],
            'availability' => [
                'required',
                Rule::in(['available', 'unavailable', 'reserved']),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        $building->units()->create($validated);

        return redirect()
            ->route('property-owner.units.index', [$property, $building])
            ->with('success', 'Rental unit created successfully.');
    }

    public function edit(
        Request $request,
        ManagedProperty $property,
        Building $building,
        Unit $unit
    ) {
        $property = $this->ownedProperty($request, $property);
        $building = $this->ownedBuilding($property, $building);
        $unit = $this->ownedUnit($building, $unit);

        $floors = $building->floors()
            ->orderBy('floor_number')
            ->get();

        return view('property-owner.units.edit', compact(
            'property',
            'building',
            'unit',
            'floors'
        ));
    }

    public function update(
        Request $request,
        ManagedProperty $property,
        Building $building,
        Unit $unit
    ) {
        $property = $this->ownedProperty($request, $property);
        $building = $this->ownedBuilding($property, $building);
        $unit = $this->ownedUnit($building, $unit);

        $validated = $request->validate([
            'floor_id' => [
                'required',
                'integer',
                Rule::exists('floors', 'id')->where(
                    fn ($query) => $query->where(
                        'building_id',
                        $building->id
                    )
                ),
            ],
            'unit_number' => ['required', 'string', 'max:100'],
            'unit_type' => ['nullable', 'string', 'max:100'],
            'size' => ['nullable', 'numeric', 'min:0'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'rent' => ['required', 'numeric', 'min:0'],
            'deposit' => ['nullable', 'numeric', 'min:0'],
            'availability' => [
                'required',
                Rule::in(['available', 'unavailable', 'reserved']),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        $unit->update($validated);

        return redirect()
            ->route('property-owner.units.index', [$property, $building])
            ->with('success', 'Rental unit updated successfully.');
    }

    public function show(
        Request $request,
        ManagedProperty $property,
        Building $building,
        Unit $unit
    ) {
        $property = $this->ownedProperty($request, $property);
        $building = $this->ownedBuilding($property, $building);
        $unit = $this->ownedUnit($building, $unit);

        $unit->load('floor');

        return view('property-owner.units.show', compact(
            'property',
            'building',
            'unit'
        ));
    }
}