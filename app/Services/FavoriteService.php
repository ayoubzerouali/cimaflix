<?php

namespace App\Services;

use App\Models\Favorite;
use App\Models\User;
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
    public function store(string $id, string $type): JsonResponse
    {
        $userId = Auth::id(); // Get the ID of the currently authenticated user

        // Check if the favorite already exists
        if ($this->hasFavorite($id, $type)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Favorite already exists.'
            ], 400); // Return a 400 Bad Request status code
        }

        // Create a new favorite record
        Favorite::createOrUpdate([
            'content_id' => $id, // Content ID (e.g., movie or series ID)
            'user_id' => $userId, // ID of the authenticated user
            'type' => $type // Type of the favorite (e.g., 'movie' or 'tv')
        ]);

        return response()->json(['success' => true]);
    }
    /**
     * a helper function to check the existance of a resource
     *
     * @param string $id The ID of the movie or series.
     * @param string $type The type (either 'movie' or 'series').
     * @return JsonResponse JSON response confirming the addition.
     */

    private function hasFavorite(string $id, string $type)
    {
        // Retrieve the ID of the currently authenticated user
        $userId = Auth::id();

        // Check if a record exists with the given content_id, type, and user_id
        return Favorite::where('content_id', $id)
            ->where('type', $type)
            ->where('user_id', $userId)
            ;
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
        $fav = $this->hasFavorite($id,$type)->first(); // getting favorite record by content ID and user
        // If the favorite is found, delete it.
        if ($fav) {
            $fav->delete();
        }
        $fav->delete();
        return response()->json(['success', true], 200);
    }
}
