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

        if ($image = $request->file('image')) {
            $destinationPath = 'image/partners/';
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move image to public folder
            $image->move($destinationPath, $filename);

            // Save relative path in DB
            $data['image'] = "$filename";
        }

        Partner::create([
            'name' => $request->name,
            'link' => $request->link,
            'image' => $filename
        ]);

        return back()->with('success', 'Partner added successfully');
    }

    public function update(Request $request, Partner $partner)
    {

        if ($image = $request->file('image')) {
            $destinationPath = 'image/partners/';
            // Generate unique filename
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Create folder if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Move image to public folder
            $image->move($destinationPath, $filename);

            // Save relative path in DB
            $data['image'] = "$filename";
        }

        $partner->update([
            'name' => $request->name,
            'link' => $request->link,
            'image' => $filename
        ]);

        return back()->with('success', 'Partner updated successfully');
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();

        return back()->with('success', 'Partner deleted');
    }
}
