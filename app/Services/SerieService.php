<?php

namespace App\Services;

use App\Http\Resources\SerieResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class SerieService extends TMDBService
{
    /**
     * Call the tmdb api to fetch many series/series .
     */

     public function all()
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10; // NUmber of items per page returned by our API
        $apiPerPage = 20;  // Number of items per page returned by the API

        $apiPage = ceil(($currentPage * $perPage) / $apiPerPage);


        $response = collect($this->makeRequest('discover/movie', ['page' => $apiPage]));

        $series = SerieResource::collection($response['results']);
        $total = $response['total_results'];
        /* $totalPages = ceil($total / $perPage); */

        $currentPageSeries = 0;
        if ($currentPage % 2 == 0) {
            // Even page: Take items from the start of the page
            $currentPageSeries = $series->slice(($currentPage - 1) * $perPage % $apiPerPage, $perPage)->values();
        } else {
            // Odd page: Take items from the middle of the page
            $currentPageSeries = $series->slice((($currentPage - 1) * $perPage % $apiPerPage) + $perPage, $perPage)->values();
        }
        /* $currentPageSeries = $series->slice(($currentPage - 1) * $perPage, $perPage); */
        $paginatedSeries = new LengthAwarePaginator($currentPageSeries, $total, $perPage, $currentPage, [
            'path' => Paginator::resolveCurrentPath()
        ]);
        return response()->json([
            'success' => true,
            'page' => $response['page'],
            'data' => $paginatedSeries
        ]);
    }
    /**
     * Call the tmdb api to fetch movie/serie by id.
     */
    public  function find($id)
    {
        return new SerieResource($this->makeRequest('tv/' . $id));
    }

    /**
     * Call the tmdb api to fetch 5 top series ranked by popularity.
     */
    public function getTopRated($params)
    {
        /* return $this->makeRequest('discover/tv', $params); */

        return response()->json(['success' => true, 'data' => collect($this->makeRequest('discover/tv', $params))->take(5)]);
    }
    /**
     * Call the tmdb api to fetch series trailer .
     */
    public function getTrailer($id)
    {
        return $this->makeRequest('tv/' . $id . '/videos');
    }
}
