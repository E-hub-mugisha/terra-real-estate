<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Properties\HouseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::resource('properties', PropertyController::class);
});

// routes/web.php
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/land/properties', [PropertyController::class, 'land'])->name('admin.properties.land.index');
    Route::get('/create/properties', [PropertyController::class, 'create'])->name('admin.property.create');
    Route::get('/properties/pending', [PropertyController::class, 'index'])->name('admin.properties.pending');
    Route::post('/properties/{property}/approve', [PropertyController::class, 'approve'])->name('admin.properties.approve');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/house', [HouseController::class, 'index'])->name('admin.properties.house.index');
    Route::get('/houses/create', [HouseController::class, 'create'])->name('admin.properties.houses.create');
    Route::post('/houses', [HouseController::class, 'store'])->name('admin.properties.houses.store');
    Route::get('/houses/{house}', [HouseController::class, 'show'])->name('admin.properties.houses.show');
});
require __DIR__ . '/auth.php';
