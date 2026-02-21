<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceSubCategoryController extends Controller
{
    public function index()
    {
        $subcategories = ServiceSubcategory::with('category')->latest()->get();
        $categories = ServiceCategory::all();

        return view('admin.service_subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        ServiceSubCategory::create([
            'service_category_id' => $request->service_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Subcategory created');
    }

    public function update(Request $request, ServiceSubcategory $serviceSubcategory)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $serviceSubcategory->update([
            'service_category_id' => $request->service_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return back()->with('success', 'Subcategory updated');
    }

    public function destroy(ServiceSubcategory $serviceSubcategory)
    {
        $serviceSubcategory->delete();
        return back()->with('success', 'Subcategory deleted');
    }
}
