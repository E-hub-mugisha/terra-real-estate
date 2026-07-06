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
        $services = Service::with(['category', 'subcategory'])
            ->latest()
            ->paginate(10)
            ->withQueryString();

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
            'price' => 'nullable|numeric|min:0',
        ]);

        Service::create([
            'title' => $request->title,
            'slug' => $this->generateUniqueSlug($request->title),
            'service_category_id' => $request->service_category_id,
            'service_subcategory_id' => $request->service_subcategory_id,
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->back()->with('success', 'Service created successfully.');
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'service_category_id' => 'required|exists:service_categories,id',
            'service_subcategory_id' => 'nullable|exists:service_sub_categories,id',
            'description' => 'required',
            'price' => 'nullable|numeric|min:0',
        ]);

        // Only regenerate the slug when the title actually changes,
        // so existing public URLs don't break on unrelated edits.
        $slug = $service->title !== $request->title
            ? $this->generateUniqueSlug($request->title, $service->id)
            : $service->slug;

        $service->update([
            'title' => $request->title,
            'slug' => $slug,
            'service_category_id' => $request->service_category_id,
            'service_subcategory_id' => $request->service_subcategory_id,
            'description' => $request->description,
            'price' => $request->price,
            'is_active' => $request->boolean('is_active'),
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
        $subcategories = \App\Models\ServiceSubCategory::where('service_category_id', $categoryId)->get();
        return response()->json($subcategories);
    }

    /**
     * Generate a unique slug from the given title, appending -2, -3, etc.
     * if the base slug is already taken by another service.
     */
    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (
            Service::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}