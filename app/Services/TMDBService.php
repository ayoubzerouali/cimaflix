<?php

namespace App\Services;

use GuzzleHttp\Client;
use Throwable;

class TMDBService
{
    // used this method for templating pattern to reduce code duplication , wouldve used strategy but its overkill
    protected $client;
    protected $base;
    protected $headers;

    /**
     * TMDBService constructor initializes the HTTP client and sets up headers.
     */
    public function __construct()
    {
        $this->headers = [
            'Authorization' => 'Bearer ' . env('TMDB_KEY'), // API key for authorization
            'accept' => 'application/json', // Accept JSON response
        ];
        $this->base = 'https://api.themoviedb.org/3/'; // Base URL for TMDB API
        $this->client = new Client(); // Create a new Guzzle client
    }

    /**
     * make a request to the TMDB API.
     *
     * @param string $endpoint API endpoint
     * @param array $params Query parameters
     * @return object API response
     * @throws \App\Exceptions\ApiException
     */
    protected function makeRequest(string $endpoint, $params = [])
    {
        $options = [
            'headers' => $this->headers, // set headers
            'query' => $params, // add query parameters
        ];

        try {
            $url = $this->base . $endpoint; // full URL for the request
            $response = $this->client->request('GET', $url, $options); // make the GET request
            return json_decode($response->getBody()); // return JSON response as object
        } catch (\Throwable $e) {
            throw new \App\Exceptions\ApiException('Error occurred during API request', 0, $e); // handle exceptions
        }
    }

    /**
     * search movies and series using TMDB API.
     *
     * @param string $query Search query
     * @param int $perPage Number of results per page
     * @param int $currentPage Current page number
     * @return array Paginated search results
     */
    public function search($query, $perPage = 10, $currentPage = 1)
    {
        try {
            // Make API request to search for movies and TV series
            $response = $this->makeRequest('search/multi', [
                'query' => $query, // search query
                'include_adult' => 'false', // exclude adult content
                'language' => 'en-US', // language of the results
                'page' => $currentPage // page number for pagination
            ]);

            $results = $response->results; // get search results

            // Filter results to include only movies and TV series
            $filteredResults = array_filter($results, function ($item) {
                return in_array($item->media_type, ['movie', 'tv']); // return only movies and TV series
            });

            // Paginate results
            $total = $response->total_results; // total number of results
            $currentPageResults = array_slice($filteredResults, ($currentPage - 1) * $perPage, $perPage); // slice results for current page
            return [
                'data' => $currentPageResults, // current page results
                'total' => $total, // total number of results
                'currentPage' => $currentPage, // current page number
                'perPage' => $perPage // number of results per page
            ];
        } catch (\Throwable $e) {
            // Handle any kind of throwable (exceptions and errors)
            report($e);
            return false;
        }
    }
}
