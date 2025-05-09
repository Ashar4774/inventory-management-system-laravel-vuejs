<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VendorController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('category', CategoryController::class);
Route::resource('inventory', InventoryController::class);
Route::resource('vendor', VendorController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
