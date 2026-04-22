<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('is_approved', false)->get();
        return view('admin.properties.pending', compact('properties'));
    }

    public function approve(Property $property)
    {
        $property->update(['is_approved' => true]);
        return back()->with('success', 'Property approved');
    }
}
