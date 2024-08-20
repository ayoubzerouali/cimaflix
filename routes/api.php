<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MovieController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\SerieController;

/* use Illuminate\Support\Facades\Auth; */



Route::prefix('/v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::prefix('series')->controller(SerieController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('show/{id}', 'show');
        Route::get('trailer/{serieId}', 'trailer');
        Route::get('top', 'topRated');
    });
    Route::prefix('movies')->controller(MovieController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('show/{id}', 'show');
        Route::get('trailer/{movieId}', 'trailer');
        Route::get('top', 'topRated');
    });



    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', function (Request $request) {
            return $request->user();
        });
    });
});
