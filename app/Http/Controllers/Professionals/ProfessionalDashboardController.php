<?php

namespace App\Http\Controllers\Professionals;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArchitecturalDesign;
use App\Models\DesignOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'completed_orders'=> DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))
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

        return view('professionals.dashboard', compact('professional', 'stats', 'recent_orders', 'recent_designs'));
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
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $designs = $query->latest()->paginate(12);

        $categories = ArchitecturalDesign::distinct()->pluck('category')->filter()->values();

        return view('professional.designs.index', compact('designs', 'categories'));
    }

    public function designsCreate()
    {
        return view('professional.designs.create');
    }

    public function designsStore(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'category'        => 'required|string|max:100',
            'style'           => 'nullable|string|max:100',
            'description'     => 'required|string|min:50',
            'features'        => 'nullable|array',
            'features.*'      => 'string|max:200',
            'bedrooms'        => 'nullable|integer|min:0|max:50',
            'bathrooms'       => 'nullable|integer|min:0|max:50',
            'floors'          => 'nullable|integer|min:1|max:100',
            'total_area_sqft' => 'nullable|numeric|min:0',
            'price'           => 'required|numeric|min:0',
            'currency'        => 'required|in:RWF,USD',
            'cover_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'gallery.*'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'blueprint_pdf'   => 'nullable|file|mimes:pdf|max:10240',
            'tags'            => 'nullable|string',
            'status'          => 'required|in:active,draft',
        ]);

        // Handle cover image
        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image');
            $coverName = time() . '_cover_' . $cover->getClientOriginalName();
            $cover->move(public_path('image/designs'), $coverName);
            $validated['cover_image'] = 'image/designs/' . $coverName;
        }

        // Handle gallery images
        $galleryPaths = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $i => $img) {
                $name = time() . '_gallery_' . $i . '_' . $img->getClientOriginalName();
                $img->move(public_path('image/designs/gallery'), $name);
                $galleryPaths[] = 'image/designs/gallery/' . $name;
            }
        }
        $validated['gallery'] = $galleryPaths;

        // Handle blueprint PDF
        if ($request->hasFile('blueprint_pdf')) {
            $pdf = $request->file('blueprint_pdf');
            $pdfName = time() . '_blueprint_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('image/designs/blueprints'), $pdfName);
            $validated['blueprint_pdf'] = 'image/designs/blueprints/' . $pdfName;
        }

        // Process tags & features
        $validated['tags']     = $request->filled('tags')
            ? array_map('trim', explode(',', $request->tags))
            : [];
        $validated['features'] = $request->features ?? [];

        $validated['user_id'] = Auth::id();

        $design = ArchitecturalDesign::create($validated);

        return redirect()->route('professional.designs.show', $design)
            ->with('success', 'Design "' . $design->title . '" published successfully.');
    }

    public function designsShow(ArchitecturalDesign $design)
    {
        $this->authorizeDesign($design);

        $orders = DesignOrder::with('user')
            ->where('design_id', $design->id)
            ->latest()
            ->paginate(10);

        return view('professional.designs.show', compact('design', 'orders'));
    }

    public function designsEdit(ArchitecturalDesign $design)
    {
        $this->authorizeDesign($design);

        return view('professional.designs.edit', compact('design'));
    }

    public function designsUpdate(Request $request, ArchitecturalDesign $design)
    {
        $this->authorizeDesign($design);

        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'category'        => 'required|string|max:100',
            'style'           => 'nullable|string|max:100',
            'description'     => 'required|string|min:50',
            'features'        => 'nullable|array',
            'features.*'      => 'string|max:200',
            'bedrooms'        => 'nullable|integer|min:0|max:50',
            'bathrooms'       => 'nullable|integer|min:0|max:50',
            'floors'          => 'nullable|integer|min:1|max:100',
            'total_area_sqft' => 'nullable|numeric|min:0',
            'price'           => 'required|numeric|min:0',
            'currency'        => 'required|in:RWF,USD',
            'cover_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'gallery.*'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'blueprint_pdf'   => 'nullable|file|mimes:pdf|max:10240',
            'tags'            => 'nullable|string',
            'status'          => 'required|in:active,draft',
        ]);

        if ($request->hasFile('cover_image')) {
            $cover = $request->file('cover_image');
            $coverName = time() . '_cover_' . $cover->getClientOriginalName();
            $cover->move(public_path('image/designs'), $coverName);
            $validated['cover_image'] = 'image/designs/' . $coverName;
        }

        if ($request->hasFile('gallery')) {
            $galleryPaths = $design->gallery ?? [];
            foreach ($request->file('gallery') as $i => $img) {
                $name = time() . '_gallery_' . $i . '_' . $img->getClientOriginalName();
                $img->move(public_path('image/designs/gallery'), $name);
                $galleryPaths[] = 'image/designs/gallery/' . $name;
            }
            $validated['gallery'] = $galleryPaths;
        }

        if ($request->hasFile('blueprint_pdf')) {
            $pdf = $request->file('blueprint_pdf');
            $pdfName = time() . '_blueprint_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('image/designs/blueprints'), $pdfName);
            $validated['blueprint_pdf'] = 'image/designs/blueprints/' . $pdfName;
        }

        $validated['tags']     = $request->filled('tags')
            ? array_map('trim', explode(',', $request->tags))
            : $design->tags;
        $validated['features'] = $request->features ?? $design->features;

        $design->update($validated);

        return redirect()->route('professional.designs.show', $design)
            ->with('success', 'Design updated successfully.');
    }

    public function designsDestroy(ArchitecturalDesign $design)
    {
        $this->authorizeDesign($design);

        if (DesignOrder::where('design_id', $design->id)->whereIn('status', ['pending', 'in_progress'])->exists()) {
            return back()->with('error', 'Cannot delete a design with active orders.');
        }

        $design->delete();

        return redirect()->route('professional.designs.index')
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

        if ($request->filled('status')) {
            $query->where('status', $request->status);
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
            'pending'     => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->where('status', 'pending')->count(),
            'in_progress' => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->where('status', 'in_progress')->count(),
            'completed'   => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->where('status', 'completed')->count(),
            'cancelled'   => DesignOrder::whereHas('design', fn($q) => $q->where('user_id', $professional->id))->where('status', 'cancelled')->count(),
        ];

        return view('professional.orders.index', compact('orders', 'statusCounts'));
    }

    public function ordersShow(DesignOrder $order)
    {
        $this->authorizeOrder($order);

        $order->load(['design', 'user']);

        return view('professional.orders.show', compact('order'));
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
            'status_note'=> $request->note,
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
        $professional = Auth::user()->load('professionalProfile');
        return view('professional.profile', compact('professional'));
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
