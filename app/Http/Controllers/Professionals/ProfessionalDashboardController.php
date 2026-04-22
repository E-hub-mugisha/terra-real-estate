<?php

namespace App\Http\Controllers\Professionals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArchitecturalDesign;
use App\Models\DesignCategory;
use App\Models\DesignOrder;
use App\Models\ListingPackage;
use App\Models\Professional;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProfessionalDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD OVERVIEW
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $professional = Auth::user();

        $stats = [
            'total_designs'   => ArchitecturalDesign::where('user_id', $professional->id)->count(),
            'active_designs'  => ArchitecturalDesign::where('user_id', $professional->id)->where('status', 'active')->count(),
            'pending_orders'  => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))
                ->where('payment_status', 'pending')->count(),
            'total_orders'    => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->count(),
            'completed_orders' => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))
                ->where('payment_status', 'completed')->count(),
            'total_earnings'  => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))
                ->where('payment_status', 'completed')->sum('amount'),
        ];

        $recent_orders = DesignOrder::with(['design', 'user'])
            ->whereHas('design', fn($q) => $q->where('user_id', $professional->id))
            ->latest()
            ->take(5)
            ->get();

        $recent_designs = ArchitecturalDesign::where('user_id', $professional->id)
            ->latest()
            ->take(4)
            ->get();

        return view('professionals.dashboard.index', compact('professional', 'stats', 'recent_orders', 'recent_designs'));
    }

    /*
    |--------------------------------------------------------------------------
    | ARCHITECTURAL DESIGNS — CRUD
    |--------------------------------------------------------------------------
    */

    public function designsIndex(Request $request)
    {
        $professional = Auth::user();

        $query = ArchitecturalDesign::where('user_id', $professional->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $designs = $query->latest()->paginate(12);

        $categories = \App\Models\DesignCategory::all();

        return view('professionals.architecturals.index', compact('designs', 'categories'));
    }

    public function designsCreate()
    {
        $categories = \App\Models\DesignCategory::all();
        $packages   = ListingPackage::where('listing_type', 'land')
            ->orderByRaw("FIELD(package_tier,'basic','medium','standard')")
            ->get();
        return view('professionals.architecturals.create', compact('categories', 'packages'));
    }

    public function designsStore(Request $request)
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

    public function designsShow(Request $request, ArchitecturalDesign $architecturalDesign)
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

        return view('professionals.architecturals.show', compact('architecturalDesign', 'viewStats'));
    }

    public function designsEdit(ArchitecturalDesign $architecturalDesign)
    {
        $categories = DesignCategory::orderBy('name')->get();

        return view('professionals.architecturals.edit', compact('architecturalDesign', 'categories'));
    }

    public function designsUpdate(Request $request, ArchitecturalDesign $architecturalDesign)
    {
        $request->validate([
            'title'         => 'required|string|max:255',
            'category_id'   => 'required|exists:design_categories,id',
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
            Storage::disk('public')->delete($architecturalDesign->design_file);
            $data['design_file'] = $request->file('design_file')
                ->store('architectural_designs/files', 'public');
        }

        if ($request->hasFile('preview_image')) {
            if ($architecturalDesign->preview_image) {
                Storage::disk('public')->delete($architecturalDesign->preview_image);
            }
            $data['preview_image'] = $request->file('preview_image')
                ->store('architectural_designs/previews', 'public');
        }

        $architecturalDesign->update($data);

        return redirect()->route('professional.architectural-designs.show', $architecturalDesign)
            ->with('success', 'Design updated successfully.');
    }

    public function designsDestroy(ArchitecturalDesign $architecturalDesign)
    {

        if (DesignOrder::where('architectural_design_id', $architecturalDesign->id)->whereIn('payment_status', ['pending', 'in_progress'])->exists()) {
            return back()->with('error', 'Cannot delete a design with active orders.');
        }

        $architecturalDesign->delete();

        return redirect()->route('professional.architectural-designs.index')
            ->with('success', 'Design deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | ORDERS — VIEW & MANAGE
    |--------------------------------------------------------------------------
    */

    public function ordersIndex(Request $request)
    {
        $professional = Auth::user();

        $query = DesignOrder::with(['design', 'user'])
            ->whereHas('design', fn($q) => $q->where('user_id', $professional->id));

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', '%' . $request->search . '%'))
                    ->orWhereHas('design', fn($d) => $d->where('title', 'like', '%' . $request->search . '%'));
            });
        }

        $orders = $query->latest()->paginate(15);

        $statusCounts = [
            'all'         => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->count(),
            'pending'     => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->where('payment_status', 'pending')->count(),
            'in_progress' => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->where('payment_status', 'in_progress')->count(),
            'completed'   => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->where('payment_status', 'completed')->count(),
            'cancelled'   => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->where('payment_status', 'cancelled')->count(),
        ];

        return view('professionals.orders.index', compact('orders', 'statusCounts'));
    }

    public function ordersShow(DesignOrder $order)
    {
        $this->authorizeOrder($order);

        $order->load(['design', 'user']);

        return view('professionals.orders.show', compact('order'));
    }

    public function ordersUpdateStatus(Request $request, DesignOrder $order)
    {
        $this->authorizeOrder($order);

        $request->validate([
            'status'  => 'required|in:pending,in_progress,completed,cancelled',
            'note'    => 'nullable|string|max:1000',
        ]);

        $old = $order->status;
        $order->update([
            'status'     => $request->status,
            'status_note' => $request->note,
            'updated_at' => now(),
        ]);

        // Log activity if the model observer is set up
        activity()
            ->performedOn($order)
            ->causedBy(Auth::user())
            ->withProperties(['old_status' => $old, 'new_status' => $request->status])
            ->log('order_status_updated');

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status) . '.');
    }

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        $user = Auth::user();
        $professional = Professional::where('user_id', $user->id)->first();

        $professional->recordView(request());

        $viewStats = [
            'total'       => $professional->views_count,
            'unique'      => $professional->unique_views_count,
            'today'       => $professional->viewsToday(),
            'this_week'   => $professional->viewsThisWeek(),
            'this_month'  => $professional->viewsThisMonth(),
            'daily_chart' => $professional->dailyViewsForPast(14),
        ];

        return view('professionals.profile', compact('professional', 'viewStats'));
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    private function authorizeDesign(ArchitecturalDesign $design): void
    {
        if ($design->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this design.');
        }
    }

    private function authorizeOrder(DesignOrder $order): void
    {
        if ($order->design->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }
    }
}
