<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

// Home
Route::get('/', function () {
    $featured = \App\Models\Product::whereNotNull('image')->latest()->take(4)->get();
    return view('welcome', compact('featured'));
});

Route::get('/dashboard', fn() => redirect()->route('products.index'))->name('dashboard');

// Produk (customer)
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{id}', [ProductController::class, 'show'])->name('products.show');

// Keranjang (butuh login)
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Top Up
    Route::get('/topup', [\App\Http\Controllers\TopupController::class, 'index'])->name('topup.index');
    Route::post('/topup', [\App\Http\Controllers\TopupController::class, 'process'])->name('topup.process');

    // Transfer
    Route::get('/transfer', [\App\Http\Controllers\TransferController::class, 'index'])->name('transfer.index');
    Route::post('/transfer', [\App\Http\Controllers\TransferController::class, 'process'])->name('transfer.process');

    // Checkout
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/checkout/konfirmasi', [OrderController::class, 'confirm'])->name('order.confirm');

    // Riwayat Pemesanan
    Route::get('/riwayat', [OrderController::class, 'riwayat'])->name('order.riwayat');

    // Profile (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/tambah', [AdminController::class, 'create'])->name('create');
    Route::post('/tambah', [AdminController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
    Route::put('/edit/{id}', [AdminController::class, 'update'])->name('update');
    Route::delete('/hapus/{id}', [AdminController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';