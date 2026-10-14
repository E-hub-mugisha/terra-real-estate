<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Floor;
use App\Models\ManagedProperty;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $units = Unit::with(['managedProperty', 'building', 'floor'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('unit_number', 'like', "%{$search}%")
                        ->orWhereHas('managedProperty', function ($propertyQuery) use ($search) {
                            $propertyQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('property_code', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('managed_property_id'), function ($query) use ($request) {
                $query->where('managed_property_id', $request->input('managed_property_id'));
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $properties = ManagedProperty::orderBy('name')->get([
            'id', 'name', 'property_code',
        ]);

        return view('admin.property-management.units.index', compact(
            'units',
            'properties'
        ));
    }

    public function create()
    {
        $unit = new Unit();

        $properties = ManagedProperty::orderBy('name')->get();
        $buildings = Building::with('managedProperty')->orderBy('name')->get();
        $floors = Floor::with('building')->orderBy('floor_number')->get();

        return view('admin.property-management.units.create', compact(
            'unit',
            'properties',
            'buildings',
            'floors'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateUnit($request);

        $this->validateHierarchy($validated);

        $unit = Unit::create($validated);

        return redirect()
            ->route('admin.property-management.units.show', $unit)
            ->with('success', 'Unit created successfully.');
    }

    public function show(Unit $unit)
    {
        $unit->load([
            'managedProperty.owner.user',
            'building',
            'floor',
            'applications',
            'leases',
        ]);

        return view('admin.property-management.units.show', compact('unit'));
    }

    public function edit(Unit $unit)
    {
        $properties = ManagedProperty::orderBy('name')->get();
        $buildings = Building::with('managedProperty')->orderBy('name')->get();
        $floors = Floor::with('building')->orderBy('floor_number')->get();

        return view('admin.property-management.units.edit', compact(
            'unit',
            'properties',
            'buildings',
            'floors'
        ));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $this->validateUnit($request, $unit);

        $this->validateHierarchy($validated);

        $unit->update($validated);

        return redirect()
            ->route('admin.property-management.units.show', $unit)
            ->with('success', 'Unit updated successfully.');
    }

    public function destroy(Unit $unit)
    {
        if ($unit->applications()->exists() || $unit->leases()->exists()) {
            return redirect()
                ->route('admin.property-management.units.show', $unit)
                ->with(
                    'error',
                    'This unit cannot be deleted because it has tenant applications or leases.'
                );
        }

        if ($unit->maintenanceRequests()->exists() || $unit->expenses()->exists()) {
            return redirect()
                ->route('admin.property-management.units.show', $unit)
                ->with(
                    'error',
                    'This unit cannot be deleted because it has maintenance requests or expenses.'
                );
        }

        $unit->delete();

        return redirect()
            ->route('admin.property-management.units.index')
            ->with('success', 'Unit deleted successfully.');
    }

    private function validateUnit(Request $request, ?Unit $unit = null): array
    {
        return $request->validate([
            'managed_property_id' => [
                'required',
                'integer',
                Rule::exists('managed_properties', 'id'),
            ],

            'building_id' => [
                'nullable',
                'integer',
                Rule::exists('buildings', 'id'),
            ],

            'floor_id' => [
                'nullable',
                'integer',
                Rule::exists('floors', 'id'),
            ],

            'unit_number' => [
                'required',
                'string',
                'max:100',
                Rule::unique('units', 'unit_number')
                    ->where('managed_property_id', $request->input('managed_property_id'))
                    ->ignore($unit?->id),
            ],

            'unit_type' => [
                'required',
                Rule::in([
                    'apartment',
                    'house',
                    'room',
                    'office',
                    'shop',
                    'warehouse',
                    'other',
                ]),
            ],

            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:100'],
            'area_sqm' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'monthly_rent' => ['required', 'numeric', 'min:0', 'max:999999999999.99'],
            'security_deposit' => ['nullable', 'numeric', 'min:0', 'max:999999999999.99'],

            'currency' => [
                'required',
                Rule::in(['RWF', 'USD']),
            ],

            'status' => [
                'required',
                Rule::in([
                    'available',
                    'reserved',
                    'occupied',
                    'maintenance',
                    'unavailable',
                ]),
            ],

            'description' => ['nullable', 'string', 'max:5000'],
        ]);
    }

    /**
     * Ensure the building and floor belong to the selected property.
     */
    private function validateHierarchy(array $validated): void
    {
        if (! empty($validated['building_id'])) {
            $building = Building::find($validated['building_id']);

            if (
                ! $building ||
                (int) $building->managed_property_id !==
                    (int) $validated['managed_property_id']
            ) {
                throw ValidationException::withMessages([
                    'building_id' => 'The selected building does not belong to the selected property.',
                ]);
            }
        }

        if (! empty($validated['floor_id'])) {
            $floor = Floor::with('building')->find($validated['floor_id']);

            if (! $floor) {
                throw ValidationException::withMessages([
                    'floor_id' => 'The selected floor could not be found.',
                ]);
            }

            if (
                empty($validated['building_id']) ||
                (int) $floor->building_id !== (int) $validated['building_id']
            ) {
                throw ValidationException::withMessages([
                    'floor_id' => 'The selected floor must belong to the selected building.',
                ]);
            }

            if (
                (int) $floor->building->managed_property_id !==
                    (int) $validated['managed_property_id']
            ) {
                throw ValidationException::withMessages([
                    'floor_id' => 'The selected floor does not belong to the selected property.',
                ]);
            }
        }
    }
}