<?php

namespace App\Services;

class SerieService extends TMDBService
{
    /**
     * Call the tmdb api to fetch many movies/series .
     */
    public function all()
    {
        return $this->makeRequest('discover/tv');
    }
    /**
     * Call the tmdb api to fetch movie/serie by id.
     */
    public  function find($id)
    {
        return $this->makeRequest('tv/' . $id);
    }

    /**
     * Call the tmdb api to fetch 5 top movies ranked by popularity.
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
