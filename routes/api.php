<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PredictionApiController;
use App\Http\Controllers\Api\DashboardSummaryApiController;
use App\Http\Controllers\Api\MobileAuthController;
use App\Http\Controllers\Api\StockApiController;
use App\Http\Controllers\Api\TransactionApiController;
use App\Http\Controllers\Api\ChatbotController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua endpoint API untuk aplikasi mobile dan kebutuhan dashboard.
*/

/*
|--------------------------------------------------------------------------
| Mobile Auth API
|--------------------------------------------------------------------------
| Dipakai Flutter untuk login/logout kasir.
*/
Route::post('/auth/login', [MobileAuthController::class, 'login']);
Route::post('/auth/logout', [MobileAuthController::class, 'logout']);
Route::post('/auth/forgot-password', [MobileAuthController::class, 'forgotPassword']);
Route::post('/auth/verify-otp', [MobileAuthController::class, 'verifyOtp']);
Route::post('/auth/reset-password', [MobileAuthController::class, 'resetPassword']);

/*
|--------------------------------------------------------------------------
| Mobile Dashboard & Prediction API
|--------------------------------------------------------------------------
| Dipakai Flutter untuk membaca ringkasan dashboard dan hasil prediksi.
*/
Route::get('/dashboard/summary', [DashboardSummaryApiController::class, 'index']);
Route::get('/predictions', [PredictionApiController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Mobile Stock API
|--------------------------------------------------------------------------
| Dipakai Flutter untuk membaca, menambah, dan mengubah stok produk.
*/
Route::get('/stocks', [StockApiController::class, 'index']);
Route::post('/stocks', [StockApiController::class, 'store']);
Route::patch('/stocks/{id}/adjust', [StockApiController::class, 'adjust']);

/*
|--------------------------------------------------------------------------
| Mobile Transaction API
|--------------------------------------------------------------------------
| Dipakai Flutter untuk menyimpan transaksi kasir ke MongoDB collection penjualans.
*/
Route::get('/transactions', [TransactionApiController::class, 'index']);
Route::post('/transactions', [TransactionApiController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Cetbot
|--------------------------------------------------------------------------
| Dipakai buat cetbot :v
*/

Route::post('/chatbot/send', [ChatbotController::class, 'send']);
