<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function show(Request $request, Shop $shop)
    {
        abort_unless($shop->isApproved(), 404);

        $shop->increment('views_count');

        $products = $shop->materialProducts()
            ->approved()
            ->with(['images', 'category', 'subcategory'])
            ->when(
                $request->get('q'),
                fn($q, $search) =>
                $q->where('title', 'like', "%{$search}%")
            )
            ->orderByDesc('is_featured')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('front.shop.show', [
            'shop'     => $shop,
            'products' => $products,
            'search'   => $request->get('q'),
        ]);
    }
    /**
     * List shops, optionally filtered by province and district.
     */
    public function locations(Request $request, ?string $province = null, ?string $district = null)
    {
        $query = Shop::approved()->withCount('materialProducts');

        if ($province) {
            $query->where('province', $province);
        }

        if ($district) {
            $query->where('district', $district);
        }

        if ($search = $request->get('q')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $shops = $query
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $districts = $province
            ? Shop::approved()
            ->where('province', $province)
            ->whereNotNull('district')
            ->distinct()
            ->orderBy('district')
            ->pluck('district')
            : collect();

        $provinces = Shop::approved()
            ->whereNotNull('province')
            ->distinct()
            ->orderBy('province')
            ->pluck('province');

        return view('front.shop.locations', [
            'shops'     => $shops,
            'province'  => $province,
            'district'  => $district,
            'districts' => $districts,
            'provinces' => $provinces,
            'search'    => $search ?? null,
        ]);
    }
}
