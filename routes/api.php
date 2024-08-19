<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MovieController;
use App\Http\Controllers\Api\V1\AuthController;
/* use Illuminate\Support\Facades\Auth; */



Route::prefix('/v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::apiResource('movies', MovieController::class)->only(['index', 'show']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', function (Request $request) {
            return $request->user();
        });
        Route::apiResource('movies', MovieController::class)->except(['index', 'show']);
    });
});
