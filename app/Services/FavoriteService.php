<?php

namespace App\Services;

use App\Models\Favorite;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * A service class to handle favorite movies/series operations.
 *
 * @method JsonResponse all() Get all favorite movies/series for the authenticated user.
 * @method JsonResponse store(string $id, string $type) Add a movie or series to the authenticated user's favorites.
 * @method JsonResponse delete(string $id, string $type) Remove a movie or series from the authenticated user's favorites.
 */

class FavoriteService
{
    /**
     * Get a paginated list of the authenticated user's favorite movies/series.
     *
     * @return JsonResponse JSON response with the paginated favorite list.
     */
    public function all()
    {
        $response = Favorite::where('user_id', Auth::id())->paginate(10); // this line gets a collection of the user's favorite movies

        return response()->json([
            'success' => true,
            'data' => $response
        ]);
    }
      /**
     * Add a movie or series to the authenticated user's favorites.
     *
     * @param string $id The ID of the movie or series.
     * @param string $type The type (either 'movie' or 'series').
     * @return JsonResponse JSON response confirming the addition.
     */
    public  function store(string $id, string $type): JsonResponse
    {
        $user = Auth::id(); // user id
        Favorite::create([ // using create function to register a record in favorites table
            'content_id' => $id, // with contentId generic naming for movie or series
            'user_id' => $user,
            'type' => $type
        ]);
        return response()->json(['success' => true]);
    }

     /**
     * Remove a movie or series from the authenticated user's favorites.
     *
     * @param string $id The ID of the movie or series.
     * @param string $type The type (either 'movie' or 'series').
     * @return JsonResponse JSON response confirming the removal.
     */

    public function delete(string $id, string $type): JsonResponse
    {
        $fav = Favorite::where('user_id', Auth::id())->where('type', $type)->where('content_id', $id)->first(); // getting favorite record by content ID and user
        // If the favorite is found, delete it.
        if ($fav) {
            $fav->delete();
        }
        $fav->delete();
        return response()->json(['success', true], 200);
    }
}
