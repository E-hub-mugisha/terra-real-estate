<?php

namespace App\Http\Controllers\Admin\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\ManagedProperty;
use App\Models\PropertyOwner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManagedPropertyController extends Controller
{
    public function index(Request $request)
    {
        $properties = ManagedProperty::with('owner.user')
            ->withCount('units')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('property_code', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('management_status'), function ($query) use ($request) {
                $query->where(
                    'management_status',
                    $request->input('management_status')
                );
            })
            ->latest()
            ->paginate(15);

        return view(
            'admin.property-management.properties.index',
            compact('properties')
        );
    }

    public function create()
    {
        $owners = PropertyOwner::with('user')
            ->where('verification_status', 'verified')
            ->orderBy('id', 'desc')
            ->get();

        $property = new ManagedProperty();

        return view(
            'admin.property-management.properties.create',
            compact('owners', 'property')
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateProperty($request);

        $property = ManagedProperty::create($validated);

        return redirect()
            ->route('admin.property-management.properties.show', $property)
            ->with('success', 'Property created successfully.');
    }

    public function show(ManagedProperty $property)
    {
        $property->load(['owner.user', 'buildings', 'units']);

        return view(
            'admin.property-management.properties.show',
            compact('property')
        );
    }

    public function edit(ManagedProperty $property)
    {
        $owners = PropertyOwner::with('user')
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'admin.property-management.properties.edit',
            compact('property', 'owners')
        );
    }

    public function update(Request $request, ManagedProperty $property)
    {
        $validated = $this->validateProperty($request, $property);

        $property->update($validated);

        return redirect()
            ->route('admin.property-management.properties.show', $property)
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(ManagedProperty $property)
    {
        if (
            $property->buildings()->exists() ||
            $property->units()->exists()
        ) {
            return back()->with(
                'error',
                'This property cannot be deleted because it contains buildings or units.'
            );
        }

        $property->delete();

        return redirect()
            ->route('admin.property-management.properties.index')
            ->with('success', 'Property deleted successfully.');
    }

    private function validateProperty(
        Request $request,
        ?ManagedProperty $property = null
    ): array {
        return $request->validate([
            'property_owner_id' => [
                'required',
                'integer',
                Rule::exists('property_owners', 'id'),
            ],
            'name' => ['required', 'string', 'max:255'],
            'property_code' => [
                'required',
                'string',
                'max:100',
                Rule::unique('managed_properties', 'property_code')
                    ->ignore($property?->id),
            ],
            'property_type' => [
                'required',
                Rule::in([
                    'residential',
                    'commercial',
                    'mixed_use',
                    'industrial',
                    'land',
                    'other',
                ]),
            ],
            'description' => ['nullable', 'string', 'max:5000'],
            'province' => ['nullable', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'sector' => ['nullable', 'string', 'max:100'],
            'cell' => ['nullable', 'string', 'max:100'],
            'village' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:1000'],
            'upi_reference' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'management_status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);
    }
}
