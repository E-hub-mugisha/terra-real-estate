<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['category', 'subcategory'])->get();
        $categories = ServiceCategory::all();
        $subcategories = ServiceSubCategory::all();
        return view('admin.services.index', compact('services', 'categories', 'subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'service_subcategory_id' => 'nullable|exists:service_sub_categories,id',
            'description' => 'required',
        ]);

        Service::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'service_category_id' => $request->service_category_id,
            'service_subcategory_id' => $request->service_subcategory_id,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Service created successfully.');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'service_subcategory_id' => 'nullable|exists:service_subcategories,id',
            'description' => 'required',
        ]);

        $service->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'service_category_id' => $request->service_category_id,
            'service_subcategory_id' => $request->service_subcategory_id,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->back()->with('success', 'Service deleted successfully.');
    }

    // ServiceController.php
    public function getSubcategories($categoryId)
    {
        $subcategories = \App\Models\ServiceSubcategory::where('service_category_id', $categoryId)->get();
        return response()->json($subcategories);
    }
}
