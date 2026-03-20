<?php

namespace App\Http\Controllers\Admin\Properties;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\LandImage;
use App\Models\Service;
use Illuminate\Http\Request;
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
        $services = Service::all();
        return view('admin.property.land.create', compact('services'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'    => 'required|numeric|min:0',
            'size_sqm'     => 'required|numeric|min:1',
            'zoning'       => 'required|in:R1,R2,R3,Commercial,Industrial,Agricultural',
            'land_use'     => 'nullable|string|max:100',
            'service_id' => 'required|exists:services,id',
            'province'     => 'required|string|max:100',
            'district'     => 'required|string|max:100',
            'sector'       => 'required|string|max:100',
            'cell'         => 'required|string|max:100',
            'village'      => 'nullable|string|max:100',

            'upi' => 'nullable|string|max:100',
            'title_doc'    => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'status'       => 'required|in:available,reserved,sold',
        ]);

        if ($request->hasFile('title_doc')) {
            $data['title_doc_path'] = $request->file('title_doc')->store('land_titles', 'public');
        }

        $data['user_id'] = auth()->id();
        $data['status'] = 'available';
        $data['service_id']  = $data['service_id'];

        $land = Land::create($data);

        // Upload images
        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('lands', 'public');

                LandImage::create([
                    'land_id' => $land->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route(
            'plans.select',
            [
                'id' => $land->id,
                'type' => 'land'
            ]
        )->with('success', '🌍 Land listed successfully and sent for approval.');
    }

    public function show(string $id)
    {
        $land = Land::with([
            'user',
            'images',
            'service',
            'planOrders.plan',
            'planOrders.payment'
        ])->findOrFail($id);
        return view('admin.property.land.show', compact('land'));
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

        foreach ($request->file('images') as $file) {
            $path = $file->store('lands/images', 'public');

            LandImage::create([
                'land_id'    => $land->id,
                'image_path' => $path,
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

    /**
     * Show the edit form for a land property.
     */
    public function edit(Land $land)
    {
        $services = Service::all();
        return view('admin.property.land.edit', compact('land','services'));
    }

    /**
     * Update a land property.
     */

    public function update(Request $request, Land $land)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'size_sqm'    => 'required|numeric|min:1',
            'zoning'      => 'required|in:R1,R2,R3,Commercial,Industrial,Agricultural',
            'land_use'    => 'required|string|max:100',
            'service_id'  => 'required|exists:services,id',
            'province'    => 'required|string|max:100',
            'district'    => 'required|string|max:100',
            'sector'      => 'required|string|max:100',
            'cell'        => 'required|string|max:100',
            'village'     => 'nullable|string|max:100',
            'upi'         => 'nullable|string|max:100',
            'title_doc'   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'status'      => 'required|in:available,reserved,sold',
            'images'      => 'nullable|array',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'integer|exists:land_images,id',
            'delete_title_doc'=> 'nullable|in:0,1',
        ]);

        // ── Delete marked images ──────────────────────────────────────
        if (!empty($data['delete_images'])) {
            $toDelete = LandImage::whereIn('id', $data['delete_images'])
                ->where('land_id', $land->id)
                ->get();

            foreach ($toDelete as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // ── Remove title deed if flagged ──────────────────────────────
        if ($request->input('delete_title_doc') === '1' && $land->title_doc_path) {
            Storage::disk('public')->delete($land->title_doc_path);
            $data['title_doc_path'] = null;
        }

        // ── Replace title deed if a new file was uploaded ─────────────
        if ($request->hasFile('title_doc')) {
            if ($land->title_doc_path) {
                Storage::disk('public')->delete($land->title_doc_path);
            }
            $data['title_doc_path'] = $request->file('title_doc')
                ->store('land_titles', 'public');
        }

        // ── Upload new images ─────────────────────────────────────────
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                LandImage::create([
                    'land_id'    => $land->id,
                    'image_path' => $image->store('lands', 'public'),
                ]);
            }
        }

        // ── Strip non-column keys before saving ───────────────────────
        unset($data['delete_images'], $data['delete_title_doc'], $data['delete_title_doc'], $data['images']);

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
