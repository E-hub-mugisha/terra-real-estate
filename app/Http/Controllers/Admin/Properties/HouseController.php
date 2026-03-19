<?php

namespace App\Http\Controllers\Admin\Properties;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\House;
use App\Models\HouseImage;
use App\Models\Service;
use Illuminate\Http\Request;
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
        $services = Service::all();
        return view('admin.property.house.create', compact('facilities', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'upi'       => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'required|integer|min:1',
            'status'      => 'required|in:available,reserved,sold',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'garages'     => 'required|integer|min:0',
            'description' => 'required|string',

            'province'    => 'required|string|max:100',
            'district'       => 'nullable|string|max:100',
            'sector'    => 'nullable|string|max:20',
            'cell'     => 'required|string|max:100',
            'village'     => 'required|string|max:255',

            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities'  => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $house = DB::transaction(function () use ($request, $data) {

            $house = House::create([
                'user_id'     => auth()->id(),
                'title'       => $data['title'],
                'upi'       => $data['upi'],
                'type'        => $data['type'],
                'price'       => $data['price'],
                'area_sqft'   => $data['area_sqft'],
                'status'      => $data['status'],
                'bedrooms'    => $data['bedrooms'],
                'bathrooms'   => $data['bathrooms'],
                'garages'     => $data['garages'],
                'description' => $data['description'],
                'province'    => $data['province'],
                'district'       => $data['district'] ?? null,
                'sector'    => $data['sector'] ?? null,
                'cell'     => $data['cell'],
                'village'     => $data['village'],
                'service_id'  => $data['service_id'],
            ]);

            // Save facilities (checkboxes)
            if ($request->filled('facilities')) {
                $house->facilities()->sync($request->facilities);
            }

            // Save images
            // Upload images
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $path = $image->store('houses', 'public');

                    HouseImage::create([
                        'house_id' => $house->id,
                        'image_path' => $path
                    ]);
                }
            }

            return $house;
        });

        return redirect()->route('plans.select', [
            'type' => 'house',
            'id' => $house->id
        ])->with('success', 'Property added successfully and sent for approval!');
    }

    public function show(string $id)
    {
        $house = House::with([
            'facilities',
            'user',
            'service',
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
        $services = \App\Models\Service::orderBy('title')->get();
        return view('admin.property.house.edit', compact('house', 'services'));
    }

    public function update(Request $request, House $house)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'upi'       => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'required|integer|min:1',
            'status'      => 'required|in:available,reserved,sold',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'garages'     => 'required|integer|min:0',
            'description' => 'required|string',

            'province'    => 'required|string|max:100',
            'district'       => 'nullable|string|max:100',
            'sector'    => 'nullable|string|max:20',
            'cell'     => 'required|string|max:100',
            'village'     => 'required|string|max:255',

            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities'  => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'service_id' => 'required|exists:services,id',
        ]);

        $house = DB::transaction(function () use ($request, $data) {

            $house = House::create([
                'user_id'     => auth()->id(),
                'title'       => $data['title'],
                'upi'       => $data['upi'],
                'type'        => $data['type'],
                'price'       => $data['price'],
                'area_sqft'   => $data['area_sqft'],
                'status'      => $data['status'],
                'bedrooms'    => $data['bedrooms'],
                'bathrooms'   => $data['bathrooms'],
                'garages'     => $data['garages'],
                'description' => $data['description'],
                'province'    => $data['province'],
                'district'       => $data['district'] ?? null,
                'sector'    => $data['sector'] ?? null,
                'cell'     => $data['cell'],
                'village'     => $data['village'],
                'service_id'  => $data['service_id'],
            ]);

            // Save facilities (checkboxes)
            if ($request->filled('facilities')) {
                $house->facilities()->sync($request->facilities);
            }

            // Save images
            // Upload images
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {

                    $path = $image->store('houses', 'public');

                    HouseImage::create([
                        'house_id' => $house->id,
                        'image_path' => $path
                    ]);
                }
            }

            return $house;
        });

        return redirect()->route('plans.select', [
            'type' => 'house',
            'id' => $house->id
        ])->with('success', 'Property added successfully and sent for approval!');
    }

    public function destroy(House $house)
    {
        $house->delete();

        return back()->with('success', 'house deleted successfully.');
    }
}
