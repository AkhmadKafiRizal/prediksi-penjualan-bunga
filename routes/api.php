<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PredictionApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/predictions', [PredictionApiController::class, 'index']);