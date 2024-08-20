<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\TMDBService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $tmdbService;
    public function __construct(TMDBService $tmdb)
    {
        $this->tmdbService = $tmdb;
    }
    public function search(Request $request)
    {
        $query = $request->query('query');
        $perPage = $request->query('perPage', 10);
        $currentPage = $request->query('page', 1);

        $results = $this->tmdbService->search($query, $perPage, $currentPage);

        return response()->json([
            'success' => true,
            'data' => $results['data'],
            'total' => $results['total'],
            'currentPage' => $results['currentPage'],
            'perPage' => $results['perPage']
        ]);
    }
}
