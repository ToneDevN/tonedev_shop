<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

// Auth routes (public)
Route::post('/auth/login', [AuthController::class, 'login'])->name('api.auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('api.auth.register');

// Auth routes (protected)
Route::middleware('jwt.auth')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    Route::get('/auth/me', [AuthController::class, 'me'])->name('api.auth.me');
});

// Member routes
Route::middleware(['jwt.auth', 'role:member,owner,admin'])->prefix('member')->group(function () {
    // member-specific routes
});

// Owner routes
Route::middleware(['jwt.auth', 'role:owner,admin'])->prefix('owner')->group(function () {
    // owner-specific routes
});

// Admin routes
Route::middleware(['jwt.auth', 'role:admin'])->prefix('admin')->group(function () {
    // admin-specific routes
});
