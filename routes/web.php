<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;

// Halaman Home
Route::get('/', function () {
    return view('home');
})->name('home');

// Halaman Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Biometric login
Route::get('/login/biometric/{type}', [AuthController::class, 'biometricLogin'])->name('login.biometric');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route group untuk Admin (harus login & role admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    // Tambah route admin lainnya di sini
});

// Route group untuk Pegawai (harus login & role pegawai)
Route::middleware(['auth', 'role:pegawai'])->group(function () {
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.dashboard');
    // Tambah route pegawai lainnya di sini
});
