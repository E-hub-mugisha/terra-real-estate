<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use App\Models\MaterialProduct;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MaterialController extends Controller
{
    /**
     * Main browse page — mirrors the marketplace.blade.php pattern:
     * server renders all approved products once, client-side filter bar
     * (category, price, stock status, search) does the rest.
     */
    public function index(Request $request)
    {
        $categories = MaterialCategory::active()
            ->with('activeSubcategories')
            ->get();

        $products = MaterialProduct::approved()
            ->with(['shop', 'category', 'subcategory', 'images'])
            ->latest()
            ->get();

        return view('materials.index', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function category(Request $request, MaterialCategory $category)
    {
        abort_unless($category->is_active, 404);

        $subcategories = $category->materialSubcategories()->orderBy('name')->get();

        $materials = MaterialProduct::query()
            ->approved()   // ← fixed: was ->isApproved()
            ->where('material_category_id', $category->id)
            ->when($request->subcategory, function ($q) use ($request) {
                $q->whereHas('subcategory', fn($sq) => $sq->where('slug', $request->subcategory));
            })
            ->when($request->q, function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->q}%"); // also fixed: your column is `title`, not `name`
            })
            ->when($request->sort === 'price_asc', fn($q) => $q->orderBy('price'))
            ->when($request->sort === 'price_desc', fn($q) => $q->orderByDesc('price'))
            ->when(!$request->sort, fn($q) => $q->latest())
            ->with(['subcategory', 'shop', 'images'])
            ->paginate(24)
            ->withQueryString();

        return view('front.materials.category', compact('category', 'subcategories', 'materials'));
    }

    public function show(MaterialCategory $category, MaterialProduct $material)
    {
        abort_unless($category->is_active, 404);

        // Make sure the product actually belongs to this category —
        // otherwise someone could swap the category slug in the URL freely.
        abort_unless($material->material_category_id === $category->id, 404);

        // Only approved products from approved shops are publicly viewable
        abort_unless(
            $material->status === 'approved' && $material->shop->status === 'approved',
            404
        );

        $material->load(['images', 'shop', 'subcategory', 'category']);
        $material->increment('views_count');

        $related = MaterialProduct::query()
            ->approved()
            ->where('material_category_id', $category->id)
            ->where('id', '!=', $material->id)
            ->with(['images', 'shop'])
            ->latest()
            ->limit(4)
            ->get();

        return view('front.materials.show', compact('category', 'material', 'related'));
    }

    /**
     * Tracks WhatsApp inquiry clicks before redirecting out.
     * Keeping this as a real route (rather than a raw wa.me link) lets us
     * count genuine inquiry intent per product.
     */
    public function whatsappRedirect(MaterialProduct $material)
    {
        abort_unless(
            $material->status === 'approved' && $material->shop->status === 'approved',
            404
        );

        $material->increment('whatsapp_clicks_count');

        return redirect()->away($material->whatsappLink());
    }

    public function shop(Shop $shop)
    {
        abort_unless($shop->status === 'approved', 404);

        $shop->increment('views_count');
        $products = $shop->approvedProducts()->with(['category', 'images'])->latest()->get();

        return view('materials.shop', [
            'shop' => $shop,
            'products' => $products,
        ]);
    }

    /**
     * Fired via a small fetch() call right before the wa.me redirect so we
     * can count genuine buyer interest per product without blocking the
     * redirect itself.
     */
    public function trackWhatsappClick(MaterialProduct $product): JsonResponse
    {
        $product->increment('whatsapp_clicks_count');

        return response()->json(['ok' => true]);
    }
}
