<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\MovieService;
use Illuminate\Http\Request;



class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MovieService $movies)
    {
        return $movies->all();
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
        return $movieService->find($id); // Fetch details of a specific movie using the movie() method from the trait
    }
    /**/
    /* fetch top 5 best rated movies from tmdb */
    /**/
    public function topRated(Request $request, MovieService $movieService)
    {
        return $movieService->getTopRated($request->query());
    }

    public function trailer(string $movieId, MovieService $movieService)
    {
        // Fetch the trailer of a specific movie using tmdb api that is handled by the getTrailer function
        return $movieService->getTrailer($movieId);
    }
}
