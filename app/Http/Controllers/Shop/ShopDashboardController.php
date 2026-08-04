<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Inertia\Inertia;
use Inertia\Response;

class ShopDashboardController extends Controller
{
    public function index(Request $request)
    {
        $shop = $request->user()->shop;

        $products = $shop->materialProducts();

        $stats = [
            'total'     => (clone $products)->count(),
            'approved'  => (clone $products)->where('status', 'approved')->count(),
            'pending'   => (clone $products)->where('status', 'pending')->count(),
            'rejected'  => (clone $products)->where('status', 'rejected')->count(),
            'out_stock' => (clone $products)->where('stock_status', 'out_of_stock')->count(),
        ];

        $recentProducts = $shop->materialProducts()
            ->with(['category', 'images'])
            ->latest()
            ->take(5)
            ->get();

        // Last 6 months of product submissions, for the chart
        $months = collect(range(5, 0))->map(fn ($i) => Carbon::now()->subMonths($i));

        $chartLabels = $months->map(fn ($m) => $m->format('M'))->toArray();

        $chartData = $months->map(function ($month) use ($shop) {
            return $shop->materialProducts()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        })->toArray();

        return view('shop-panel.dashboard.index', compact('shop', 'stats', 'recentProducts', 'chartLabels', 'chartData'));
    }
}
