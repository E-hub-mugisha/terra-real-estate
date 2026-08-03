<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use App\Models\MaterialProduct;
use App\Models\MaterialProductImage;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MaterialProductController extends Controller
{
    // Adjust these to match your actual enum/column values.
    public const STOCK_STATUSES = ['in_stock', 'low_stock', 'out_of_stock'];
    public const STATUSES = ['pending', 'approved', 'rejected'];

    public function index(Request $request)
    {
        $query = MaterialProduct::query()
            ->with(['shop', 'category', 'subcategory', 'images'])
            ->withCount('images');

        if ($search = $request->string('search')->trim()->value()) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($shopId = $request->integer('shop_id')) {
            $query->where('shop_id', $shopId);
        }

        if ($categoryId = $request->integer('material_category_id')) {
            $query->where('material_category_id', $categoryId);
        }

        if ($status = $request->string('status')->value()) {
            $query->where('status', $status);
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        $shops = Shop::orderBy('name')->get();
        $categories = MaterialCategory::orderBy('name')->get();

        return view('admin.material-products.index', compact('products', 'shops', 'categories'));
    }

    public function create()
    {
        $product = new MaterialProduct();
        $shops = Shop::orderBy('name')->get();
        $categories = MaterialCategory::with('materialSubcategories')->orderBy('name')->get();

        return view('admin.material-products.create', [
            'product' => $product,
            'shops' => $shops,
            'categories' => $categories,
            'stockStatuses' => self::STOCK_STATUSES,
            'statuses' => self::STATUSES,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateProduct($request);

        DB::transaction(function () use ($validated, $request) {
            $product = MaterialProduct::create($validated);
            $this->storeUploadedImages($product, $request);
        });

        return redirect()
            ->route('admin.materials-products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(MaterialProduct $materialsProduct)
    {
        $materialsProduct->load(['shop', 'category', 'subcategory', 'images']);

        return view('admin.material-products.show', ['product' => $materialsProduct]);
    }

    public function edit(MaterialProduct $materialsProduct)
    {
        $materialsProduct->load(['images']);

        $shops = Shop::orderBy('name')->get();
        $categories = MaterialCategory::with('materialSubcategories')->orderBy('name')->get();

        return view('admin.material-products.edit', [
            'product' => $materialsProduct,
            'shops' => $shops,
            'categories' => $categories,
            'stockStatuses' => self::STOCK_STATUSES,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, MaterialProduct $materialsProduct)
    {
        $validated = $this->validateProduct($request, $materialsProduct);

        DB::transaction(function () use ($validated, $request, $materialsProduct) {
            $materialsProduct->update($validated);

            // Delete images the user checked for removal.
            $deleteIds = collect($request->input('delete_images', []))->map(fn ($id) => (int) $id);
            if ($deleteIds->isNotEmpty()) {
                $toDelete = $materialsProduct->images()->whereIn('id', $deleteIds)->get();
                foreach ($toDelete as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }

            // Set primary image.
            if ($primaryId = $request->integer('primary_image_id')) {
                $materialsProduct->images()->update(['is_primary' => false]);
                $materialsProduct->images()->where('id', $primaryId)->update(['is_primary' => true]);
            }

            $this->storeUploadedImages($materialsProduct, $request);
        });

        return redirect()
            ->route('admin.materials-products.edit', $materialsProduct)
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(MaterialProduct $materialsProduct)
    {
        $materialsProduct->delete();

        return redirect()
            ->route('admin.materials-products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function validateProduct(Request $request, ?MaterialProduct $product = null): array
    {
        $validated = $request->validate([
            'shop_id' => ['required', 'exists:shops,id'],
            'material_category_id' => ['required', 'exists:material_categories,id'],
            'material_subcategory_id' => ['nullable', 'exists:material_subcategories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'unit' => ['nullable', 'string', 'max:100'],
            'min_order_quantity' => ['nullable', 'integer', 'min:1'],
            'stock_status' => ['required', 'in:' . implode(',', self::STOCK_STATUSES)],
            'status' => ['required', 'in:' . implode(',', self::STATUSES)],
            'rejection_reason' => ['nullable', 'string', 'required_if:status,rejected'],
            'is_featured' => ['sometimes', 'boolean'],
            'images.*' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($validated['status'] !== 'rejected') {
            $validated['rejection_reason'] = null;
        }

        return $validated;
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

            MaterialProductImage::create([
                'material_product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => ! $hasPrimaryAlready && $index === 0,
                'order' => $nextOrder++,
            ]);
        }
    }
}