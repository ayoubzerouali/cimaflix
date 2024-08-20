<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class MovieService extends TMDBService
{
    /**
     * Call the tmdb api to fetch many movies/series .
     */
    public function all()
    {
        $movies = collect($this->makeRequest('discover/movie'));

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10;
        $total = $movies['total_results'];
        $currentPageMovies = $movies->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedMovies = new LengthAwarePaginator($currentPageMovies, $total, $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);
        return response()->json([
            'success' => true,
            'data' => $paginatedMovies
        ]);
    }
    /**
     * Call the tmdb api to fetch movie/serie by id.
     */
    public  function find($id)
    {
        return $this->makeRequest('movie/' . $id);
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
