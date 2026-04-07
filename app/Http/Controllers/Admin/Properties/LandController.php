<?php

namespace App\Http\Controllers\Admin\Properties;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\LandImage;
use App\Models\ListingPackage;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class LandController extends Controller
{
    public function index()
    {
        $lands = Land::latest()->paginate(10);
        return view('admin.property.land.index', compact('lands'));
    }

    public function create()
    {
        $packages   = ListingPackage::where('listing_type', 'land')
            ->orderByRaw("FIELD(package_tier,'basic','medium','standard')")
            ->get();
        return view('admin.property.land.create', compact('packages'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'    => 'required|numeric|min:0',
            'size_sqm'     => 'required|numeric|min:1',
            'zoning'       => 'required|in:R1,R2,R3,R4,Commercial,Industrial,Agricultural',
            'land_use'     => 'nullable|string|max:100',
            'province'     => 'required|string|max:100',
            'district'     => 'required|string|max:100',
            'sector'       => 'required|string|max:100',
            'cell'         => 'required|string|max:100',
            'village'      => 'nullable|string|max:100',

            'upi' => 'nullable|string|max:100',
            'title_doc'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'condition'       => 'required',

            // ── new fields ────────────────────────────────────────────
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            // owner info
            'owner_name'         => 'required|string|max:255',
            'owner_email'        => 'nullable|email|max:255',
            'owner_phone'        => 'required|string|max:30',
            'owner_id_number'    => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('title_doc')) {
            $data['title_doc_path'] = $request->file('title_doc')->store('land_titles', 'public');
        }

        $data['user_id'] = auth()->id();
        $data['added_by'] = Auth::id();
        $data['status'] = 'available';
        $data['listing_status'] = 'pending_payment'; // ← locked until paid

        $land = Land::create($data);

        // ✅ Upload images (FIXED FOR SHARED HOSTING)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {  // ✅ removed the bad assignment
                $destinationPath = 'image/lands/';

                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $image->move($destinationPath, $filename);  // ✅ now correctly calls move() on the single file

                LandImage::create([
                    'land_id'   => $land->id,
                    'image_path' => $filename
                ]);
            }
        }

        // ── Resolve listing fee from the chosen package ────────────────────────
        $package    = \App\Models\ListingPackage::findOrFail($data['listing_package_id']);
        $listingFee = $package->price_per_day * $data['listing_days']; // e.g. 15000 RWF

        // ── Create the pending payment record ─────────────────────────────────
        $payment = \App\Models\ListingPayment::create([
            'payable_type'    => Land::class,       // polymorphic type
            'payable_id'      => $land->id,         // polymorphic id
            'user_id'         => auth()->id(),
            'payment_purpose' => 'listing_fee',
            'amount'          => $listingFee,
            'currency'        => 'RWF',
            'status'          => 'pending',
        ]);

        // ── Redirect to payment page ───────────────────────────────────────────
        return redirect()
            ->route('payment.show', $payment->reference)
            ->with('success', 'Land listing saved! Complete your payment to publish it.');
    }

    public function show(Request $request, string $id)
    {
        $land = Land::with([
            'user',
            'images',
            'service',
            'planOrders.plan',
            'planOrders.payment'
        ])->findOrFail($id);

        $land->recordView($request);

        $viewStats = [
            'total'       => $land->views_count,
            'unique'      => $land->unique_views_count,
            'today'       => $land->viewsToday(),
            'this_week'   => $land->viewsThisWeek(),
            'this_month'  => $land->viewsThisMonth(),
            'daily_chart' => $land->dailyViewsForPast(14),
        ];
        return view('admin.property.land.show', compact('land', 'viewStats'));
    }

    public function approve(Land $land)
    {
        if ($land->is_approved) {
            return back()->with('info', 'Land is already approved.');
        }

        $land->update(['is_approved' => true]);

        return back()->with('success', 'Land approved successfully.');
    }

    /**
     * Upload images for a land property.
     */
    public function uploadImages(Request $request, Land $land)
    {
        $request->validate([
            'images'   => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5120'],
        ]);

        $destinationPath = public_path('image/lands/');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        foreach ($request->file('images') as $image) {

            $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

            $image->move($destinationPath, $filename);

            LandImage::create([
                'land_id'    => $land->id,
                'image_path' => $filename
            ]);
        }

        return back()->with('success', count($request->file('images')) . ' photo(s) uploaded successfully.');
    }

    /**
     * Download all images for a land property as a ZIP.
     */
    public function downloadImages(Land $land)
    {
        $images = $land->images;

        if ($images->isEmpty()) {
            return back()->with('error', 'This property has no images to download.');
        }

        $tempDir = storage_path('app/temp');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipName = 'land-' . $land->id . '-photos.zip';
        $zipPath = $tempDir . DIRECTORY_SEPARATOR . $zipName;

        // Clean up any leftover zip from a previous attempt
        if (file_exists($zipPath)) {
            unlink($zipPath);
        }

        $zip = new ZipArchive();

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Could not create ZIP file.');
        }

        $added = 0;

        foreach ($images as $index => $image) {
            $fullPath = public_path('image/lands/' . $image->image_path);

            // Debug: log the path so you can verify it during testing
            \Log::info('ZIP image path: ' . $fullPath . ' | exists: ' . (file_exists($fullPath) ? 'yes' : 'NO'));

            if (file_exists($fullPath)) {
                $ext      = pathinfo($fullPath, PATHINFO_EXTENSION);
                $filename = 'photo-' . ($index + 1) . '.' . $ext;
                $zip->addFile($fullPath, $filename);
                $added++;
            }
        }

        $zip->close();

        // Guard: no files were found at the expected paths
        if ($added === 0 || !file_exists($zipPath)) {
            return back()->with('error', 'No image files were found on disk for this property.');
        }

        return response()->download($zipPath, $zipName)->deleteFileAfterSend(true);
    }

    /**
     * Show the edit form for a land property.
     */
    public function edit(Land $land)
    {
        $packages   = ListingPackage::where('listing_type', 'land')
            ->orderByRaw("FIELD(package_tier,'basic','medium','standard')")
            ->get();
        return view('admin.property.land.edit', compact('land', 'packages'));
    }

    /**
     * Update a land property.
     */

    public function update(Request $request, Land $land)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'size_sqm'     => 'required|numeric|min:1',
            'zoning'       => 'required|in:R1,R2,R3,R4,Commercial,Industrial,Agricultural',
            'land_use'     => 'nullable|string|max:100',
            'province'     => 'required|string|max:100',
            'district'     => 'required|string|max:100',
            'sector'       => 'required|string|max:100',
            'cell'         => 'required|string|max:100',
            'village'      => 'nullable|string|max:100',
            'upi'          => 'nullable|string|max:100',

            'title_doc'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'condition'    => 'required',

            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',

            'owner_name'      => 'required|string|max:255',
            'owner_email'     => 'nullable|email|max:255',
            'owner_phone'     => 'required|string|max:30',
            'owner_id_number' => 'nullable|string|max:50',

            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // =========================================================
        // ✅ DELETE SELECTED IMAGES
        // =========================================================
        if ($request->filled('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = LandImage::find($imageId);

                if ($image) {
                    $filePath = public_path('image/lands/' . $image->image_path);

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

            $destinationPath = public_path('image/lands/');

            // create folder if not exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            foreach ($request->file('images') as $image) {

                // generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // move file
                $image->move($destinationPath, $filename);

                // save to DB
                LandImage::create([
                    'land_id'    => $land->id,
                    'image_path' => $filename
                ]);
            }
        }

        // =========================================================
        // ✅ HANDLE TITLE DOCUMENT
        // =========================================================

        // delete existing
        if ($request->input('delete_title_doc') === '1' && $land->title_doc_path) {
            Storage::disk('public')->delete($land->title_doc_path);
            $data['title_doc_path'] = null;
        }

        // replace
        if ($request->hasFile('title_doc')) {
            if ($land->title_doc_path) {
                Storage::disk('public')->delete($land->title_doc_path);
            }

            $data['title_doc_path'] = $request->file('title_doc')
                ->store('land_titles', 'public');
        }

        // =========================================================
        // ✅ CLEAN DATA
        // =========================================================
        unset($data['delete_images'], $data['delete_title_doc'], $data['images']);

        // =========================================================
        // ✅ UPDATE LAND
        // =========================================================
        $land->update($data);

        return redirect()
            ->route('admin.properties.lands.show', $land->id)
            ->with('success', 'Land property updated successfully.');
    }
    // Controller method
    public function deleteImage(Land $land, LandImage $image)
    {
        if ($image->land_id !== $land->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
    public function destroy(Land $land)
    {
        $land->delete();

        return back()->with('success', 'Land deleted successfully.');
    }
}
