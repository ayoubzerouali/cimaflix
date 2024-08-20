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
            'Authorization' => 'Bearer ' . env('TMDB_KEY'),
            'accept' => 'application/json',
        ];
        $this->base = 'https://api.themoviedb.org/3/';
        $this->client = new Client();
    }

    protected function makeRequest(string $endpoint, $params = [])
    {
        $options = [
            'headers' => $this->headers, // headers added to the url
            'query' => $params, // Add query parameters for specifiactions
        ];

        /* try { */
        $url = $this->base . $endpoint;
        $response = $this->client->request('GET', $url, $options);
        return json_decode($response->getBody());
        /* } catch (\Exception $e) { */
        /*     throw  new \App\Exceptions\ApiException('Error occurred during API request', 0, $e);; */
        /* } */
    }
}
