<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImageUploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::apiResource('categories', CategoryController::class);
// Auth routes (public)
Route::post('/auth/login', [AuthController::class, 'login'])->name('api.auth.login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('api.auth.register');

// Auth routes (protected)
Route::middleware('auth.required')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
    Route::get('/auth/me', [AuthController::class, 'me'])->name('api.auth.me');

    // Image upload (แปลง jpeg/png → WebP ก่อนจัดเก็บ)
    Route::post('/upload/image', [ImageUploadController::class, 'upload'])->name('api.upload.image');
});

// Member routes
Route::middleware(['auth.required', 'role:member,owner,admin'])->prefix('member')->group(function () {
    // member-specific routes
});

// Owner routes
Route::middleware(['auth.required', 'role:owner,admin'])->prefix('owner')->group(function () {
    // owner-specific routes
});

// Admin routes
Route::middleware(['auth.required', 'role:admin'])->prefix('admin')->group(function () {
    // admin-specific routes
});
