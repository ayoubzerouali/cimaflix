<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Route;


Route::controller(FavoriteController::class)->prefix('/v1/movies/favorites')->group(function () {
    Route::get('/', 'index')->middleware('auth:sanctum');
    Route::post('/{id}', 'store')->middleware('auth:sanctum');
});

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
});
