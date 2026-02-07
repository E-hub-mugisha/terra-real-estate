<?php

namespace App\Http\Controllers\Admin\Properties;

use App\Http\Controllers\Controller;
use App\Models\Land;
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
        return view('admin.property.land.create');
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

        Land::create($data);

        return back()->with('success', '🌍 Land listed successfully and sent for approval.');
    }
}
