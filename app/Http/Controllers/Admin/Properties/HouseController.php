<?php

namespace App\Http\Controllers\Admin\Properties;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\House;
use App\Models\HouseImage;
use App\Models\ListingPackage;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::with('images')->paginate(10);

        return view('admin.property.house.index', compact('houses'));
    }

    public function create()
    {
        $facilities = Facility::all();
        $packages   = ListingPackage::where('listing_type', 'house')
            ->orderByRaw("FIELD(package_tier,'basic','medium','standard')")
            ->get();
        return view('admin.property.house.create', compact('facilities', 'packages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'upi'         => 'nullable|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'nullable|integer|min:1',
            'condition'      => 'required|in:for_rent,for_sale',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'garages'     => 'required|integer|min:0',
            'description' => 'required|string',

            'province'    => 'required|string|max:100',
            'district'    => 'nullable|string|max:100',
            'sector'      => 'nullable|string|max:20',
            'cell'        => 'required|string|max:100',
            'village'     => 'required|string|max:255',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',

            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities'  => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'video_url' => ['nullable', 'url', 'max:500'],

            // ── new fields ────────────────────────────────────────────
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            // owner info
            'owner_name'         => 'required|string|max:255',
            'owner_email'        => 'nullable|email|max:255',
            'owner_phone'        => 'required|string|max:30',
            'owner_id_number'    => 'nullable|string|max:50',
        ]);

        $data['user_id'] = auth()->id();
        $data['added_by'] = Auth::id();
        $data['status'] = 'available';
        $data['listing_status'] = 'pending_payment'; // ← locked until paid

        $house = House::create($data);
        // Facilities
        if ($request->filled('facilities')) {
            $house->facilities()->sync($request->facilities);
        }

        // ✅ Upload images (FIXED FOR SHARED HOSTING)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {  // ✅ removed the bad assignment
                $destinationPath = 'image/houses/';

                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $filename);  // ✅ now correctly calls move() on the single file

                HouseImage::create([
                    'house_id'   => $house->id,
                    'image_path' => $filename
                ]);
            }
        }

        // ── Resolve listing fee from the chosen package ────────────────────────
        $package    = \App\Models\ListingPackage::findOrFail($data['listing_package_id']);
        $listingFee = $package->price_per_day * $data['listing_days']; // e.g. 15000 RWF

        // ── Create the pending payment record ─────────────────────────────────
        $payment = \App\Models\ListingPayment::create([
            'payable_type'    => House::class,       // polymorphic type
            'payable_id'      => $house->id,         // polymorphic id
            'user_id'         => auth()->id(),
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

    public function show(Request $request, string $id)
    {
        $house = House::with([
            'facilities',
            'user',
            'planOrders.plan',
            'planOrders.payment'
        ])->findOrFail($id);

        $house->recordView($request);

        $viewStats = [
            'total'       => $house->views_count,
            'unique'      => $house->unique_views_count,
            'today'       => $house->viewsToday(),
            'this_week'   => $house->viewsThisWeek(),
            'this_month'  => $house->viewsThisMonth(),
            'daily_chart' => $house->dailyViewsForPast(14),
        ];
        return view('admin.property.house.show', compact('house', 'viewStats'));
    }

    public function approve(House $house)
    {
        if ($house->is_approved) {
            return back()->with('info', 'House is already approved.');
        }

        $house->update(['is_approved' => true]);

        return back()->with('success', 'House approved successfully.');
    }

    // Controller methods — same logic as houseController, just swap house/houseImage → House/HouseImage
    public function uploadImages(Request $request, House $house)
    {
        $request->validate(['images' => ['required', 'array'], 'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:5120']]);
        foreach ($request->file('images') as $file) {
            HouseImage::create(['house_id' => $house->id, 'image_path' => $file->store('houses/images', 'public')]);
        }
        return back()->with('success', count($request->file('images')) . ' photo(s) uploaded.');
    }

    public function downloadImages(House $house)
    {
        $images = $house->images;

        if ($images->isEmpty()) {
            return back()->with('error', 'This property has no images to download.');
        }

        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipName = 'house-' . $house->id . '-photos.zip';
        $zipPath = $tempDir . DIRECTORY_SEPARATOR . $zipName;

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Could not create ZIP file.');
        }

        foreach ($images as $index => $image) {
            $fullPath = Storage::disk('public')->path($image->image_path);

            if (file_exists($fullPath)) {
                $ext      = pathinfo($fullPath, PATHINFO_EXTENSION);
                $filename = 'photo-' . ($index + 1) . '.' . $ext;
                $zip->addFile($fullPath, $filename);
            }
        }

        $zip->close();

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }
    public function deleteImage(House $house, HouseImage $image)
    {
        /* same delete logic */
        if ($image->house_id !== $house->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function edit(House $house)
    {
        $facilities = Facility::all();
        $packages   = ListingPackage::where('listing_type', 'house')
            ->orderByRaw("FIELD(package_tier,'basic','medium','standard')")
            ->get();
        return view('admin.property.house.edit', compact('house', 'facilities', 'packages'));
    }

    public function update(Request $request, House $house)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'upi'         => 'nullable|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'nullable|integer|min:1',
            'condition'   => 'required|in:for_rent,for_sale',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'garages'     => 'required|integer|min:0',
            'description' => 'required|string',

            'province'    => 'required|string|max:100',
            'district'    => 'nullable|string|max:100',
            'sector'      => 'nullable|string|max:20',
            'cell'        => 'required|string|max:100',
            'village'     => 'required|string|max:255',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',

            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'video_url'   => 'nullable|url|max:500',

            'facilities'   => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',

            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            'owner_name'      => 'required|string|max:255',
            'owner_email'     => 'nullable|email|max:255',
            'owner_phone'     => 'required|string|max:30',
            'owner_id_number' => 'nullable|string|max:50',
        ]);

        // =========================================================
        // ✅ UPDATE BASIC DATA
        // =========================================================
        $house->update($data);

        // =========================================================
        // ✅ SYNC FACILITIES
        // =========================================================
        if ($request->filled('facilities')) {
            $house->facilities()->sync($request->facilities);
        } else {
            $house->facilities()->sync([]);
        }

        // =========================================================
        // ✅ DELETE SELECTED IMAGES
        // =========================================================
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = HouseImage::find($imageId);

                if ($image) {
                    $filePath = public_path('image/houses/' . $image->image_path);

                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    $image->delete();
                }
            }
        }

        // =========================================================
        // ✅ UPLOAD NEW IMAGES
        // =========================================================
        if ($request->hasFile('images')) {

            $destinationPath = public_path('image/houses/');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {

                $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

                $image->move($destinationPath, $filename);

                HouseImage::create([
                    'house_id'   => $house->id,
                    'image_path' => $filename
                ]);
            }
        }

        // =========================================================
        // ✅ OPTIONAL: UPDATE LISTING PAYMENT IF CHANGED
        // =========================================================
        if (
            $house->listing_package_id != $data['listing_package_id'] ||
            $house->listing_days != $data['listing_days']
        ) {
            $package = \App\Models\ListingPackage::findOrFail($data['listing_package_id']);
            $listingFee = $package->price_per_day * $data['listing_days'];

            // update existing pending payment OR create new one
            $payment = \App\Models\ListingPayment::where('payable_type', House::class)
                ->where('payable_id', $house->id)
                ->where('status', 'pending')
                ->latest()
                ->first();

            if ($payment) {
                $payment->update([
                    'amount' => $listingFee
                ]);
            } else {
                $payment = \App\Models\ListingPayment::create([
                    'payable_type'    => House::class,
                    'payable_id'      => $house->id,
                    'user_id'         => auth()->id(),
                    'payment_purpose' => 'listing_fee',
                    'amount'          => $listingFee,
                    'currency'        => 'RWF',
                    'status'          => 'pending',
                ]);
            }
        }

        // =========================================================
        // ✅ REDIRECT
        // =========================================================
        return redirect()
            ->route('admin.properties.houses.show', $house->id)
            ->with('success', 'House updated successfully.');
    }

    public function destroy(House $house)
    {
        $house->delete();

        return redirect()->route('admin.properties.houses.index')->with('success', 'house deleted successfully.');
    }

    public function updateStatus(Request $request, House $house)
    {
        $request->validate([
            'status' => 'required|in:available,reserved,sold'
        ]);

        $house->update(['status' => $request->status]);

        return back()->with('success', 'House status updated to ' . $request->status . '.');
    }
}
