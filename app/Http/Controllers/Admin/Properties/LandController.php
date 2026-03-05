<?php

namespace App\Http\Controllers\Admin\Properties;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\LandImage;
use App\Models\Service;
use Illuminate\Http\Request;

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
}
