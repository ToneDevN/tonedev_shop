<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\AddressController;
use App\Http\Controllers\Member\OrderController as MemberOrderController;
use App\Http\Controllers\Member\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\OrderController as OwnerOrderController;
use App\Http\Controllers\Owner\ProductController as OwnerProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Public ──────────────────────────────────────────────────────────────────

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/search/autocomplete', [ProductController::class, 'autocomplete'])->name('products.autocomplete');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout (guest + auth)
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

// Order tracking
Route::get('/track-order', fn () => view('orders.track'))->name('orders.track');
Route::post('/track-order', [OrderController::class, 'track'])->name('orders.track.search');

// ─── Authenticated (member) ──────────────────────────────────────────────────

Route::middleware(['auth', 'verified'])->group(function (): void {

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Member orders
    Route::prefix('orders')->name('member.orders.')->group(function (): void {
        Route::get('/', [MemberOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [MemberOrderController::class, 'show'])->name('show');
        Route::post('/{order}/payment/slip', [MemberOrderController::class, 'uploadSlip'])->name('slip.upload');
    });

    // Member addresses
    Route::resource('addresses', AddressController::class)->except(['show']);

    // Member reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// ─── Owner ────────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'role:owner|admin'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function (): void {
        Route::get('/', [OwnerDashboardController::class, 'index'])->name('dashboard');

        // Products
        Route::get('/products/create', [OwnerProductController::class, 'create'])->name('products.create');
        Route::post('/products', [OwnerProductController::class, 'store'])->name('products.store');

        // Orders
        Route::get('/orders', [OwnerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [OwnerOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [OwnerOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

// ─── Admin ────────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    });

require __DIR__.'/auth.php';
