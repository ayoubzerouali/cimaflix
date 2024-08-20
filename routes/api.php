<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Route;


Route::prefix('/v1/movies/favorites')->controller(FavoriteController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/{movie}', 'store');
})->middleware('auth:sanctum');

Route::prefix('/v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::prefix('series')->controller(SerieController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('show/{serie}', 'show');
        Route::get('trailer/{serieId}', 'trailer');
        Route::get('top', 'topRated');
    });
    Route::prefix('movies')->controller(MovieController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('show/{movie}', 'show');
        Route::get('trailer/{movieId}', 'trailer');
        Route::get('top', 'topRated');
    });
});
