<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Route;



Route::controller(FavoriteController::class)->prefix('/v1/movies/favorites')->group(function () {
    Route::get('/', 'index')->middleware('auth:sanctum'); // retrieve all favorites
    Route::post('/movie/{id}', 'storeMovie')->middleware('auth:sanctum'); // store favorite
    Route::post('/tv/{id}', 'storeTv')->middleware('auth:sanctum'); // store favorite
    Route::delete('/{id}', 'destroy')->middleware('auth:sanctum'); // delete favorite
});

Route::prefix('/v1')->group(function () {
    Route::get('/user', [AuthController::class,'auth'])->middleware('auth:sanctum');

    Route::get('search', [SearchController::class, 'search']);
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
