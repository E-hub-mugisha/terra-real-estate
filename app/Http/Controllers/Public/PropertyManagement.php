<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Service;
use App\Models\Unit;

class PropertyManagement extends Controller
{
    public function home()
    {
        $properties = \App\Models\Property::query()
            ->where('listing_type', 'rent')
            ->where(function ($query) {
                $query->where('is_managed', true)
                    ->orWhere('management_status', 'active');
            })
            ->with([
                'buildings.floors.units'
            ])
            ->latest()
            ->get();


        $availableUnits = \App\Models\Unit::query()
            ->where('availability', 'available')
            ->where(function ($query) {
                $query->whereNull('occupancy_status')
                    ->orWhereIn('occupancy_status', [
                        'vacant',
                        'available',
                        'unoccupied',
                    ]);
            })
            ->with([
                'floor.building.property'
            ])
            ->whereHas('floor.building.property', function ($query) {
                $query->where('listing_type', 'rent')
                    ->where(function ($query) {
                        $query->where('is_managed', true)
                            ->orWhere('management_status', 'active');
                    });
            })
            ->latest()
            ->take(8)
            ->get();


        $managedProperties = \App\Models\Property::query()
            ->where(function ($query) {
                $query->where('is_managed', true)
                    ->orWhere('management_status', 'active');
            })
            ->count();

        $totalUnits = \App\Models\Unit::query()
            ->whereHas('floor.building.property', function ($query) {
                $query->where(function ($query) {
                    $query->where('is_managed', true)
                        ->orWhere('management_status', 'active');
                });
            })
            ->count();

        $availableUnitCount = \App\Models\Unit::query()
            ->where('availability', 'available')
            ->whereHas('floor.building.property', function ($query) {
                $query->where(function ($query) {
                    $query->where('is_managed', true)
                        ->orWhere('management_status', 'active');
                });
            })
            ->count();


        return view('public.home', compact(
            'properties',
            'availableUnits',
            'managedProperties',
            'totalUnits',
            'availableUnitCount'
        ));
    }

