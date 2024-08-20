<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\SerieService;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SerieService $serieService)
    {
        return $serieService->all();
    }

    /**
     * Display the specified resource.
     */
    public function show(SerieService $serieService, string $id)
    {

        return $serieService->find($id);
    }

    public function topRated(Request $request, SerieService $serieService)
    {
        return $serieService->getTopRated($request->query());
    }
    public function trailer(SerieService $serieService, $serieId)
    {
        return $serieService->getTrailer($serieId);
    }
}
