<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    /**/
    /* fetch all users favorite movies/series */
    /**/
    public function index(FavoriteService $favoriteService): JsonResponse
    {
        return $favoriteService->all(); // calling the favorites service which will handle the fetch functionnality
    }

    /**/
    /* store favorite serie in database */
    /**/
    public function storeFavTv(string $contentId, FavoriteService $favoriteService): JsonResponse
    {

        return $favoriteService->store($contentId, 'tv'); // returning success response
    }
    /**/
    /* Store movie as favorite for the user */
    /**/
    public function storeFavMovie(string $contentId, FavoriteService $favoriteService): JsonResponse
    {
        return $favoriteService->store($contentId, 'movie'); // returning success response
    }

    /**/
    /* remove movie from favorite list */
    /**/
    public function destroyFavMovie(string $id, FavoriteService $favoriteService): JsonResponse
    {
        return $favoriteService->delete($id, 'movie');
    }
    /**/
    /* remove series from favorite list  */
    /**/
    public function destroyFavSerie(string $id, FavoriteService $favoriteService): JsonResponse
    {
        return $favoriteService->delete($id, 'tv');
    }
}
