<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('partners', 'public');
        }

        Partner::create([
            'name' => $request->name,
            'link' => $request->link,
            'image' => $imagePath
        ]);

        return back()->with('success', 'Partner added successfully');
    }

    public function update(Request $request, Partner $partner)
    {

        $imagePath = $partner->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('partners', 'public');
        }

        $partner->update([
            'name' => $request->name,
            'link' => $request->link,
            'image' => $imagePath
        ]);

        return back()->with('success', 'Partner updated successfully');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();

        return back()->with('success', 'Partner deleted');
    }
}
