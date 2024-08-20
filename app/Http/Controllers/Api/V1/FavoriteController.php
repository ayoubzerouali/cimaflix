<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = Auth::id();

        dd($user);
        return response()->json(['success' => true, 'data' => $user->favorites], 200);
    }

    public function store($movieId)
    {
        $user = Auth::id();
        Favorite::create([
            'movie_id' => $movieId,
            'user_id' => $user
        ]);
        return response()->json(['success' => true], 200);
    }
    public function removeFromFavorite($type) {}
    public function listAllFavorites() {}
    public function searchFavorites($query) {}
    public function details() {}
}
