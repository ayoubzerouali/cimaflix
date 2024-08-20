<?php

namespace App\Services;

class SerieService extends TMDBService
{
    /**
     * Call the tmdb api to fetch many movies/series .
     */
    public function all()
    {
        return $this->makeRequest('discover/movie');
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
        return $this->makeRequest('tv/' . $id . '/videos');
    }
}
