<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Http\Resources\MovieResource;
use Illuminate\Http\JsonResponse;

class MovieService extends TMDBService
{
    /**
     * Fetch a paginated list of movies from the TMDB API.
     *
     * @return JsonResponse
     */
    public function all(): JsonResponse
    {
        try {
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10; // Number of items per page for our API response
            $apiPerPage = 20;  // Number of items per page from the TMDB API

            $apiPage = ceil(($currentPage * $perPage) / $apiPerPage); // Calculate page number for TMDB API request

            $response = collect($this->makeRequest('discover/movie', ['page' => $apiPage]));

            $movies = MovieResource::collection($response['results']);
            $total = $response['total_results'];

            // Slice the results to match the current page
            $currentPageMovies = $movies->slice(($currentPage - 1) * $perPage % $apiPerPage, $perPage)->values();

            //passing lengthaware needed params to build pagination arround our collection
            $paginatedMovies = new LengthAwarePaginator($currentPageMovies, $total, $perPage, $currentPage, [
                'path' => Paginator::resolveCurrentPath()
            ]);

            return response()->json([
                'success' => true,
                'page' => $response['page'],
                'data' => $paginatedMovies
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the API request
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching movies.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch a movie by its ID from the TMDB API.
     *
     * @param  string $id
     * @return MovieResource
     */
    public function find($id): MovieResource
    {
        try {
            return new MovieResource((object)$this->makeRequest('movie/' . $id));
        } catch (\Throwable $e) {
            throw $e;
            // Handle any exceptions that occur during the API request
        }
    }

    /**
     * Fetch the trailer for a movie by its ID from the TMDB API.
     *
     * @param  string $id
     * @return JsonResponse
     */
    public function getTrailer($id): JsonResponse
    {
        try {
            $response = $this->makeRequest('movie/' . $id . '/videos');
            return response()->json(['success' => true, 'data' => $response]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the API request
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the trailer.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Fetch top-rated movies from the TMDB API, limited to 5.
     *
     * @param  array $params
     * @return JsonResponse
     */
    public function getTopRated($params): JsonResponse
    {
        try {
            $response = collect($this->makeRequest('discover/movie', $params))->take(5);
            return response()->json(['success' => true, 'data' => $response]);
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the API request
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching top-rated movies.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
