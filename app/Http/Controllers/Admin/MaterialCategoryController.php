<?php
// app/Http/Controllers/Admin/MaterialCategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaterialCategoryController extends Controller
{
    public function index()
    {
        $categories = MaterialCategory::withCount('materialSubcategories')
            ->orderBy('order')
            ->orderBy('name')
            ->get();

        return view('admin.materials-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255', 'unique:material_categories,name'],
            'icon'      => ['nullable', 'string', 'max:100'],
            'order'     => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        MaterialCategory::create($validated);

        return back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, MaterialCategory $materialCategory)
    {
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255', Rule::unique('material_categories', 'name')->ignore($materialCategory->id)],
            'icon'      => ['nullable', 'string', 'max:100'],
            'order'     => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $materialCategory->update($validated);

        return back()->with('success', 'Category updated successfully.');
    }

    public function destroy(MaterialCategory $materialCategory)
    {
        if ($materialCategory->materials()->exists()) {
            return back()->with('error', 'Cannot delete a category that still has materials assigned to it.');
        }

        $materialCategory->delete();

        return back()->with('success', 'Category deleted successfully.');
    }

    public function subcategories(MaterialCategory $category): JsonResponse
    {
        $subcategories = $category->materialSubcategories()
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($subcategories);
    }
}