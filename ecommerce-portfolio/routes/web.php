<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Owner\OrderController as OwnerOrderController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\ProductController as OwnerProductController;

// หน้าแรกและหน้ารายละเอียดสินค้า
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/search/autocomplete', [ProductController::class, 'autocomplete'])->name('products.autocomplete');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// ตะกร้าสินค้า
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// หน้า Checkout
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
Route::get('/track-order', function() {
    return view('orders.track');
})->name('orders.track');

Route::post('/track-order', [App\Http\Controllers\OrderController::class, 'track'])->name('orders.track.search');

// Owner Routes
Route::prefix('owner')->name('owner.')->middleware(['auth.required', 'role:owner,admin'])->group(function () {
    Route::get('/', [OwnerDashboardController::class, 'index'])->name('dashboard');
    Route::post('/products/create', [OwnerProductController::class,'create'])->name('products.create');
    Route::get('/orders', [OwnerOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OwnerOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OwnerOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth.required')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile/address', [AddressController::class, 'index'])->name('profile.address');
    Route::post('/profile/address', [AddressController::class, 'store'])->name('profile.address.store');
    Route::patch('/profile/address/{address}', [AddressController::class, 'update'])->name('profile.address.update');
    Route::delete('/profile/address/{address}', [AddressController::class, 'destroy'])->name('profile.address.destroy');

    Route::get('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/privacy', [ProfileController::class, 'privacy'])->name('profile.privacy');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/notifications', [ProfileController::class, 'notifications'])->name('profile.notifications');
    Route::get('/profile/coupons', [ProfileController::class, 'coupons'])->name('profile.coupons');
    Route::get('/profile/coins', [ProfileController::class, 'coins'])->name('profile.coins');
});

require __DIR__.'/auth.php';
