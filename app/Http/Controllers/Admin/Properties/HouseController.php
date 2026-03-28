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
            'upi'         => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'required|integer|min:1',
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

            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities'  => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',

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

    public function show(string $id)
    {
        $house = House::with([
            'facilities',
            'user',
            'planOrders.plan',
            'planOrders.payment'
        ])->findOrFail($id);
        return view('admin.property.house.show', compact('house'));
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
        return view('admin.property.house.edit', compact('house', 'facilities'));
    }

    public function update(Request $request, House $house)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'upi'         => 'nullable|string|max:100',
            'type'        => 'required|in:house,apartment,villa,townhouse',
            'status'      => 'required|in:available,reserved,sold',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'required|numeric|min:1',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'garages'     => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'province'    => 'required|string|max:100',
            'district'    => 'required|string|max:100',
            'sector'      => 'required|string|max:100',
            'cell'        => 'required|string|max:100',
            'village'     => 'nullable|string|max:100',
            'images'          => 'nullable|array',
            'images.*'        => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'integer|exists:house_images,id',
            'facilities'      => 'nullable|array',
            'facilities.*'    => 'exists:facilities,id',
            // ── new fields ────────────────────────────────────────────
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            // owner info
            'owner_name'         => 'required|string|max:255',
            'owner_email'        => 'nullable|email|max:255',
            'owner_phone'        => 'required|string|max:30',
            'owner_id_number'    => 'nullable|string|max:50',
        ]);

        // Delete marked images
        if (!empty($data['delete_images'])) {
            HouseImage::whereIn('id', $data['delete_images'])
                ->where('house_id', $house->id)
                ->get()
                ->each(fn($img) => Storage::disk('public')->delete($img->image_path) && $img->delete());
        }

        // Upload new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                HouseImage::create([
                    'house_id'   => $house->id,
                    'image_path' => $image->store('houses', 'public'),
                ]);
            }
        }

        // Sync facilities
        $house->facilities()->sync($data['facilities'] ?? []);

        // Remove non-column keys then save
        unset($data['delete_images'], $data['images'], $data['facilities']);
        $house->update($data);

        return redirect()
            ->route('admin.properties.houses.edit', $house->id)
            ->with('success', '✅ House property updated successfully.');
    }

    public function destroy(House $house)
    {
        $house->delete();

        return back()->with('success', 'house deleted successfully.');
    }
}
