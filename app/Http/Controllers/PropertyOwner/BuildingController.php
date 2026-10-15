<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\ManagedProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BuildingController extends Controller
{
    private function ownedProperty(Request $request, ManagedProperty $property): ManagedProperty
    {
        return $request->user()
            ->propertyOwner()
            ->firstOrFail()
            ->properties()
            ->whereKey($property->id)
            ->firstOrFail();
    }

    public function index(Request $request, ManagedProperty $property)
    {
        $property = $this->ownedProperty($request, $property);

        $buildings = $property->buildings()
            ->withCount('floors')
            ->latest()
            ->paginate(10);

        return view('property-owner.buildings.index', compact(
            'property',
            'buildings'
        ));
    }

    public function create(Request $request, ManagedProperty $property)
    {
        $property = $this->ownedProperty($request, $property);

        return view('property-owner.buildings.create', compact('property'));
    }

    public function store(Request $request, ManagedProperty $property)
    {
        $property = $this->ownedProperty($request, $property);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'number_of_floors' => ['required', 'integer', 'min:1', 'max:200'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        $building = $property->buildings()->create([
            'name' => $validated['name'],
            'building_code' => $this->generateBuildingCode(),
            'number_of_floors' => $validated['number_of_floors'],
            'description' => $validated['description'] ?? null,
            'is_active' => true,
        ]);

        return redirect()
            ->route('property-owner.buildings.show', [$property, $building])
            ->with('success', 'Building created successfully.');
    }

    public function show(
        Request $request,
        ManagedProperty $property,
        Building $building
    ) {
        $property = $this->ownedProperty($request, $property);
        $building = $this->ownedBuilding($property, $building);

        $building->load(['floors.units']);

        return view('property-owner.buildings.show', compact(
            'property',
            'building'
        ));
    }

    public function edit(
        Request $request,
        ManagedProperty $property,
        Building $building
    ) {
        $property = $this->ownedProperty($request, $property);
        $building = $this->ownedBuilding($property, $building);

        return view('property-owner.buildings.edit', compact(
            'property',
            'building'
        ));
    }

    public function update(
        Request $request,
        ManagedProperty $property,
        Building $building
    ) {
        $property = $this->ownedProperty($request, $property);
        $building = $this->ownedBuilding($property, $building);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'number_of_floors' => ['required', 'integer', 'min:1', 'max:200'],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['required', 'boolean'],
        ]);

        $building->update($validated);

        return redirect()
            ->route('property-owner.buildings.show', [$property, $building])
            ->with('success', 'Building updated successfully.');
    }

    private function ownedBuilding(
        ManagedProperty $property,
        Building $building
    ): Building {
        return $property->buildings()
            ->whereKey($building->id)
            ->firstOrFail();
    }

    private function generateBuildingCode(): string
    {
        do {
            $code = 'BLD-' . strtoupper(Str::random(8));
        } while (Building::where('building_code', $code)->exists());

        return $code;
    }
}