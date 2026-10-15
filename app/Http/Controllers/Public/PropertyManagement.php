<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ManagedProperty;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Service;
use App\Models\TenantApplication;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PropertyManagement extends Controller
{
    public function home(Request $request)
    {
        $filters = $request->validate([
            'property' => ['nullable', 'integer'],
            'type'     => ['nullable', 'string', 'max:50'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:20'],
            'min_rent' => ['nullable', 'numeric', 'min:0'],
            'max_rent' => ['nullable', 'numeric', 'min:0'],
            'q'        => ['nullable', 'string', 'max:100'],
            'sort'     => ['nullable', 'in:newest,price_asc,price_desc,size_desc'],
        ]);
 
        $sort = $filters['sort'] ?? 'newest';
 
        $units = Unit::query()
            ->with(['managedProperty', 'building', 'floor'])
            ->where('status', 'available')
            ->when($filters['property'] ?? null, fn ($q, $v) => $q->where('managed_property_id', $v))
            ->when($filters['type'] ?? null, fn ($q, $v) => $q->where('unit_type', $v))
            ->when(isset($filters['bedrooms']) && $filters['bedrooms'] !== null, function ($q) use ($filters) {
                $beds = (int) $filters['bedrooms'];
 
                // "4" in the dropdown means 4 or more
                return $beds >= 4
                    ? $q->where('bedrooms', '>=', 4)
                    : $q->where('bedrooms', $beds);
            })
            ->when($filters['min_rent'] ?? null, fn ($q, $v) => $q->where('monthly_rent', '>=', $v))
            ->when($filters['max_rent'] ?? null, fn ($q, $v) => $q->where('monthly_rent', '<=', $v))
            ->when($filters['q'] ?? null, function ($q, $term) {
                $q->where(function ($sub) use ($term) {
                    $sub->where('unit_number', 'like', "%{$term}%")
                        ->orWhere('unit_type', 'like', "%{$term}%")
                        ->orWhere('description', 'like', "%{$term}%");
                });
            })
            ->when($sort === 'price_asc', fn ($q) => $q->orderBy('monthly_rent'))
            ->when($sort === 'price_desc', fn ($q) => $q->orderByDesc('monthly_rent'))
            ->when($sort === 'size_desc', fn ($q) => $q->orderByDesc('area_sqm'))
            ->when($sort === 'newest', fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();
 
        // Headline numbers
        $managedProperties  = ManagedProperty::count();
        $totalUnits         = Unit::count();
        $availableUnitCount = Unit::where('status', 'available')->count();
        $occupiedUnitCount  = Unit::where('status', 'occupied')->count();
        $occupancyRate      = $totalUnits > 0 ? round(($occupiedUnitCount / $totalUnits) * 100) : 0;
        $startingRent       = Unit::where('status', 'available')->where('monthly_rent', '>', 0)->min('monthly_rent');
 
        // Filter dropdown sources
        $unitTypes = Unit::where('status', 'available')
            ->whereNotNull('unit_type')
            ->distinct()
            ->orderBy('unit_type')
            ->pluck('unit_type');
 
        $filterProperties = ManagedProperty::all();
 
        // Managed property showcase (requires ManagedProperty::units() hasMany)
        $properties = ManagedProperty::query()
            ->withCount([
                'units',
                'units as available_units_count' => fn ($q) => $q->where('status', 'available'),
            ])
            ->latest()
            ->take(6)
            ->get();
 
        return view('public.home', compact(
            'units',
            'filters',
            'sort',
            'unitTypes',
            'filterProperties',
            'properties',
            'managedProperties',
            'totalUnits',
            'availableUnitCount',
            'occupancyRate',
            'startingRent'
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

    public function create(Unit $unit)
    {
        abort_unless(
            strtolower((string) $unit->status) === 'available',
            404,
            'This rental unit is no longer available.'
        );

        $user = Auth::user();
        $tenant = $user?->tenantProfile;

        return view('public.rental-apply', compact(
            'unit',
            'user',
            'tenant'
        ));
    }

    public function store(Request $request, Unit $unit)
    {
        abort_unless(
            strtolower((string) $unit->status) === 'available',
            404,
            'This rental unit is no longer available.'
        );

        $user = $request->user();

        if ($user && !in_array($user->role, ['user', 'tenant'], true)) {
            abort(403, 'This account cannot submit a rental application.');
        }

        $existingTenant = $user?->tenantProfile;

        $rules = [
            'desired_move_in_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],
            'number_of_occupants' => [
                'required',
                'integer',
                'min:1',
                'max:50',
            ],
            'offered_monthly_rent' => [
                'nullable',
                'numeric',
                'min:0',
                'max:9999999999999',
            ],
            'employment_status' => [
                'nullable',
                'string',
                'max:100',
            ],
            'additional_information' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];

        // Collect personal details if this account has no tenant profile.
        if (!$existingTenant) {
            $rules = array_merge($rules, [
                'first_name' => ['required', 'string', 'max:100'],
                'last_name' => ['required', 'string', 'max:100'],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email'),
                ],
                'phone' => ['required', 'string', 'max:30'],
                'address' => ['nullable', 'string', 'max:255'],
            ]);

            if (!$user) {
                $rules['password'] = [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ];
            }
        }

        $validated = $request->validate($rules);

        $application = DB::transaction(function () use (
            $validated,
            $unit,
            $user,
            $existingTenant
        ) {
            // Lock the unit while checking availability to reduce
            // the chance of concurrent applications using stale data.
            $lockedUnit = Unit::whereKey($unit->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (strtolower((string) $lockedUnit->status) !== 'available') {
                throw ValidationException::withMessages([
                    'unit' => 'This unit is no longer available.',
                ]);
            }

            $account = $user;

            if (!$account) {
                // A guest must use a new email address here.
                // Existing account holders should sign in first.
                $account = User::create([
                    'name' => trim(
                        $validated['first_name'] . ' ' .
                        $validated['last_name']
                    ),
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role' => 'tenant',
                ]);
            } elseif ($account->role === 'user') {
                // Promote a regular customer account to tenant when
                // they begin using the rental-management portal.
                $account->role = 'tenant';
                $account->save();
            }

            $tenant = $existingTenant;

            if (!$tenant) {
                $nameParts = [
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                ];

                $tenant = Tenant::create(array_merge($nameParts, [
                    'user_id' => $account->id,
                    'tenant_code' => $this->generateTenantCode(),
                    'email' => $account->email,
                    'phone' => $validated['phone'],
                    'address' => $validated['address'] ?? null,
                    'status' => 'active',
                    'notes' => 'Tenant profile created through a rental application.',
                ]));
            }

            // Prevent the same tenant from submitting multiple
            // applications for the same unit while one is pending
            // or being reviewed.
            $duplicate = TenantApplication::where('tenant_id', $tenant->id)
                ->where('unit_id', $lockedUnit->id)
                ->whereIn('status', ['pending', 'under_review', 'approved'])
                ->exists();

            if ($duplicate) {
                throw ValidationException::withMessages([
                    'unit' => 'You already have an application for this unit.',
                ]);
            }

            return TenantApplication::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $lockedUnit->id,
                'application_number' => $this->generateApplicationNumber(),
                'application_date' => now()->toDateString(),
                'desired_move_in_date' =>
                    $validated['desired_move_in_date'] ?? null,
                'number_of_occupants' => $validated['number_of_occupants'],
                'offered_monthly_rent' =>
                    $validated['offered_monthly_rent']
                    ?? $lockedUnit->monthly_rent,
                'currency' => $lockedUnit->currency ?: 'RWF',
                'employment_status' =>
                    $validated['employment_status'] ?? null,
                'additional_information' =>
                    $validated['additional_information'] ?? null,
                'status' => 'pending',
            ]);
        });

        // Automatically sign in a newly created applicant.
        if (!$user) {
            Auth::login($account = User::whereHas('tenantProfile', function ($query) use ($application) {
                $query->where('id', $application->tenant_id);
            })->firstOrFail());

            $request->session()->regenerate();
        }

        return redirect()
            ->route('tenant-portal.applications.index')
            ->with(
                'success',
                'Your rental application was submitted successfully. '
                . 'Application number: ' . $application->application_number
            );
    }

    private function generateTenantCode(): string
    {
        do {
            $code = 'TEN-' . now()->format('Y') . '-'
                . Str::upper(Str::random(8));
        } while (Tenant::where('tenant_code', $code)->exists());

        return $code;
    }

    private function generateApplicationNumber(): string
    {
        do {
            $number = 'APP-' . now()->format('Ymd') . '-'
                . Str::upper(Str::random(8));
        } while (TenantApplication::where(
            'application_number',
            $number
        )->exists());

        return $number;
    }
}
