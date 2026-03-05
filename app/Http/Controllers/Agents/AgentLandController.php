<?php

namespace App\Http\Controllers\Agents;

use App\Http\Controllers\Controller;
use App\Models\Land;
use App\Models\Service;
use Illuminate\Http\Request;

class AgentLandController extends Controller
{
    public function index()
    {
        $lands = Land::where('user_id')->latest()->paginate(10);
        return view('agents.property.land.index', compact('lands'));
    }

    public function create()
    {
        $services = Service::all();
        return view('agents.property.land.create', compact('services'));
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

        $land =Land::create($data);

        return redirect()->route(
            'plans.select',
            [
                'id' => $land->id,
                'type' => 'land'
            ]
        )->with('success', '🌍 Land listed successfully and sent for approval.');
    }
}
