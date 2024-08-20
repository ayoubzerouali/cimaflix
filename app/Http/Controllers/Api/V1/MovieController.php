<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Movie;
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
        return $movies->allTmdb('movie');
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
        return $movieService->findTmdb('movie', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    /* public function update(Request $request, string $id) */
    /* { */
    /*     // */
    /* } */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
