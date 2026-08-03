<?php

use App\Http\Controllers\Front\MaterialController;
use App\Http\Controllers\Front\ShopRegistrationController;
use App\Http\Controllers\Shop\ShopDashboardController;
use App\Http\Controllers\Shop\ShopProductController;
use App\Http\Controllers\Shop\ShopProfileController;
use App\Http\Controllers\Admin\Materials\MaterialCategoryController as AdminMaterialCategoryController;
use App\Http\Controllers\Admin\Materials\MaterialProductController as AdminMaterialProductController;
use App\Http\Controllers\Admin\Materials\ShopController as AdminShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public — /materials
|--------------------------------------------------------------------------
| Anyone can browse. No auth required. This mirrors the marketplace.blade
| page you already have — same filter-bar / grid pattern, just a new
| top-level section instead of tabs on the existing property page.
*/
Route::prefix('materials')->name('front.materials.')->group(function () {
    Route::get('/', [MaterialController::class, 'index'])->name('index');
    Route::get('/category/{category:slug}', [MaterialController::class, 'category'])->name('category');
    Route::get('/product/{product:slug}', [MaterialController::class, 'show'])->name('product.show');
    Route::get('/shop/{shop:slug}', [MaterialController::class, 'shop'])->name('shop.show');

    // WhatsApp click tracking (optional analytics — fire-and-forget POST before redirect)
    Route::post('/product/{product:slug}/whatsapp-click', [MaterialController::class, 'trackWhatsappClick'])
        ->name('product.whatsapp-click');
});

/*
|--------------------------------------------------------------------------
| Shop registration — public form, creates a pending Shop
|--------------------------------------------------------------------------
*/
Route::prefix('materials/register')->name('front.materials.register.')->group(function () {
    Route::get('/', [ShopRegistrationController::class, 'create'])->name('create');
    Route::post('/', [ShopRegistrationController::class, 'store'])->name('store');
});

/*
|--------------------------------------------------------------------------
| Shop dashboard — authenticated shop owners only
|--------------------------------------------------------------------------
| Assumes a 'shop_owner' role/middleware similar to however Terra already
| gates agent/consultant dashboards. Adjust the middleware name to match
| your existing role-check convention.
*/
Route::middleware(['auth', 'role:shop_owner'])
    ->prefix('shop')
    ->name('shop.')
    ->group(function () {
        Route::get('/dashboard', ShopDashboardController::class)->name('dashboard');

        Route::get('/profile', [ShopProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ShopProfileController::class, 'update'])->name('profile.update');

        Route::resource('/products', ShopProductController::class)
            ->except(['show'])
            ->parameters(['products' => 'product']);
    });

/*
|--------------------------------------------------------------------------
| Admin — moderation (shops, products, categories)
|--------------------------------------------------------------------------
| Nest these inside your existing admin route group / middleware stack.
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin/materials')
    ->name('admin.materials.')
    ->group(function () {
        Route::get('/shops', [AdminShopController::class, 'index'])->name('shops.index');
        Route::patch('/shops/{shop}/approve', [AdminShopController::class, 'approve'])->name('shops.approve');
        Route::patch('/shops/{shop}/reject', [AdminShopController::class, 'reject'])->name('shops.reject');
        Route::patch('/shops/{shop}/suspend', [AdminShopController::class, 'suspend'])->name('shops.suspend');

        Route::get('/products', [AdminMaterialProductController::class, 'index'])->name('products.index');
        Route::patch('/products/{product}/approve', [AdminMaterialProductController::class, 'approve'])->name('products.approve');
        Route::patch('/products/{product}/reject', [AdminMaterialProductController::class, 'reject'])->name('products.reject');

        Route::resource('/categories', AdminMaterialCategoryController::class)
            ->parameters(['categories' => 'category']);
    });
