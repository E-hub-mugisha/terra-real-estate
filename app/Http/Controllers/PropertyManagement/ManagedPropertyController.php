<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\ManagedProperty;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManagedPropertyController extends Controller
{
    private function owner(Request $request)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->first();

        abort_unless($owner, 403, 'Property owner profile not found.');

        return $owner;
    }

    private function ownedProperty(
        Request $request,
        int $id
    ): ManagedProperty {
        return ManagedProperty::where(
            'property_owner_id',
            $this->owner($request)->id
        )->findOrFail($id);
    }

    public function index(Request $request)
    {
        $owner = $this->owner($request);

        $properties = ManagedProperty::where(
            'property_owner_id',
            $owner->id
        )
            ->withCount(['buildings', 'units'])
            ->latest()
            ->paginate(10);

        return view(
            'property-management.properties.index',
            compact('properties')
        );
    }

    public function create(Request $request)
    {
        $this->owner($request);

        return view('property-management.properties.create');
    }

    public function store(Request $request)
    {
        $owner = $this->owner($request);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'property_code' => [
                'required',
                'string',
                'max:255',
                'unique:managed_properties,property_code',
            ],
            'property_type' => [
                'required',
                Rule::in([
                    'residential',
                    'commercial',
                    'mixed_use',
                    'industrial',
                    'other',
                ]),
            ],
            'description' => ['nullable', 'string'],
            'province' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'sector' => ['nullable', 'string', 'max:255'],
            'cell' => ['nullable', 'string', 'max:255'],
            'village' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'upi_reference' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'management_status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
            'notes' => ['nullable', 'string'],
        ]);

        $owner->properties()->create($validated);

        return redirect()
            ->route('property-management.properties.index')
            ->with('success', 'Property created successfully.');
    }

    public function show(Request $request, string $property)
    {
        $managedProperty = $this->ownedProperty(
            $request,
            (int) $property
        )->load([
            'buildings.floors.units',
            'units',
            'expenses',
            'maintenanceRequests',
        ]);

        return view(
            'property-management.properties.show',
            compact('managedProperty')
        );
    }

    public function edit(Request $request, string $property)
    {
        $managedProperty = $this->ownedProperty(
            $request,
            (int) $property
        );

        return view(
            'property-management.properties.edit',
            compact('managedProperty')
        );
    }

    public function update(Request $request, string $property)
    {
        $managedProperty = $this->ownedProperty(
            $request,
            (int) $property
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'property_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('managed_properties', 'property_code')
                    ->ignore($managedProperty->id),
            ],
            'property_type' => [
                'required',
                Rule::in([
                    'residential',
                    'commercial',
                    'mixed_use',
                    'industrial',
                    'other',
                ]),
            ],
            'description' => ['nullable', 'string'],
            'province' => ['nullable', 'string', 'max:255'],
            'district' => ['nullable', 'string', 'max:255'],
            'sector' => ['nullable', 'string', 'max:255'],
            'cell' => ['nullable', 'string', 'max:255'],
            'village' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'upi_reference' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'management_status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
            'notes' => ['nullable', 'string'],
        ]);

        $managedProperty->update($validated);

        return redirect()
            ->route('property-management.properties.index')
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Request $request, string $property)
    {
        $managedProperty = $this->ownedProperty(
            $request,
            (int) $property
        );

        $hasDependencies =
            $managedProperty->units()->exists()
            || $managedProperty->buildings()->exists()
            || $managedProperty->expenses()->exists()
            || $managedProperty->maintenanceRequests()->exists();

        if ($hasDependencies) {
            return redirect()
                ->route('property-management.properties.index')
                ->with(
                    'error',
                    'This property has related records. Mark it inactive instead of deleting it.'
                );
        }

        $managedProperty->delete();

        return redirect()
            ->route('property-management.properties.index')
            ->with('success', 'Property deleted successfully.');
    }
}