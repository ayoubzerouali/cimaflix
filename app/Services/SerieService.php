<?php

namespace App\Services;

use App\Http\Resources\SerieResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class SerieService extends TMDBService
{
    /**
     * Fetch a paginated list of series from the TMDB API.
     *
     * @return \Illuminate\Http\JsonResponse JSON response with paginated series data.
     */
    public function all(): JsonResponse
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Get the current page number
        $perPage = 10; // Number of items per page for pagination
        $apiPerPage = 20; // Number of items per page returned by the TMDB API

        $apiPage = ceil(($currentPage * $perPage) / $apiPerPage); // Calculate the API page number

        $response = collect($this->makeRequest('discover/tv', ['page' => $apiPage])); // Fetch series data from TMDB API

        $series = SerieResource::collection($response['results']); // Transform series data using SerieResource
        $total = $response['total_results']; // Total number of series results

        $currentPageSeries = $series->slice(($currentPage - 1) * $perPage % $apiPerPage, $perPage)->values(); // Slice data for current page

        $paginatedSeries = new LengthAwarePaginator($currentPageSeries, $total, $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath() // Set the path for pagination links
        ]);

        return response()->json([
            'success' => true, // Indicate the request was successful
            'page' => $response['page'], // Current page number
            'data' => $paginatedSeries // Paginated series data
        ]);
    }

    /**
     * Fetch a single series by ID from the TMDB API.
     *
     * @param int $id Series ID.
     * @return SerieResource Transformed series data.
     */
    public function find($id): SerieResource
    {
        return new SerieResource($this->makeRequest('tv/' . $id)); // Return series data transformed by SerieResource
    }

    /**
     * Fetch top-rated series from the TMDB API.
     *
     * @param array $params Query parameters for fetching top-rated series.
     * @return \Illuminate\Http\JsonResponse JSON response with top-rated series data.
     */
    public function getTopRated($params): JsonResponse
    {
        // Fetch top-rated series and return the top 5
        return response()->json([
            'success' => true, // Indicate the request was successful
            'data' => collect($this->makeRequest('discover/tv', $params))->take(5) // Top 5 series
        ]);
    }

    /**
     * Fetch the trailer for a series by ID from the TMDB API.
     *
     * @param int $id Series ID.
     * @return object Trailer data from TMDB API.
     */
    public function getTrailer($id): JsonResponse
    {
        return $this->makeRequest('tv/' . $id . '/videos'); // Fetch trailer data for the series
    }
}
