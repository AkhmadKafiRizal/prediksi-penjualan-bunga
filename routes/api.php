<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PredictionApiController;
use App\Http\Controllers\Api\DashboardSummaryApiController;
use App\Http\Controllers\Api\MobileAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/auth/login', [MobileAuthController::class, 'login']);
Route::post('/auth/logout', [MobileAuthController::class, 'logout']);

Route::get('/predictions', [PredictionApiController::class, 'index']);
Route::get('/dashboard/summary', [DashboardSummaryApiController::class, 'index']);