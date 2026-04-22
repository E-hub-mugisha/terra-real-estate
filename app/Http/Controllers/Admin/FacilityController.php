<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacilityController extends Controller
{

    // FacilityController
    public function index()
    {
        $facilities = Facility::orderBy('name')->paginate(20);
        return view('admin.facilities.index', compact('facilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:facilities,name'
        ]);

        Facility::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return back()->with('success', 'Facility created successfully');
    }

    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'name' => 'required|unique:facilities,name,' . $facility->id
        ]);

        $facility->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return back()->with('success', 'Facility updated successfully');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();

        return back()->with('success', 'Facility deleted successfully');
    }
}
