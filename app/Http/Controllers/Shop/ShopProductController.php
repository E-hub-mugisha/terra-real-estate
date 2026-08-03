<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Materials\StoreMaterialProductRequest;
use App\Http\Requests\Materials\UpdateMaterialProductRequest;
use App\Models\MaterialCategory;
use App\Models\MaterialProduct;
use App\Models\MaterialProductImage;
use App\Models\MaterialSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ShopProductController extends Controller
{
    /**
     * Make sure the logged-in user actually has a shop before touching products.
     */
    private function shopOrFail()
    {
        $shop = Auth::user()->shop;

        abort_if(!$shop, Response::HTTP_FORBIDDEN, 'You need a shop before you can manage products.');

        return $shop;
    }

    public function index()
    {
        $shop = $this->shopOrFail();

        $products = $shop->materialProducts()
            ->with(['category', 'subcategory', 'images'])
            ->latest()
            ->paginate(10);

        return view('shop.dashboard.products.index', compact('products', 'shop'));
    }

    public function create()
    {
        $this->shopOrFail();

        $categories = MaterialCategory::orderBy('name')->get();

        return view('shop.dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $shop = $this->shopOrFail();

        $validated = $this->validateProduct($request);

        $product = $shop->materialProducts()->create($validated + ['status' => 'pending']);

        $this->syncImages($request, $product);

        return redirect()
            ->route('dashboard.products.index')
            ->with('status', 'product-created');
    }

    public function edit(MaterialProduct $product)
    {
        $shop = $this->shopOrFail();
        $this->authorizeOwnership($product, $shop);

        $categories = MaterialCategory::orderBy('name')->get();
        $subcategories = MaterialSubcategory::where('material_category_id', $product->material_category_id)
            ->orderBy('name')
            ->get();

        return view('shop.dashboard.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(Request $request, MaterialProduct $product)
    {
        $shop = $this->shopOrFail();
        $this->authorizeOwnership($product, $shop);

        $validated = $this->validateProduct($request, $product);

        // Re-review after any edit to an already-approved listing.
        if ($product->status === 'approved') {
            $validated['status'] = 'pending';
            $validated['rejection_reason'] = null;
        }

        $product->update($validated);

        $this->syncImages($request, $product);

        return redirect()
            ->route('dashboard.products.index')
            ->with('status', 'product-updated');
    }

    public function destroy(MaterialProduct $product)
    {
        $shop = $this->shopOrFail();
        $this->authorizeOwnership($product, $shop);

        $product->delete(); // soft delete

        return back()->with('status', 'product-deleted');
    }

    private function authorizeOwnership(MaterialProduct $product, $shop): void
    {
        abort_if($product->shop_id !== $shop->id, Response::HTTP_FORBIDDEN);
    }

    private function validateProduct(Request $request, ?MaterialProduct $product = null): array
    {
        return $request->validate([
            'material_category_id'    => ['required', 'exists:material_categories,id'],
            'material_subcategory_id' => ['nullable', 'exists:material_subcategories,id'],
            'title'                   => ['required', 'string', 'max:255'],
            'description'             => ['nullable', 'string'],
            'price'                   => ['nullable', 'numeric', 'min:0'],
            'currency'                => ['required', 'string', 'in:RWF,USD'],
            'unit'                    => ['nullable', 'string', 'max:50'],
            'min_order_quantity'      => ['nullable', 'integer', 'min:1'],
            'stock_status'            => ['required', 'string', 'in:in_stock,out_of_stock,made_to_order'],
            'images.*'                => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function syncImages(Request $request, MaterialProduct $product): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        $hasPrimary = $product->images()->where('is_primary', true)->exists();

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store("products/{$product->id}", 'public');

            $product->images()->create([
                'path'       => $path,
                'is_primary' => !$hasPrimary && $index === 0,
                'order'      => $product->images()->count() + $index,
            ]);
        }
    }
}
