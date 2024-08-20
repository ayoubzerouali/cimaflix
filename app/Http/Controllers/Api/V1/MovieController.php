<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
/* use App\Models\Movie; */
use App\Services\MovieService;

/* use App\Models\Movie; */
/* use Illuminate\Http\Request; */

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MovieService $movies)
    {
        return $movies->all('movie');
    }

    /**
     * Store a newly created resource in storage.
     */
    /* public function store(Request $request) */
    /* { */
    /*     $movie = Movie::create($request->all()); */
    /*     return response()->json(['data' => $movie, 'message' => 'success']); */
    /* } */

    /**
     * Display the specified resource.
     */
    public function show(string $id, MovieService $movieService)
    {
        // Fetch details of a specific movie using the movie() method from the trait
        return $movieService->find('movie', $id);
    }


    public function trailer(string $movieId, MovieService $movieService)
    {
        // Fetch details of a specific movie using the movie() method from the trait
        return $movieService->getTrailer($movieId);
    }
}
