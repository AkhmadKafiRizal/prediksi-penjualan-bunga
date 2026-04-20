<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ── Root redirect ──────────────────────────────────────────────
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

// ── Dashboard ──────────────────────────────────────────────────
Route::get('/dashboard', [PredictionController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ── Data Penjualan ─────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Tampilkan tabel + search
    Route::get('/data-penjualan', [SalesController::class, 'index'])
        ->name('sales');

    // Upload dataset (ganti seluruh CSV)
    Route::post('/upload-dataset', [SalesController::class, 'upload'])
        ->name('upload.dataset');

    // Edit 1 baris
    Route::put('/data-penjualan/{index}', [SalesController::class, 'update'])
        ->name('sales.update');

    // Hapus 1 baris
    Route::delete('/data-penjualan/{index}', [SalesController::class, 'destroy'])
        ->name('sales.destroy');

});

// ── Profile ────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('products', ProductController::class)->middleware('auth');
Route::resource('users', UserController::class)->middleware('auth');

// ── Auth ───────────────────────────────────────────────────────
require __DIR__.'/auth.php';