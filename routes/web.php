<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

// Halaman web admin
Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    // Dashboard / Generate Prediksi
    Route::get('/dashboard', [PredictionController::class, 'index'])
        ->name('dashboard');

    Route::get('/generate-prediction', [PredictionController::class, 'generate'])
        ->name('predictions.generate');

    // Data Penjualan
    Route::get('/data-penjualan', [SalesController::class, 'index'])
        ->name('sales');

    Route::post('/upload-dataset', [SalesController::class, 'upload'])
        ->name('upload.dataset');

    Route::put('/data-penjualan/{index}', [SalesController::class, 'update'])
        ->name('sales.update');

    Route::delete('/data-penjualan/{index}', [SalesController::class, 'destroy'])
        ->name('sales.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Master Data
    Route::resource('products', ProductController::class);

    // Manajemen Kasir
    Route::resource('users', UserController::class);
});

// Auth
require __DIR__.'/auth.php';