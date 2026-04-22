<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArchitecturalDesign;
use App\Models\DesignCategory;
use App\Models\ListingPackage;
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
    public function index(Request $request)
    {
        $query = ArchitecturalDesign::with(['category', 'service'])
            ->when($request->search,   fn($q) => $q->where('title', 'like', "%{$request->search}%"))
            ->when($request->status,   fn($q) => $q->where('status', $request->status))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->featured, fn($q) => $q->where('featured', true))
            ->when($request->free,     fn($q) => $q->where('is_free', true))
            ->when($request->sort === 'price_asc',  fn($q) => $q->orderBy('price'))
            ->when($request->sort === 'price_desc', fn($q) => $q->orderByDesc('price'))
            ->when($request->sort === 'title',      fn($q) => $q->orderBy('title'))
            ->when($request->sort === 'oldest',     fn($q) => $q->oldest())
            ->latest();

        $stats = [
            'total'    => ArchitecturalDesign::count(),
            'approved' => ArchitecturalDesign::where('status', 'approved')->count(),
            'pending'  => ArchitecturalDesign::where('status', 'pending')->count(),
            'rejected' => ArchitecturalDesign::where('status', 'rejected')->count(),
            'free'     => ArchitecturalDesign::where('is_free', true)->count(),
            'featured' => ArchitecturalDesign::where('featured', true)->count(),
        ];

        return view('admin.architecturals.index', [
            'designs'    => $query->paginate(15)->withQueryString(),
            'categories' => DesignCategory::orderBy('name')->get(),
            'stats'      => $stats,
        ]);
    }

    /**
     * Show create form
     */
    public function create()
    {
        $categories = DesignCategory::orderBy('name')->get();
        $users = User::where('role', 'professional')->orderBy('name')->get();
        $packages   = ListingPackage::where('listing_type', 'land')
            ->orderByRaw("FIELD(package_tier,'basic','medium','standard')")
            ->get();
        return view('admin.architecturals.create', compact('categories', 'users', 'packages'));
    }

    /**
     * Store design
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:design_categories,id',
            'description'   => 'nullable|string',
            'design_file'   => 'required|mimes:pdf,zip,dwg|max:20480',
            'preview_image' => 'nullable|image|max:4096',
            'video_url'     => 'nullable|url|max:500',
            'price'         => 'nullable|numeric|min:0',
            'status'        => 'required|in:pending,approved,rejected',

            // ── new fields ────────────────────────────────────────────
            'listing_package_id' => 'required|exists:listing_packages,id',
            'listing_days'       => 'required|integer|min:1',
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

        $design = ArchitecturalDesign::create([
            'title'          => $request->title,
            'slug'           => $slug,
            'user_id'        => auth()->id(),
            'category_id'    => $request->category_id,
            'description'    => $request->description,
            'design_file'    => $designFilePath,
            'preview_image'  => $previewPath,
            'video_url'     => $request->video_url,
            'price'          => $request->price ?? 0,
            'is_free'        => $request->price == 0,
            'status'         => $request->status,
            'featured'       => $request->has('featured'),
            'listing_days'       => $request->listing_days,
            'listing_package_id' => $request->listing_package_id,
            'listing_status' => 'pending_payment',

        ]);

        // ── Resolve listing fee from the chosen package ────────────────────────
        $package    = \App\Models\ListingPackage::findOrFail($request->listing_package_id);
        $listingFee = $package->price_per_day * $request->listing_days; // e.g. 15000 RWF

        // ── Create the pending payment record ─────────────────────────────────
        $payment = \App\Models\ListingPayment::create([
            'payable_type'    => ArchitecturalDesign::class,       // polymorphic type
            'payable_id'      => $design->id,         // polymorphic id
            'user_id'         => auth()->id(),
            'payment_purpose' => 'listing_fee',
            'amount'          => $listingFee,
            'currency'        => 'RWF',
            'status'          => 'pending',
        ]);

        // ── Redirect to payment page ───────────────────────────────────────────
        return redirect()
            ->route('payment.show', $payment->reference)
            ->with('success', 'house listing saved! Complete your payment to publish it.');
    }

    public function show(ArchitecturalDesign $architecturalDesign)
    {
        $architecturalDesign->recordView(request());
    
        $viewStats = [
            'total'       => $architecturalDesign->views_count,
            'unique'      => $architecturalDesign->unique_views_count,
            'today'       => $architecturalDesign->viewsToday(),
            'this_week'   => $architecturalDesign->viewsThisWeek(),
            'this_month'  => $architecturalDesign->viewsThisMonth(),
            'daily_chart' => $architecturalDesign->dailyViewsForPast(14),
        ];
        return view('admin.architecturals.show', compact('architecturalDesign', 'viewStats'));
    }
    /**
     * Show edit form
     */
    public function edit(ArchitecturalDesign $architecturalDesign)
    {
        $categories = DesignCategory::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $services = Service::all();

        return view(
            'admin.architecturals.edit',
            compact('architecturalDesign', 'categories', 'users', 'services')
        );
    }

    /**
     * Update design
     */
    public function update(Request $request, ArchitecturalDesign $design)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:design_categories,id',
            'service_id'    => 'required|exists:services,id',
            'user_id'       => 'nullable|exists:users,id',
            'description'   => 'nullable|string',
            'design_file'   => 'nullable|mimes:pdf,zip,dwg|max:20480',
            'preview_image' => 'nullable|image|max:4096',
            'price'         => 'nullable|numeric|min:0',
            'status'        => 'required|in:pending,approved,rejected',
            'featured'      => 'nullable',
            'video_url'     => 'nullable|url|max:500',
        ]);

        $data = $request->only([
            'title',
            'category_id',
            'service_id',
            'user_id',
            'description',
            'price',
            'status',
            'video_url'
        ]);

        $data['slug']     = Str::slug($request->title) . '-' . time();
        $data['is_free']  = ($request->price ?? 0) == 0;
        $data['featured'] = $request->has('featured');

        if ($request->hasFile('design_file')) {
            Storage::disk('public')->delete($design->design_file);
            $data['design_file'] = $request->file('design_file')
                ->store('architectural_designs/files', 'public');
        }

        if ($request->hasFile('preview_image')) {
            if ($design->preview_image) {
                Storage::disk('public')->delete($design->preview_image);
            }
            $data['preview_image'] = $request->file('preview_image')
                ->store('architectural_designs/previews', 'public');
        }

        $design->update($data);

        return redirect()
            ->route('admin.architectural-designs.index')
            ->with('success', '✅ Design updated successfully.');
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
            ->route('admin.architectural-designs.index')
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

    // Quick status update
    public function updateStatus(Request $request, ArchitecturalDesign $design)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        $design->update(['status' => $request->status]);
        return back()->with('success', 'Status updated to ' . $request->status . '.');
    }

    public function approve(ArchitecturalDesign $architecturalDesign)
    {
        if ($architecturalDesign->is_approved) {
            return back()->with('info', 'design is already approved.');
        }

        $architecturalDesign->update(['is_approved' => true]);

        return back()->with('success', 'design approved successfully.');
    }

    // Feature toggle
    public function toggleFeature(ArchitecturalDesign $design)
    {
        $design->update(['featured' => !$design->featured]);
        return back()->with('success', $design->featured ? 'Marked as featured.' : 'Removed from featured.');
    }
}
