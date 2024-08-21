<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Facades\Route;

/**
 * API routes for managing user favorites.
 */
Route::controller(FavoriteController::class)->prefix('/v1/favorites')->group(function () {
    // get all favorites for the authenticated user.
    Route::get('/', 'index')->middleware('auth:sanctum');

    // store a movie as a favorite for the authenticated user.
    Route::post('/movie/{id}', 'storeFavMovie')->middleware('auth:sanctum');

    // etore a tv show as a favorite for the authenticated user.
    Route::post('/tv/{id}', 'storeFavTv')->middleware('auth:sanctum');

    // remove a movie from the user's favorites.
    Route::delete('/{id}', 'destroyFavMovie')->middleware('auth:sanctum');

    // remove a tv show from the user's favorites.
    Route::delete('/{id}', 'destroyFavMovie')->middleware('auth:sanctum');
});

/**
 * API routes for user authentication, searching, and accessing series and movies.
 */
Route::prefix('/v1')->group(function () {
    // get the authenticated user's information.
    Route::get('/user', [AuthController::class, 'auth'])->middleware('auth:sanctum');

    // search for movies or tv shows.
    Route::get('search', [SearchController::class, 'search']);

    // rrgister a new user.
    Route::post('/register', [AuthController::class, 'register']);

    // log in an existing user.
    Route::post('/login', [AuthController::class, 'login']);

    // routes for managing series.
    Route::prefix('series')->controller(SerieController::class)->group(function () {
        // Get a list of series.
        Route::get('/', 'index');

        // Get details of a specific series by its ID.
        Route::get('show/{id}', 'show');

        // Get the trailer for a specific series.
        Route::get('trailer/{serieId}', 'trailer');

        // Get a list of top-rated series.
        Route::get('top', 'topRated');
    });

    // routes for managing movies.
    Route::prefix('movies')->controller(MovieController::class)->group(function () {
        // get a list of movies.
        Route::get('/', 'index');

        // get details of a specific movie by its ID.
        Route::get('show/{id}', 'show');

        // get the trailer for a specific movie.
        Route::get('trailer/{movieId}', 'trailer');

        // Get a list of top-rated movies.
        Route::get('top', 'topRated');
    });
});
