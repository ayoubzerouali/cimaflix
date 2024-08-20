<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ApiCall;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    use ApiCall;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function trailer($serieId)
    {
        try {
            $trailer = $this->getTrailer('tv', $serieId);
            return $trailer;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch trailer', 'message' => $e->getMessage()], 500);
        }
    }
}
