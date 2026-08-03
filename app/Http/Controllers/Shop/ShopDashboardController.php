<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShopDashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $shop = $request->user()->shop()->withCount([
            'products',
            'products as approved_products_count' => fn ($q) => $q->where('status', 'approved'),
            'products as pending_products_count' => fn ($q) => $q->where('status', 'pending'),
        ])->firstOrFail();

        $recentProducts = $shop->products()
            ->with(['category', 'images'])
            ->latest()
            ->limit(6)
            ->get();

        return Inertia::render('Shop/Dashboard', [
            'shop' => $shop,
            'recentProducts' => $recentProducts,
            'totalWhatsappClicks' => $shop->products()->sum('whatsapp_clicks_count'),
        ]);
    }
}
