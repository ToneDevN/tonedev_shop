<?php

use Illuminate\Support\Facades\Route;

Route::get('register', fn () => view('auth.register'))->name('register');
Route::get('login', fn () => view('auth.login'))->name('login');

Route::middleware('auth')->group(function () {
    Route::post('logout', function () {
        // ลบ JWT cookie และ session
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/')->cookie('jwt_token', '', -1);
    })->name('logout');
});
