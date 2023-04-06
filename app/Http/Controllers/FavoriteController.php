<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtistFavorite;
use App\Models\AlbumFavorite;
use Auth;

class FavoriteController extends Controller
{
    //
    public function getFavorites()
    {
        return [
            'albums' => AlbumFavorite::where('created_by', Auth::id())->get(),
            'artists' => ArtistFavorite::where('created_by', Auth::id())->get(),
        ];
    }
}
