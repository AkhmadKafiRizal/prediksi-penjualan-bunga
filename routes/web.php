<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Entry point aplikasi
|
*/

// Root route (smart redirect)
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
})->name('home');


/*
|--------------------------------------------------------------------------
| Dashboard (Machine Learning Prediction)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [PredictionController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Data Penjualan Bunga
|--------------------------------------------------------------------------
*/

Route::get('/data-penjualan', [SalesController::class, 'index'])
    ->middleware(['auth'])
    ->name('sales');

Route::post('/upload-dataset', [SalesController::class, 'upload'])
    ->middleware(['auth'])
    ->name('upload.dataset');

/*
|--------------------------------------------------------------------------
| Profile (harus login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Rute Autentikasi
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';