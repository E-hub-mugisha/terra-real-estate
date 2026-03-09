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
use App\Models\Province;
use App\Models\Village;

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
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'title'       => 'required|string|max:255',
            'type'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'area_sqft'   => 'required|integer|min:1',
            'status'      => 'required|in:available,reserved,sold',
            'bedrooms'    => 'required|integer|min:0',
            'bathrooms'   => 'required|integer|min:0',
            'garages'     => 'required|integer',
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
            'condition' => 'required|in:for_sale,for_rent',
        ]);

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'password' => bcrypt('defaultpassword')]
        );

        $house = DB::transaction(function () use ($request, $data, $user) {

            $house = House::create([
                'user_id'     => $user->id,
                'title'       => $data['title'],
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
                'condition'   => $data['condition'],
                'is_approved' => false, // Admin approval required
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

            return $house;
        });

        return redirect()->route('plans.select', [
            'type' => 'house',
            'id' => $house->id
        ])->with('success', 'Property added successfully and sent for pricing plan selection!');
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

        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'password' => bcrypt('defaultpassword')]
        );

        $land = DB::transaction(function () use ($request, $data, $user) {

            $land = Land::create([
                'user_id'     => $user->id,
                'title'        => $data['title'],
                'description'  => $data['description'],
                'price'    => $data['price'],
                'size_sqm'     => $data['size_sqm'],
                'zoning'       => $data['zoning'],
                'land_use'     => $data['land_use'],
                'service_id' => $data['service_id'],
                'province'     => $data['province'],
                'district'     => $data['district'],
                'sector'       => $data['sector'],
                'cell'         => $data['cell'],
                'village'      => $data['village'],

                'upi' => $data['upi'] ?? null,
                'title_doc'    => $data['title_doc'] ?? null,
                'status'       => $data['status'],
                'is_approved' => false, // Admin approval required
            ]);

            // Save title document
            if ($request->hasFile('title_doc')) {
                $path = $request->file('title_doc')->store('land_titles', 'public');
                $land->update(['title_doc' => $path]);
            }

            return $land;
        });

        return redirect()->route(
            'plans.select',
            [
                'id' => $land->id,
                'type' => 'land'
            ]
        )->with('success', '🌍 Land listed successfully and sent for approval.');
    }

    // DESIGN REQUEST FORM
    public function storeDesign(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'phone' => 'required|string',
            'project_type' => 'required|string',
            'description' => 'required|string',
        ]);

        ArchitecturalDesign::create($request->all());

        return back()->with('success', 'Design request submitted successfully.');
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
