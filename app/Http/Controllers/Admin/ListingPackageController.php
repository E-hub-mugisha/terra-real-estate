<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ListingPackage;
use Illuminate\Http\Request;

class ListingPackageController extends Controller
{
    // List all packages
    public function index()
    {
        $packages = ListingPackage::orderBy('listing_type')
            ->orderByRaw("FIELD(package_tier, 'basic', 'medium', 'standard')")
            ->get()
            ->groupBy('listing_type');

        return view('admin.listing-packages.index', compact('packages'));
    }

    // Show create form
    public function create()
    {
        $listingTypes = ListingPackage::listingTypes();
        $packageTiers = ListingPackage::packageTiers();

        return view('admin.listing-packages.create', compact('listingTypes', 'packageTiers'));
    }

    // Store new package
    public function store(Request $request)
    {
        $validated = $request->validate([
            'listing_type'         => 'required|in:land_sale,land_rent,house_sale,house_rent,design,tender,advertisement,job,announcement',
            'package_tier'         => 'required|in:basic,medium,standard',
            'price_per_day'        => 'required|integer|min:1',
            'agent_commission_pct' => 'required|numeric|min:0|max:100',
            'terra_share_pct'      => 'required|numeric|min:0|max:100',
            'features'             => 'nullable|string',
            'is_active'            => 'boolean',
        ]);

        // Convert features textarea to array
        if (!empty($validated['features'])) {
            $validated['features'] = json_encode(
                array_filter(array_map('trim', explode("\n", $validated['features'])))
            );
        }

        $validated['is_active'] = (bool) $request->boolean('is_active');

        // Check for duplicate
        $exists = ListingPackage::where('listing_type', $validated['listing_type'])
            ->where('package_tier', $validated['package_tier'])
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'package_tier' => 'A package for this listing type and tier already exists.'
            ]);
        }

        ListingPackage::create($validated);

        return redirect()
            ->route('admin.listing-packages.index')
            ->with('success', 'Listing package created successfully.');
    }

    // Show single package
    public function show(ListingPackage $listingPackage)
    {
        return view('admin.listing-packages.show', compact('listingPackage'));
    }

    // Show edit form
    public function edit(ListingPackage $listingPackage)
    {
        $listingTypes = ListingPackage::listingTypes();
        $packageTiers = ListingPackage::packageTiers();

        return view('admin.listing-packages.edit', compact('listingPackage', 'listingTypes', 'packageTiers'));
    }

    // Update package
    public function update(Request $request, ListingPackage $listingPackage)
    {
        $validated = $request->validate([
            'listing_type'         => 'required|in:land_sale,land_rent,house_sale,house_rent,design,tender,advertisement,job,announcement',
            'package_tier'         => 'required|in:basic,medium,standard',
            'price_per_day'        => 'required|integer|min:1',
            'agent_commission_pct' => 'required|numeric|min:0|max:100',
            'terra_share_pct'      => 'required|numeric|min:0|max:100',
            'features'             => 'nullable|string',
            'is_active'            => 'boolean',
        ]);

        // Convert features textarea to array
        if (!empty($validated['features'])) {
            $validated['features'] = json_encode(
                array_filter(array_map('trim', explode("\n", $validated['features'])))
            );
        } else {
            $validated['features'] = null;
        }

        // Cast to true boolean — hidden field guarantees 0 or 1 is always submitted
        $validated['is_active'] = (bool) $request->boolean('is_active');

        // Check duplicate (excluding current record)
        $exists = ListingPackage::where('listing_type', $validated['listing_type'])
            ->where('package_tier', $validated['package_tier'])
            ->where('id', '!=', $listingPackage->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'package_tier' => 'A package for this listing type and tier already exists.'
            ]);
        }

        $listingPackage->update($validated);

        return redirect()
            ->route('admin.listing-packages.index')
            ->with('success', 'Listing package updated successfully.');
    }

    // Delete package
    public function destroy(ListingPackage $listingPackage)
    {
        $listingPackage->delete();

        return redirect()
            ->route('admin.listing-packages.index')
            ->with('success', 'Listing package deleted successfully.');
    }
}
