<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatbotPageController;
use Illuminate\Support\Facades\Route;

// Root redirect
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    // ==================== DASHBOARD ====================
    Route::get('/dashboard', [PredictionController::class, 'dashboard'])
        ->name('dashboard');

    // ==================== PREDIKSI ====================
    Route::get('/prediksi', [PredictionController::class, 'index'])
        ->name('prediksi');

    // Generate menerima ?periode=YYYY-MM via query string
    Route::get('/prediksi/generate', [PredictionController::class, 'generate'])
        ->name('predictions.generate');

    Route::get('/predictions/export', [PredictionController::class, 'export'])
        ->name('predictions.export');

    // ==================== DATA PENJUALAN ====================
    Route::get('/data-penjualan', [SalesController::class, 'index'])
        ->name('sales');

    Route::get('/data-penjualan/export', [SalesController::class, 'export'])
        ->name('sales.export');

    // ==================== MASTER DATA PRODUK ====================
    Route::resource('products', ProductController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);

    // ==================== MANAJEMEN USER ====================
    Route::resource('users', UserController::class);

    // ==================== PROFILE ====================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // ==================== ASISTEN AI ====================
    Route::get('/asisten-ai', [ChatbotPageController::class, 'index'])
        ->name('chatbot');
});

require __DIR__.'/auth.php';
