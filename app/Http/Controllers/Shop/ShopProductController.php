<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Materials\StoreMaterialProductRequest;
use App\Http\Requests\Materials\UpdateMaterialProductRequest;
use App\Models\MaterialCategory;
use App\Models\MaterialProduct;
use App\Models\MaterialProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ShopProductController extends Controller
{
    public function index(Request $request): Response
    {
        $shop = $request->user()->shop()->firstOrFail();

        $products = $shop->products()
            ->with(['category', 'subcategory', 'images'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('Shop/Products/Index', [
            'products' => $products,
        ]);
    }

    public function create(Request $request): Response
    {
        return Inertia::render('Shop/Products/Form', [
            'categories' => MaterialCategory::active()->with('activeSubcategories')->get(),
            'product' => null,
        ]);
    }

    public function store(StoreMaterialProductRequest $request)
    {
        $shop = $request->user()->shop()->firstOrFail();

        abort_unless($shop->status === 'approved', 403, 'Your shop must be approved before you can list products.');

        $product = DB::transaction(function () use ($request, $shop) {
            $data = $request->safe()->except(['images', 'primary_image_index']);
            $data['shop_id'] = $shop->id;
            $data['currency'] = $data['currency'] ?? 'RWF';
            $data['status'] = 'pending'; // every new/edited product is re-moderated

            $product = MaterialProduct::create($data);

            $this->storeImages($product, $request);

            return $product;
        });

        return redirect()
            ->route('shop.products.index')
            ->with('success', "\"{$product->title}\" was submitted and is awaiting admin approval.");
    }

    public function edit(Request $request, MaterialProduct $product): Response
    {
        $this->authorizeOwnership($request, $product);

        return Inertia::render('Shop/Products/Form', [
            'categories' => MaterialCategory::active()->with('activeSubcategories')->get(),
            'product' => $product->load(['images', 'category', 'subcategory']),
        ]);
    }

    public function update(UpdateMaterialProductRequest $request, MaterialProduct $product)
    {
        $this->authorizeOwnership($request, $product);

        DB::transaction(function () use ($request, $product) {
            $data = $request->safe()->except(['images', 'primary_image_index', 'remove_image_ids']);
            $data['currency'] = $data['currency'] ?? 'RWF';
            $data['status'] = 'pending'; // edits go back through moderation

            $product->update($data);

            if ($ids = $request->input('remove_image_ids')) {
                $product->images()->whereIn('id', $ids)->each(function (MaterialProductImage $img) {
                    \Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                });
            }

            $this->storeImages($product, $request);
        });

        return redirect()
            ->route('shop.products.index')
            ->with('success', "\"{$product->title}\" was updated and is awaiting re-approval.");
    }

    public function destroy(Request $request, MaterialProduct $product)
    {
        $this->authorizeOwnership($request, $product);

        foreach ($product->images as $image) {
            \Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return back()->with('success', 'Product removed.');
    }

    private function authorizeOwnership(Request $request, MaterialProduct $product): void
    {
        abort_unless($request->user()->shop?->id === $product->shop_id, 403);
    }

    private function storeImages(MaterialProduct $product, Request $request): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $primaryIndex = (int) $request->input('primary_image_index', 0);
        $hasExistingPrimary = $product->images()->where('is_primary', true)->exists();

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('materials/products', 'public');

            $product->images()->create([
                'image_path' => $path,
                'is_primary' => ! $hasExistingPrimary && $index === $primaryIndex,
                'order' => $product->images()->count(),
            ]);
        }
    }
}
