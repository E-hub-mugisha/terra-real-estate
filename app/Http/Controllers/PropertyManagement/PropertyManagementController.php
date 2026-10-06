<?php

namespace App\Http\Controllers\PropertyManagement;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyManagementController extends Controller
{
    /**
     * Property Management Dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();

        $properties = Property::where('user_id', $user->id)
            ->withCount('buildings')
            ->latest()
            ->get();

        $totalProperties = $properties->count();

        $totalBuildings = $properties->sum('buildings_count');

        $totalUnits = $properties
            ->load('buildings.floors.units')
            ->sum(function ($property) {
                return $property->buildings->sum(function ($building) {
                    return $building->floors->sum(function ($floor) {
                        return $floor->units->count();
                    });
                });
            });

        $occupiedUnits = $properties
            ->sum(function ($property) {
                return $property->buildings->sum(function ($building) {
                    return $building->floors->sum(function ($floor) {
                        return $floor->units
                            ->where('occupancy_status', 'occupied')
                            ->count();
                    });
                });
            });

        $vacantUnits = $properties
            ->sum(function ($property) {
                return $property->buildings->sum(function ($building) {
                    return $building->floors->sum(function ($floor) {
                        return $floor->units
                            ->where('occupancy_status', 'vacant')
                            ->count();
                    });
                });
            });

        return view(
            'property-management.dashboard',
            compact(
                'properties',
                'totalProperties',
                'totalBuildings',
                'totalUnits',
                'occupiedUnits',
                'vacantUnits'
            )
        );
    }

    /**
     * List managed properties.
     */
    public function index(Request $request)
    {
        $query = Property::query()
            ->where('user_id', auth()->id())
            ->withCount('buildings');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('upi_reference', 'like', "%{$search}%")
                    ->orWhere('district', 'like', "%{$search}%")
                    ->orWhere('sector', 'like', "%{$search}%");
            });
        }

        if ($request->filled('listing_type')) {
            $query->where('listing_type', $request->listing_type);
        }

        if ($request->filled('managed')) {
            $query->where('is_managed', (bool) $request->managed);
        }

        $properties = $query->latest()->paginate(10)->withQueryString();

        $base = Property::where('user_id', auth()->id());
        $stats = [
            'total'     => (clone $base)->count(),
            'managed'   => (clone $base)->where('is_managed', true)->count(),
            'unmanaged' => (clone $base)->where('is_managed', false)->count(),
            'buildings' => Building::whereIn('property_id', (clone $base)->select('id'))->count(),
        ];

        return view('property-management.properties.index', compact('properties', 'stats'));
    }

    public function create()
    {
        // Get users who can own properties.
        $owners = User::orderBy('name')->get();

        return view(
            'property-management.properties.create',
            compact('owners')
        );
    }

    /**
     * Store property.
     */
    public function store(Request $request)
    {
        $data = $request->validate([

            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'required',
                'string',
            ],

            'type' => [
                'required',
                'string',
                'in:house,land',
            ],

            'property_category' => [
                'required',
                'string',
                'in:residential,commercial,land,industrial',
            ],

            'listing_type' => [
                'required',
                'string',
                'in:sale,rent,lease',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'district' => [
                'required',
                'string',
                'max:255',
            ],

            'sector' => [
                'required',
                'string',
                'max:255',
            ],

            'cell' => [
                'required',
                'string',
                'max:255',
            ],

            'village' => [
                'nullable',
                'string',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
                'max:500',
            ],

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],

            'status' => [
                'required',
                'string',
                'in:available,reserved,sold',
            ],

            'management_status' => [
                'required',
                'string',
                'in:not_managed,active,inactive',
            ],

            'is_approved' => [
                'nullable',
                'boolean',
            ],

            'is_managed' => [
                'nullable',
                'boolean',
            ],

            'upi_reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'zoning' => [
                'nullable',
                'string',
                'max:255',
            ],

            'expires_at' => [
                'nullable',
                'date',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Always Use Authenticated User
        |--------------------------------------------------------------------------
        |
        | Do NOT trust user_id submitted from the browser.
        |
        */

        $data['user_id'] = auth()->id();


        /*
        |--------------------------------------------------------------------------
        | Checkbox Values
        |--------------------------------------------------------------------------
        |
        | Unchecked checkboxes are not submitted by HTML.
        | boolean() safely converts them to true/false.
        |
        */

        $data['is_approved'] = $request->boolean('is_approved');

        $data['is_managed'] = $request->boolean('is_managed');


        /*
        |--------------------------------------------------------------------------
        | Create Property
        |--------------------------------------------------------------------------
        */

        $property = Property::create($data);


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('property-management.properties.index')
            ->with(
                'success',
                'Property created successfully.'
            );
    }

    /**
     * Show property.
     */
    public function show(Property $property)
    {
        $this->authorizeProperty($property);

        $property->load([
            'buildings.floors.units',
        ]);

        return view(
            'property-management.properties.show',
            compact('property')
        );
    }

    /**
     * Enable property management.
     */
    public function activate(Property $property)
    {
        $this->authorizeProperty($property);

        $property->update([
            'is_managed' => true,
            'management_status' => 'active',
        ]);

        return back()->with(
            'success',
            'Property has been added to Property Management.'
        );
    }

    /**
     * Disable property management.
     */
    public function deactivate(Property $property)
    {
        $this->authorizeProperty($property);

        $property->update([
            'is_managed' => false,
            'management_status' => 'inactive',
        ]);

        return back()->with(
            'success',
            'Property Management has been disabled for this property.'
        );
    }

    /**
     * Make sure landlord can only access own property.
     */
    private function authorizeProperty(Property $property): void
    {
        abort_unless(
            $property->user_id === Auth::id(),
            403
        );
    }

    /**
     * Show edit form.
     */
    public function edit(Property $property)
    {
        $owners = User::orderBy('name')->get();

        return view(
            'property-management.properties.edit',
            compact('property', 'owners')
        );
    }

    /**
     * Update property.
     */
    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',

            'title' => 'required|string|max:255',

            'description' => 'required|string',

            'type' => 'required|in:house,land',

            'property_category' => 'required|string|max:100',

            'listing_type' => 'required|string|max:50',

            'price' => 'required|numeric|min:0',

            'district' => 'required|string|max:255',

            'sector' => 'required|string|max:255',

            'cell' => 'required|string|max:255',

            'village' => 'nullable|string|max:255',

            'address' => 'nullable|string|max:255',

            'latitude' => 'nullable|numeric|between:-90,90',

            'longitude' => 'nullable|numeric|between:-180,180',

            'upi_reference' => 'nullable|string|max:255',

            'zoning' => 'nullable|in:R1,R2,R3,Commercial,Industrial',

            'status' => 'required|in:available,reserved,sold',

            'management_status' => 'required|in:not_managed,active,inactive',

            'is_approved' => 'nullable|boolean',

            'is_managed' => 'nullable|boolean',

            'expires_at' => 'nullable|date',
        ]);

        $validated['is_approved'] = $request->boolean('is_approved');
        $validated['is_managed'] = $request->boolean('is_managed');

        $property->update($validated);

        return redirect()
            ->route(
                'property-management.properties.show',
                $property
            )
            ->with('success', 'Property updated successfully.');
    }

    /**
     * Delete property.
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return redirect()
            ->route('property-management.properties.index')
            ->with('success', 'Property deleted successfully.');
    }
}
