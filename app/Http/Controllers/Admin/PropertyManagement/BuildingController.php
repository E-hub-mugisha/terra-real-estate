<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\ManagedProperty;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BuildingController extends Controller
{
    public function index(Request $request)
    {
        $buildings = Building::with('managedProperty.owner.user')
            ->withCount('floors')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('building_code', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('managed_property_id'), function ($query) use ($request) {
                $query->where(
                    'managed_property_id',
                    $request->input('managed_property_id')
                );
            })
            ->latest()
            ->paginate(15);

        $properties = ManagedProperty::orderBy('name')->get([
            'id',
            'name',
            'property_code',
        ]);

        return view(
            'admin.property-management.buildings.index',
            compact('buildings', 'properties')
        );
    }

    public function create()
    {
        $properties = ManagedProperty::with('owner.user')
            ->orderBy('name')
            ->get();

        $building = new Building();

        return view(
            'admin.property-management.buildings.create',
            compact('building', 'properties')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateBuilding($request);

        $validated['is_active'] = $request->boolean('is_active');

        $building = Building::create($validated);

        return redirect()
            ->route('admin.property-management.buildings.show', $building)
            ->with('success', 'Building created successfully.');
    }

    public function show(Building $building)
    {
        $building->load([
            'managedProperty.owner.user',
            'floors.units',
        ]);

        return view(
            'admin.property-management.buildings.show',
            compact('building')
        );
    }

    public function edit(Building $building)
    {
        $properties = ManagedProperty::with('owner.user')
            ->orderBy('name')
            ->get();

        return view(
            'admin.property-management.buildings.edit',
            compact('building', 'properties')
        );
    }

    public function update(Request $request, Building $building)
    {
        $validated = $this->validateBuilding($request, $building);

        $validated['is_active'] = $request->boolean('is_active');

        $building->update($validated);

        return redirect()
            ->route('admin.property-management.buildings.show', $building)
            ->with('success', 'Building updated successfully.');
    }

    public function destroy(Building $building)
    {
        if ($building->floors()->whereHas('units')->exists()) {
            return redirect()
                ->route('admin.property-management.buildings.show', $building)
                ->with(
                    'error',
                    'This building cannot be deleted because it has floors containing units.'
                );
        }

        $building->delete();

        return redirect()
            ->route('admin.property-management.buildings.index')
            ->with('success', 'Building deleted successfully.');
    }

    private function validateBuilding(
        Request $request,
        ?Building $building = null
    ): array {
        $validated = $request->validate([
            'managed_property_id' => [
                'required',
                'integer',
                Rule::exists('managed_properties', 'id'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'building_code' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('buildings', 'building_code')
                    ->where(
                        'managed_property_id',
                        $request->input('managed_property_id')
                    )
                    ->ignore($building?->id),
            ],
            'number_of_floors' => [
                'nullable',
                'integer',
                'min:0',
                'max:200',
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        return $validated;
    }
}