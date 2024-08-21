<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Services\TMDBService;
use ErrorException;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $tmdbService;
    /**
     * Create a new controller instance to use the search function on the tmdb service which is responsible for making api calls.
     *
     * @param  \App\Services\TMDBService  $tmdb
     * @return void
     */
    public function __construct(TMDBService $tmdb)
    {
        $this->tmdbService = $tmdb;
    }
    /**
     * Handle the search for movies/series request .
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Retrieve search query parameter from the request
        $query = $request->query('query');

        // Retrieve perPage parameter from the request, default to 10 if not provided
        $perPage = $request->query('perPage', 10);

        // Retrieve currentPage parameter from the request, default to 1 if not provided
        $currentPage = $request->query('page', 1);

        // Call the search method of TMDBService and get the results
        $results = $this->tmdbService->search($query, $perPage, $currentPage);

        /* if (!$results) { */
        /*     return response()->json(['success' => false]); */
        /* } */
        // Return the search results as a JSON response
        return response()->json([
            'success' => true, // Indicate that the request was successful
            'data' => $results['data'], // Current page results
            'total' => $results['total'], // Total number of results
            'currentPage' => $results['currentPage'], // Current page number
            'perPage' => $results['perPage'] // Number of results per page
        ], 200);
    }
}
