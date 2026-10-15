<?php

namespace App\Http\Controllers\PropertyOwner;

use App\Http\Controllers\Controller;
use App\Models\ManagedProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $properties = $owner->properties()
            ->latest()
            ->paginate(10);

        return view('property-owner.properties.index', compact(
            'owner',
            'properties'
        ));
    }

    public function create(Request $request)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        return view('property-owner.properties.create', compact('owner'));
    }

    public function store(Request $request)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'property_type' => [
                'required',
                'string',
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
            'province' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'sector' => ['nullable', 'string', 'max:100'],
            'cell' => ['nullable', 'string', 'max:100'],
            'village' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
            'upi_reference' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $property = $owner->properties()->create([
            ...$validated,
            'property_code' => $this->generatePropertyCode(),
            'management_status' => 'not_managed',
        ]);

        return redirect()
            ->route('property-owner.properties.show', $property)
            ->with('success', 'Property created successfully.');
    }

    public function show(Request $request, ManagedProperty $property)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $property = $owner->properties()
            ->whereKey($property->getKey())
            ->firstOrFail();

        return view('property-owner.properties.show', compact(
            'owner',
            'property'
        ));
    }

    public function edit(Request $request, ManagedProperty $property)
    {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $property = $owner->properties()
            ->whereKey($property->getKey())
            ->firstOrFail();

        return view('property-owner.properties.edit', compact(
            'owner',
            'property'
        ));
    }

    public function update(
        Request $request,
        ManagedProperty $property
    ) {
        $owner = $request->user()
            ->propertyOwner()
            ->firstOrFail();

        $property = $owner->properties()
            ->whereKey($property->getKey())
            ->firstOrFail();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'property_type' => [
                'required',
                'string',
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
            'province' => ['required', 'string', 'max:100'],
            'district' => ['required', 'string', 'max:100'],
            'sector' => ['nullable', 'string', 'max:100'],
            'cell' => ['nullable', 'string', 'max:100'],
            'village' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:500'],
            'upi_reference' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        // Only update owner-editable fields.
        // Do not overwrite property_code or management_status.
        $property->update($validated);

        return redirect()
            ->route('property-owner.properties.show', $property)
            ->with('success', 'Property updated successfully.');
    }

    private function generatePropertyCode(): string
    {
        do {
            $code = 'TER-' . strtoupper(Str::random(10));
        } while (
            ManagedProperty::where('property_code', $code)->exists()
        );

        return $code;
    }
}