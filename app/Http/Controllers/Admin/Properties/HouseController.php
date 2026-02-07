<?php

namespace App\Http\Controllers\Admin\Properties;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HouseController extends Controller
{
    public function index()
    {
        $houses = House::latest()->paginate(10);
        return view('admin.property.house.index', compact('houses'));
    }

    public function create()
    {
        $facilities = Facility::all();
        return view('admin.property.house.create', compact('facilities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'required|integer|min:1',
            'status'      => 'required|in:available,reserved,sold',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'garages'     => 'required|integer|min:0',
            'description' => 'required|string',

            'city'        => 'required|string|max:100',
            'state'       => 'nullable|string|max:100',
            'zip_code'    => 'nullable|string|max:20',
            'country'     => 'required|string|max:100',
            'address'     => 'required|string|max:255',

            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'facilities'  => 'nullable|array',
            'facilities.*'=> 'exists:facilities,id',
        ]);

        DB::transaction(function () use ($request, $data) {

            $house = House::create([
                'user_id'     => auth()->id(),
                'title'       => $data['title'],
                'type'        => $data['type'],
                'price'       => $data['price'],
                'area_sqft'   => $data['area_sqft'],
                'status'      => $data['status'],
                'bedrooms'    => $data['bedrooms'],
                'bathrooms'   => $data['bathrooms'],
                'garages'     => $data['garages'],
                'description' => $data['description'],
                'city'        => $data['city'],
                'state'       => $data['state'] ?? null,
                'zip_code'    => $data['zip_code'] ?? null,
                'country'     => $data['country'],
                'address'     => $data['address'],
            ]);

            // Save facilities (checkboxes)
            if ($request->filled('facilities')) {
                $house->facilities()->sync($request->facilities);
            }

            // Save images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('houses', 'public');

                    $house->images()->create([
                        'image_path' => $path
                    ]);
                }
            }
        });

        return redirect()->route('admin.properties.house.index')->with('success', 'Property added successfully and sent for approval!');
    }

    public function show(string $id)
    {
        $house = House::with(['images', 'facilities'])->findOrFail($id);
        return view('admin.property.house.show', compact('house'));
    }
}
