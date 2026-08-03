<?php
// app/Http/Controllers/Admin/MaterialSubcategoryController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use App\Models\MaterialSubcategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaterialSubcategoryController extends Controller
{
    public function store(Request $request, int $materialsCategoryId)
    {
        $category = MaterialCategory::findOrFail($materialsCategoryId);

        $validated = $request->validate([
            'name'      => [
                'required', 'string', 'max:255',
                Rule::unique('material_subcategories', 'name')->where('material_category_id', $category->id),
            ],
            'icon'      => ['nullable', 'string', 'max:100'],
            'order'     => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['order'] = $validated['order'] ?? 0;
        $validated['material_category_id'] = $category->id;

        MaterialSubcategory::create($validated);

        return redirect()
            ->route('admin.materials-categories.index')
            ->with('success', 'Subcategory added successfully.')
            ->with('open_subcategories', $category->id);
    }

    public function update(Request $request, int $materialsCategoryId, MaterialSubcategory $subcategory)
    {
        abort_unless($subcategory->material_category_id === $materialsCategoryId, 404);

        $validated = $request->validate([
            'name'      => [
                'required', 'string', 'max:255',
                Rule::unique('material_subcategories', 'name')
                    ->where('material_category_id', $materialsCategoryId)
                    ->ignore($subcategory->id),
            ],
            'icon'      => ['nullable', 'string', 'max:100'],
            'order'     => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order'] = $validated['order'] ?? 0;

        $subcategory->update($validated);

        return redirect()
            ->route('admin.materials-categories.index')
            ->with('success', 'Subcategory updated successfully.')
            ->with('open_subcategories', $materialsCategoryId);
    }

    public function destroy(int $materialsCategoryId, MaterialSubcategory $subcategory)
    {
        abort_unless($subcategory->material_category_id === $materialsCategoryId, 404);

        if (method_exists($subcategory, 'materials') && $subcategory->materials()->exists()) {
            return back()
                ->with('error', 'Cannot delete a subcategory that still has materials assigned to it.')
                ->with('open_subcategories', $materialsCategoryId);
        }

        $subcategory->delete();

        return redirect()
            ->route('admin.materials-categories.index')
            ->with('success', 'Subcategory deleted successfully.')
            ->with('open_subcategories', $materialsCategoryId);
    }
}