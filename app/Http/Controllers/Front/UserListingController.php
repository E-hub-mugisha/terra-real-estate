<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ArchitecturalDesign;
use App\Models\DesignCategory;
use App\Models\Facility;
use App\Models\House;
use App\Models\Land;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\District;
use App\Models\Sector;
use App\Models\Cell;
use App\Models\HouseImage;
use App\Models\LandImage;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserListingController extends Controller
{
    // SELL PROPERTY FORM
    public function sellForm()
    {
        $facilities = Facility::all();
        $services = Service::all();
        $categories = DesignCategory::orderBy('name')->get();
        $provinces = Province::all();
        return view('front.properties.sell', compact('facilities', 'services', 'categories', 'provinces'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'title'              => 'required|string|max:255',
            'upi'                => 'nullable|string|max:100',
            'type'               => 'required|string|max:100',
            'price'              => 'required|numeric|min:0',
            'area_sqft'          => 'required|integer|min:1',
            'bedrooms'           => 'required|integer|min:0',
            'bathrooms'          => 'required|integer|min:0',
            'garages'            => 'required|integer',
            'description'        => 'required|string',
            'province'           => 'required|string|max:100',
            'district'           => 'nullable|string|max:100',
            'sector'             => 'nullable|string|max:20',
            'cell'               => 'required|string|max:100',
            'village'            => 'required|string|max:255',
            'images.*'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities'         => 'nullable|array',
            'facilities.*'       => 'exists:facilities,id',
            'condition'          => 'required|in:for_sale,for_rent',
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',
        ]);

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'password' => Hash::make('defaultpassword')]
        );

        // ── Transaction covers only DB writes ─────────────────────────────────
        $payment = DB::transaction(function () use ($request, $data, $user) {

            $house = House::create([
                'user_id'        => $user->id,
                'added_by'       => $user->id,
                'title'          => $data['title'],
                'upi'            => $data['upi'],
                'type'           => $data['type'],
                'price'          => $data['price'],
                'area_sqft'      => $data['area_sqft'],
                'status'         => 'available',
                'bedrooms'       => $data['bedrooms'],
                'bathrooms'      => $data['bathrooms'],
                'garages'        => $data['garages'],
                'description'    => $data['description'],
                'province'       => $data['province'],
                'district'       => $data['district'] ?? null,
                'sector'         => $data['sector'] ?? null,
                'cell'           => $data['cell'],
                'village'        => $data['village'],
                'condition'      => $data['condition'],
                'is_approved'    => false,
                'listing_status' => 'pending_payment',
                'listing_package_id' => $data['listing_package_id'],
                'listing_days' => $data['listing_days'],
            ]);

            // Facilities
            if ($request->filled('facilities')) {
                $house->facilities()->sync($request->facilities);
            }

            // Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $destinationPath = 'image/houses/';
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $image->move($destinationPath, $filename);

                    HouseImage::create([
                        'house_id'   => $house->id,
                        'image_path' => $filename,
                    ]);
                }
            }

            // Payment record
            $package = \App\Models\ListingPackage::findOrFail($data['listing_package_id']);

            return \App\Models\ListingPayment::create([
                'payable_type'       => House::class,
                'payable_id'         => $house->id,
                'user_id'            => $user->id,
                'listing_package_id' => $data['listing_package_id'],
                'payment_purpose'    => 'listing_fee',
                'amount'             => $package->price_per_day * $data['listing_days'],
                'currency'           => 'RWF',
                'status'             => 'pending',
            ]);
        }); // ← transaction closes here, $payment is now available

        // ── Redirect happens outside the transaction ───────────────────────────
        return redirect()
            ->route('payment.show', $payment->reference)
            ->with('success', 'House listing saved! Complete your payment to publish it.');
    }

    public function storeLand(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'    => 'required|numeric|min:0',
            'size_sqm'     => 'required|numeric|min:1',
            'zoning'       => 'required|in:R1,R2,R3,Commercial,Industrial,Agricultural',
            'land_use'     => 'nullable|string|max:100',
            'province'     => 'required|string|max:100',
            'district'     => 'required|string|max:100',
            'sector'       => 'required|string|max:100',
            'cell'         => 'required|string|max:100',
            'village'      => 'nullable|string|max:100',
            'condition'          => 'required|in:for_sale,for_rent',

            'upi' => 'nullable|string|max:100',
            'title_doc'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',

            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',
        ]);

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'password' => Hash::make('defaultpassword')]
        );

        $payment = DB::transaction(function () use ($request, $data, $user) {

            $land = Land::create([
                'user_id'     => $user->id,
                'title'        => $data['title'],
                'description'  => $data['description'],
                'price'    => $data['price'],
                'size_sqm'     => $data['size_sqm'],
                'zoning'       => $data['zoning'],
                'land_use'     => $data['land_use'],
                'status'         => 'available',
                'province'     => $data['province'],
                'district'     => $data['district'],
                'sector'       => $data['sector'],
                'cell'         => $data['cell'],
                'village'      => $data['village'],

                'upi' => $data['upi'] ?? null,
                'title_doc'    => $data['title_doc'] ?? null,
                'is_approved' => false, // Admin approval required
                'listing_status' => 'pending_payment',
                'listing_package_id' => $data['listing_package_id'],
                'listing_days' => $data['listing_days'],

            ]);

            // Save title document
            if ($request->hasFile('title_doc')) {
                $path = $request->file('title_doc')->store('land_titles', 'public');
                $land->update(['title_doc' => $path]);
            }

            // Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $destinationPath = 'image/lands/';
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $image->move($destinationPath, $filename);

                    LandImage::create([
                        'land_id'   => $land->id,
                        'image_path' => $filename,
                    ]);
                }
            }

            // Payment record
            $package = \App\Models\ListingPackage::findOrFail($data['listing_package_id']);

            return \App\Models\ListingPayment::create([
                'payable_type'       => Land::class,
                'payable_id'         => $land->id,
                'user_id'            => $user->id,
                'listing_package_id' => $data['listing_package_id'],
                'payment_purpose'    => 'listing_fee',
                'amount'             => $package->price_per_day * $data['listing_days'],
                'currency'           => 'RWF',
                'status'             => 'pending',
            ]);
        }); // ← transaction closes here, $payment is now available

        // ── Redirect happens outside the transaction ───────────────────────────
        return redirect()
            ->route('payment.show', $payment->reference)
            ->with('success', 'House listing saved! Complete your payment to publish it.');
    }

    // DESIGN REQUEST FORM
    public function storeArch(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'category_id'   => 'required|exists:design_categories,id',
            'description'   => 'nullable|string',
            'design_file'   => 'required|mimes:pdf,zip,dwg|max:20480',
            'preview_image' => 'nullable|image|max:4096',
            'price'         => 'nullable|numeric|min:0',
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',
        ]);

        $slug = Str::slug($request->title) . '-' . time();

        // Upload files
        $designFilePath = $request->file('design_file')
            ->store('architectural_designs/files', 'public');

        $previewPath = null;
        if ($request->hasFile('preview_image')) {
            $previewPath = $request->file('preview_image')
                ->store('architectural_designs/previews', 'public');
        }

        $user = User::firstOrCreate(
            ['email' => $request->email],
            ['name' => $request->name, 'password' => Hash::make('defaultpassword')]
        );

        $design = ArchitecturalDesign::create([
            'title'          => $request->title,
            'slug'           => $slug,
            'user_id'        => $user->id,
            'category_id'    => $request->category_id,
            'description'    => $request->description,
            'design_file'    => $designFilePath,
            'preview_image'  => $previewPath,
            'price'          => $request->price ?? 0,
            'is_free'        => $request->price == 0,
            'featured'       => $request->has('featured'),
            'listing_days'       => $request->listing_days,
            'listing_package_id' => $request->listing_package_id,
            'listing_status' => 'pending_payment',
        ]);

        // ── Resolve listing fee from the chosen package ────────────────────────
        $package    = \App\Models\ListingPackage::findOrFail($request->listing_package_id);
        $listingFee = $package->price_per_day * $request->listing_days; // e.g. 15000 RWF

        // ── Create the pending payment record ─────────────────────────────────
        $payment = \App\Models\ListingPayment::create([
            'payable_type'    => ArchitecturalDesign::class,       // polymorphic type
            'payable_id'      => $design->id,         // polymorphic id
            'user_id'         => $user->id,
            'payment_purpose' => 'listing_fee',
            'amount'          => $listingFee,
            'currency'        => 'RWF',
            'status'          => 'pending',
        ]);

        // ── Redirect to payment page ───────────────────────────────────────────
        return redirect()
            ->route('payment.show', $payment->reference)
            ->with('success', 'house listing saved! Complete your payment to publish it.');
    }

    public function getDistricts($provinceId)
    {
        return response()->json(District::where('province_id', $provinceId)->get());
    }

    public function getSectors($districtId)
    {
        return response()->json(Sector::where('district_id', $districtId)->get());
    }

    public function getCells($sectorId)
    {
        return response()->json(Cell::where('sector_id', $sectorId)->get());
    }

    public function getVillages($cellId)
    {
        return response()->json(Village::where('cell_id', $cellId)->get());
    }
}
