<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PredictionApiController;
use App\Http\Controllers\Api\DashboardSummaryApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/predictions', [PredictionApiController::class, 'index']);
Route::get('/dashboard/summary', [DashboardSummaryApiController::class, 'index']);