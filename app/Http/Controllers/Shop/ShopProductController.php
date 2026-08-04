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
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ShopProductController extends Controller
{
    public const STOCK_STATUSES = ['in_stock', 'out_of_stock', 'made_to_order'];
    public const CURRENCIES = ['RWF', 'USD'];

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
            ->withCount('images')
            ->latest()
            ->paginate(10);

        return view('shop-panel.products.index', compact('products', 'shop'));
    }

    public function create()
    {
        $this->shopOrFail();

        $product = new MaterialProduct();
        $categories = MaterialCategory::with('materialSubcategories')->orderBy('name')->get();

        return view('shop-panel.products.create', [
            'product' => $product,
            'categories' => $categories,
            'stockStatuses' => self::STOCK_STATUSES,
            'currencies' => self::CURRENCIES,
        ]);
    }

    public function store(Request $request)
    {
        $shop = $this->shopOrFail();

        $validated = $this->validateProduct($request);

        DB::transaction(function () use ($shop, $validated, $request, &$product) {
            $product = $shop->materialProducts()->create($validated + ['status' => 'pending']);
            $this->storeUploadedImages($product, $request);
        });

        return redirect()
            ->route('shop-panel.products.index')
            ->with('status', 'product-created');
    }

    public function show(MaterialProduct $product)
    {
        $shop = $this->shopOrFail();
        $this->authorizeOwnership($product, $shop);

        $product->load(['category', 'subcategory', 'images']);

        return view('shop-panel.products.show', compact('product'));
    }

    public function edit(MaterialProduct $product)
    {
        $shop = $this->shopOrFail();
        $this->authorizeOwnership($product, $shop);

        $product->load(['images']);

        $categories = MaterialCategory::with('materialSubcategories')->orderBy('name')->get();
        $subcategories = MaterialSubcategory::where('material_category_id', $product->material_category_id)
            ->orderBy('name')
            ->get();

        return view('shop-panel.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'stockStatuses' => self::STOCK_STATUSES,
            'currencies' => self::CURRENCIES,
        ]);
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

        DB::transaction(function () use ($validated, $request, $product) {
            $product->update($validated);

            // Delete images the user checked for removal.
            $deleteIds = collect($request->input('delete_images', []))->map(fn ($id) => (int) $id);
            if ($deleteIds->isNotEmpty()) {
                $toDelete = $product->images()->whereIn('id', $deleteIds)->get();
                foreach ($toDelete as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            // Set primary image.
            if ($primaryId = $request->integer('primary_image_id')) {
                $product->images()->update(['is_primary' => false]);
                $product->images()->where('id', $primaryId)->update(['is_primary' => true]);
            }

            $this->storeUploadedImages($product, $request);
        });

        return redirect()
            ->route('shop-panel.products.edit', $product)
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
            'currency'                => ['required', 'string', 'in:' . implode(',', self::CURRENCIES)],
            'unit'                    => ['nullable', 'string', 'max:50'],
            'min_order_quantity'      => ['nullable', 'integer', 'min:1'],
            'stock_status'            => ['required', 'string', 'in:' . implode(',', self::STOCK_STATUSES)],
            'images.*'                => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function storeUploadedImages(MaterialProduct $product, Request $request): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $hasPrimaryAlready = $product->images()->where('is_primary', true)->exists();
        $nextOrder = (int) $product->images()->max('order') + 1;

        foreach ($request->file('images') as $index => $file) {
            if (! $file || ! $file->isValid()) {
                continue;
            }

            $path = $file->store('materials/products', 'public');

            $product->images()->create([
                'image_path' => $path,
                'is_primary' => ! $hasPrimaryAlready && $index === 0,
                'order' => $nextOrder++,
            ]);
        }
    }
}