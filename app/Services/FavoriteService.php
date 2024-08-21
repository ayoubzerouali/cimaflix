<?php

namespace App\Services;

use App\Models\Favorite;
use Exception;
use Illuminate\Database\Eloquent\Builder;
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
    public function all(): JsonResponse|Exception
    {
        try {
            // Attempt to retrieve the paginated list of user's favorite movies
            $response = Favorite::where('user_id', Auth::id())->paginate(10);
            // Return a successful JSON response with the paginated data
            return response()->json([
                'success' => true,
                'data' => $response
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the query execution
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving favorites.',
                'error' => $e // Include the exception message for debugging
            ], 500); // Return a 500 Internal Server Error status code
        }
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

    private function hasFavorite(string $id, string $type): Favorite | Builder
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
        $fav = $this->hasFavorite($id, $type); // getting favorite record by content ID and user
        // If the favorite is found, delete it.
        if (!$fav->exists()) {
            return response()->json(['success' => false, 'message' => 'resource not found'], 404);
        }
        $fav->first()->delete();
        return response()->json(['success', true], 200);
    }
}
