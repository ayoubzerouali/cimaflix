<?php

namespace App\Services;

use GuzzleHttp\Client;

abstract class TMDBService
{
    protected $client;
    protected $base;
    protected $headers;

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

    protected function makeRequest(string $endpoint, $params = [])
    {
        try {
            $url = $this->base . $endpoint;

            $response = $this->client->request('GET', $url, $this->headers);

            return response()->json((json_decode($response->getBody())));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