    /**
     * Public units available for rent.
     */
    /**
     * Public units available for rent.
     */
    public function properties(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Base rental unit query
    |--------------------------------------------------------------------------
    */

        $query = Unit::query()
            ->with([
                'floor.building.property',
            ])
            ->where('availability', 'available')
            ->whereHas('floor.building.property', function ($property) {

                $property->where('listing_type', 'rent')
                    ->where(function ($management) {

                        $management->where('is_managed', true)
                            ->orWhere('management_status', 'active');
                    });
            });


        /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('unit_number', 'like', "%{$search}%")
                    ->orWhere('unit_type', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")

                    ->orWhereHas(
                        'floor.building',
                        function ($building) use ($search) {

                            $building
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('reference', 'like', "%{$search}%");
                        }
                    )

                    ->orWhereHas(
                        'floor.building.property',
                        function ($property) use ($search) {

                            $property
                                ->where('title', 'like', "%{$search}%")
                                ->orWhere('address', 'like', "%{$search}%")
                                ->orWhere('district', 'like', "%{$search}%")
                                ->orWhere('sector', 'like', "%{$search}%");
                        }
                    );
            });
        }


        /*
    |--------------------------------------------------------------------------
    | Unit Type
    |--------------------------------------------------------------------------
    */

        if ($request->filled('unit_type')) {

            $query->where(
                'unit_type',
                $request->unit_type
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Bedrooms
    |--------------------------------------------------------------------------
    */

        if ($request->filled('bedrooms')) {

            $query->where(
                'bedrooms',
                '>=',
                (int) $request->bedrooms
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Bathrooms
    |--------------------------------------------------------------------------
    */

        if ($request->filled('bathrooms')) {

            $query->where(
                'bathrooms',
                '>=',
                (int) $request->bathrooms
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Minimum Rent
    |--------------------------------------------------------------------------
    */

        if ($request->filled('min_rent')) {

            $query->where(
                'rent',
                '>=',
                (float) $request->min_rent
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Maximum Rent
    |--------------------------------------------------------------------------
    */

        if ($request->filled('max_rent')) {

            $query->where(
                'rent',
                '<=',
                (float) $request->max_rent
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Minimum Size
    |--------------------------------------------------------------------------
    */

        if ($request->filled('min_size')) {

            $query->where(
                'size',
                '>=',
                (float) $request->min_size
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Maximum Size
    |--------------------------------------------------------------------------
    */

        if ($request->filled('max_size')) {

            $query->where(
                'size',
                '<=',
                (float) $request->max_size
            );
        }


        /*
    |--------------------------------------------------------------------------
    | District
    |--------------------------------------------------------------------------
    */

        if ($request->filled('district')) {

            $query->whereHas(
                'floor.building.property',
                function ($property) use ($request) {

                    $property->where(
                        'district',
                        $request->district
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Sector
    |--------------------------------------------------------------------------
    */

        if ($request->filled('sector')) {

            $query->whereHas(
                'floor.building.property',
                function ($property) use ($request) {

                    $property->where(
                        'sector',
                        $request->sector
                    );
                }
            );
        }


        /*
    |--------------------------------------------------------------------------
    | Sorting
    |--------------------------------------------------------------------------
    */

        switch ($request->get('sort')) {

            case 'rent_low':

                $query->orderBy('rent', 'asc');

                break;


            case 'rent_high':

                $query->orderBy('rent', 'desc');

                break;


            case 'size_low':

                $query->orderBy('size', 'asc');

                break;


            case 'size_high':

                $query->orderBy('size', 'desc');

                break;


            case 'bedrooms':

                $query->orderBy('bedrooms', 'desc');

                break;


            default:

                $query->latest('id');

                break;
        }


        /*
    |--------------------------------------------------------------------------
    | Unit Type Filter Options
    |--------------------------------------------------------------------------
    */

        $unitTypes = Unit::query()
            ->whereNotNull('unit_type')
            ->where('unit_type', '!=', '')
            ->distinct()
            ->orderBy('unit_type')
            ->pluck('unit_type');


        /*
    |--------------------------------------------------------------------------
    | District Filter Options
    |--------------------------------------------------------------------------
    */

        $districts = Unit::query()
            ->whereHas(
                'floor.building.property',
                function ($property) {

                    $property->where('listing_type', 'rent')
                        ->where(function ($management) {

                            $management
                                ->where('is_managed', true)
                                ->orWhere('management_status', 'active');
                        });
                }
            )
            ->with([
                'floor.building.property:id,district'
            ])
            ->get()
            ->map(function ($unit) {

                return optional(
                    optional(
                        optional($unit->floor)->building
                    )->property
                )->district;
            })
            ->filter()
            ->unique()
            ->sort()
            ->values();


        /*
    |--------------------------------------------------------------------------
    | Sector Filter Options
    |--------------------------------------------------------------------------
    */

        $sectors = Unit::query()
            ->whereHas(
                'floor.building.property',
                function ($property) {

                    $property->where('listing_type', 'rent')
                        ->where(function ($management) {

                            $management
                                ->where('is_managed', true)
                                ->orWhere('management_status', 'active');
                        });
                }
            )
            ->with([
                'floor.building.property:id,sector'
            ])
            ->get()
            ->map(function ($unit) {

                return optional(
                    optional(
                        optional($unit->floor)->building
                    )->property
                )->sector;
            })
            ->filter()
            ->unique()
            ->sort()
            ->values();


        /*
    |--------------------------------------------------------------------------
    | Results
    |--------------------------------------------------------------------------
    */

        $units = $query
            ->paginate(12)
            ->withQueryString();


        return view(
            'public.properties.index',
            compact(
                'units',
                'unitTypes',
                'districts',
                'sectors'
            )
        );
    }

    /**
     * Public unit/property details.
     */
    public function property(Unit $unit)
    {
        $unit->load([
            'floor.building.property'
        ]);

        abort_unless(
            $unit->availability === 'available',
            404
        );

        $property = $unit->floor?->building?->property;

        abort_unless(
            $property &&
                $property->listing_type === 'rent' &&
                (
                    $property->is_managed ||
                    $property->management_status === 'active'
                ),
            404
        );

        return view('public.properties.show', compact('unit'));
    }
}
