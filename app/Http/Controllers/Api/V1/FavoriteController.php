<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function addToFavorite($type)
    {
        return 'mockup';
    }
    public function removeFromFavorite($type) {}
    public function listAllFavorites() {}
    public function searchFavorites($query) {}
    public function details() {}
    public function trailer() {}
}
