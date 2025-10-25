<?php

use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// login mahasiswa
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/auth/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// login admin
Route::get('/login-admin', [LoginAdminController::class, 'index'])->name('login.admin');
Route::post('/auth/login/admin', [LoginAdminController::class, 'login'])->name('login.admin.post');
Route::get('/logout/admin', [LoginAdminController::class, 'logout'])->name('logout.admin');


Route::middleware(['auth.mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard.admin');
});


Route::get('/table', function () {
    return view('tables');
})->name('table');

Route::get('/billing', function () {
    return view('billing');
})->name('billing');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');
