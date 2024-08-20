<?php

namespace App\Services;

use GuzzleHttp\Client;

class MovieService
{
    protected $headers;
    protected $base;
    protected $client;
    public function __construct()
    {
        $this->headers = [
            'headers' => [
                'Authorization' => 'Bearer ' . env('TMDB_KEY'),
                'accept' => 'application/json',
            ],
        ];

        $this->base = 'https://api.themoviedb.org/3/';
        $this->client = new Client();
    }
    /**
     * Call the tmdb api to fetch many movies/series .
     */
    public function allTmdb($type)
    {
        try {
            $response =  $this->client->request('GET', $this->base . 'discover/' . $type, $this->headers);
            return $response->getBody();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch' . $type . ' data', 'message' => $e->getMessage()]);
        }
    }
    /**
     * Call the tmdb api to fetch movie/serie by id.
     */
    public  function findTmdb($type, $id)
    {
        $client = new Client();
        $response =  $client->request('GET', $this->base . $type . '/' . $id, $this->headers);
        return $response->getBody();
    }

    /**
     * Call the tmdb api to fetch (movie/serie)'s trailer .
     */
    public function getTrailer($type, $id)
    {
        try {
            $response = $this->client->request('GET', $this->base . $type . '/' . $id . '/videos', $this->headers);
            return $response->getBody();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch trailer', 'message' => $e->getMessage()], 500);
        }
    }
}
