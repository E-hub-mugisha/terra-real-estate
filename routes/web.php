<?php

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
    Route::get('/properties/pending', [PropertyController::class, 'index'])->name('admin.properties.pending');
    Route::post('/properties/{property}/approve', [PropertyController::class, 'approve'])->name('admin.properties.approve');
});

require __DIR__.'/auth.php';
