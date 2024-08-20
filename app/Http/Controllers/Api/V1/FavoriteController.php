<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index()
    {

        $favs = Favorite::where('user_id', Auth::id())->get();
        return response()->json(['success' => true, 'data' => $favs], 200);
    }

    public function store($movieId)
    {
        $user = Auth::id();
        Favorite::create([
            'movie_id' => $movieId,
            'user_id' => $user
        ]);
        return response()->json(['success' => true], 201);
    }
    public function destroy($movieId)
    {
        $fav = Favorite::where('user_id', Auth::id())->where('movie_id', $movieId)->first();
        $fav->delete();
        return response()->json(['success', true], 200);
    }

    public function details() {}
}
