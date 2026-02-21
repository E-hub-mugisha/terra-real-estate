<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArchitecturalDesign;
use App\Models\DesignCategory;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArchitecturalDesignController extends Controller
{
    /**
     * List designs
     */
    public function index()
    {
        $designs = ArchitecturalDesign::with(['category', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.architecturals.index', compact('designs'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = DesignCategory::orderBy('name')->get();
        $services = Service::all();
        $users = User::orderBy('name')->get();

        return view('admin.architecturals.create', compact('categories', 'users', 'services'));
    }

    /**
     * Store design
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'user_id'       => 'nullable|exists:users,id',
            'category_id'   => 'required|exists:design_categories,id',
            'description'   => 'nullable|string',
            'design_file'   => 'required|mimes:pdf,zip,dwg|max:20480',
            'preview_image' => 'nullable|image|max:4096',
            'price'         => 'nullable|numeric|min:0',
            'status'        => 'required|in:pending,approved,rejected',
            'service_id' => 'required|exists:services,id',
        ]);

        $slug = Str::slug($request->title) . '-' . time();

        // Upload files
        $designFilePath = $request->file('design_file')
            ->store('architectural_designs/files', 'public');

        $previewPath = null;
        if ($request->hasFile('preview_image')) {
            $previewPath = $request->file('preview_image')
                ->store('architectural_designs/previews', 'public');
        }

        ArchitecturalDesign::create([
            'title'          => $request->title,
            'slug'           => $slug,
            'user_id'        => $request->user_id,
            'category_id'    => $request->category_id,
            'description'    => $request->description,
            'design_file'    => $designFilePath,
            'preview_image'  => $previewPath,
            'price'          => $request->price ?? 0,
            'is_free'        => $request->price == 0,
            'status'         => $request->status,
            'featured'       => $request->has('featured'),
            'service_id'  => $request->service_id,
        ]);

        return redirect()
            ->route('admin.architectural-designs.index')
            ->with('success', 'Architectural design created successfully.');
    }

    public function show(ArchitecturalDesign $architecturalDesign)
    {
        return view('admin.architecturals.show', compact('architecturalDesign'));
    }
    /**
     * Show edit form
     */
    public function edit(ArchitecturalDesign $architecturalDesign)
    {
        $categories = DesignCategory::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view(
            'admin.architecturals.edit',
            compact('architecturalDesign', 'categories', 'users')
        );
    }

    /**
     * Update design
     */
    public function update(Request $request, ArchitecturalDesign $architecturalDesign)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'user_id'       => 'nullable|exists:users,id',
            'category_id'   => 'required|exists:design_categories,id',
            'description'   => 'nullable|string',
            'design_file'   => 'nullable|mimes:pdf,zip,dwg|max:20480',
            'preview_image' => 'nullable|image|max:4096',
            'price'         => 'nullable|numeric|min:0',
            'status'        => 'required|in:pending,approved,rejected',
        ]);

        $data = $request->only([
            'title',
            'user_id',
            'category_id',
            'description',
            'price',
            'status',
        ]);

        $data['slug'] = Str::slug($request->title);
        $data['is_free'] = ($request->price == 0);
        $data['featured'] = $request->has('featured');

        // Replace design file
        if ($request->hasFile('design_file')) {
            Storage::disk('public')->delete($architecturalDesign->design_file);

            $data['design_file'] = $request->file('design_file')
                ->store('architectural_designs/files', 'public');
        }

        // Replace preview image
        if ($request->hasFile('preview_image')) {
            Storage::disk('public')->delete($architecturalDesign->preview_image);

            $data['preview_image'] = $request->file('preview_image')
                ->store('architectural_designs/previews', 'public');
        }

        $architecturalDesign->update($data);

        return redirect()
            ->route('admin.architectural-designs.index')
            ->with('success', 'Architectural design updated successfully.');
    }

    /**
     * Delete design
     */
    public function destroy(ArchitecturalDesign $architecturalDesign)
    {
        Storage::disk('public')->delete([
            $architecturalDesign->design_file,
            $architecturalDesign->preview_image
        ]);

        $architecturalDesign->delete();

        return redirect()
            ->back()
            ->with('success', 'Architectural design deleted.');
    }

    public function designCategoryIndex()
    {
        $categories = DesignCategory::latest()->get();
        return view('admin.architecturals.design-categories', compact('categories'));
    }

    public function designCategoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        DesignCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Category created successfully');
    }

    public function designCategoryUpdate(Request $request, DesignCategory $design_category)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $design_category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return back()->with('success', 'Category updated successfully');
    }

    public function designCategoryDestroy(DesignCategory $design_category)
    {
        $design_category->delete();
        return back()->with('success', 'Category deleted successfully');
    }
}
