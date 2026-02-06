<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('is_approved', true)->latest()->paginate(9);
        return view('properties.index', compact('properties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'type' => 'required',
            'zoning' => 'nullable',
            'price' => 'required|numeric',
            'district' => 'required',
            'sector' => 'required',
            'cell' => 'required',
        ]);

        $data['user_id'] = auth()->id();
        $property = Property::create($data);

        return redirect()->route('properties.index')->with('success', 'Listing submitted for approval');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
