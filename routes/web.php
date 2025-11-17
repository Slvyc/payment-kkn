<?php

use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Auth\LoginAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CetakInvoice;
use App\Http\Controllers\Mahasiswa\PendaftaranController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\DashboardMahasiswaController;

// login mahasiswa
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/auth/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// login admin
Route::get('/login-admin', [LoginAdminController::class, 'index'])->name('login.admin');
Route::post('/auth/login/admin', [LoginAdminController::class, 'login'])->name('login.admin.post');
Route::get('/logout/admin', [LoginAdminController::class, 'logout'])->name('logout.admin');

// Notif Handler MIDTRANS
Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handle']);

// Mahasiswa
Route::middleware(['auth.mahasiswa'])->prefix('mahasiswa')->group(function () {

    // Dashboard Mahasiswa
    Route::get('/dashboard', [DashboardMahasiswaController::class, 'index'])->name('mahasiswa.dashboard');
    // Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa');

    // Halaman Pembayaran dan Transaksi
    Route::get('/kkn', [PendaftaranController::class, 'index'])->name('mahasiswa.pembayaran');
    Route::post('/kkn/pembayaran', [PendaftaranController::class, 'createTransaction'])->name('mahasiswa.pembayaran.daftar');

    // Cancel Transaksi
    Route::post('/kkn/cancel/{id}', [PendaftaranController::class, 'cancelTransaction'])->name('mahasiswa.pembayaran.cancel');

    // Riwayat Transaksi
    Route::get('/riwayat-transaksi', [PendaftaranController::class, 'riwayatTransaksi'])->name('mahasiswa.riwayat');
    // Cetak Invoice
    Route::get('/riwayat/cetak/{id}', [CetakInvoice::class, 'cetakTransaksi']) // Sesuaikan Controller
        ->name('mahasiswa.cetak');
});

// Admin
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard.admin');
    // Route mahasiswa
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.admin');
});

Route::get('/profile', function () {
    return view('profile');
})->name('profile');


Route::get('/cek', function () {
    return view('cek');
})->name('cek');
