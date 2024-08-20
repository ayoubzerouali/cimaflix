<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use App\Http\Resources\MovieResource;

class MovieService extends TMDBService
{
    /**
     * Call the tmdb api to fetch many movies/movies .
     */
    public function all()
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10; // NUmber of items per page returned by our API
        $apiPerPage = 20;  // Number of items per page returned by the API

        $apiPage = ceil(($currentPage * $perPage) / $apiPerPage);


        $response = collect($this->makeRequest('discover/movie', ['page' => $apiPage]));

        $movies = MovieResource::collection($response['results']);
        $total = $response['total_results'];

        // Even page: Take items from the start of the page
        $currentPageMovies = $movies->slice(($currentPage - 1) * $perPage % $apiPerPage, $perPage)->values();

        $paginatedMovies = new LengthAwarePaginator($currentPageMovies, $total, $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);

        return response()->json([
            'success' => true,
            'page' => $response['page'],
            'data' => $paginatedMovies
        ]);
    }
    /**
     * Call the tmdb api to fetch movie/serie by id.
     */
    public  function find($id)
    {
        return new MovieResource((object)$this->makeRequest('movie/' . $id));
    }

    /**
     * Call the tmdb api to fetch (movie/serie)'s trailer .
     */
    public function getTrailer($id)
    {
        return $this->makeRequest('movie/' . $id . '/videos');
    }
    /**
     * Call the tmdb api to fetch 5 top movies ranked by popularity.
     */
    public function getTopRated($params)
    {
        return response()->json(['success' => true, 'data' => collect($this->makeRequest('discover/movie', $params))->take(5)]);
    }
}
