<?php

namespace App\Services;

use GuzzleHttp\Client;

class TMDBService
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
    public function search($query, $perPage = 10, $currentPage = 1)
    {
        $response = $this->makeRequest('search/multi', [
            'query' => $query,
            'include_adult' => 'false',
            'language' => 'en-US',
            'page' => $currentPage
        ]);

        $results = $response->results;

        // Filter results
        $filteredResults = array_filter($results, function ($item) {
            return in_array($item->media_type, ['movie', 'tv']);
        });

        // Paginate results
        $total = $response->total_results;
        $currentPageResults = array_slice($filteredResults, ($currentPage - 1) * $perPage, $perPage);

        return [
            'data' => $currentPageResults,
            'total' => $total,
            'currentPage' => $currentPage,
            'perPage' => $perPage
        ];
    }
}
