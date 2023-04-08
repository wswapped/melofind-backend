<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('album_favorite', AlbumController::class)->except('update');
    Route::apiResource('artist_favorite', ArtistController::class)->except('update');
    Route::get('artist/track_albums', [ArtistController::class, 'getTracskAndAlbums']);
    Route::post('artist_favorite/check', [ArtistController::class, 'checkFavorite']);
    Route::get('favorites', [FavoriteController::class, 'getFavorites']);
});




Route::get("search", [SearchController::class, 'searchAlbumArtist']);
Route::get("album_get", [AlbumController::class, 'getAlbum']);
Route::get("artist_get", [ArtistController::class, 'getArtist']);

Route::prefix('auth')->group(function(){
    Route::get('redirect', [AuthController::class, 'googleOathRedirect']);
    Route::get('callback', [AuthController::class, 'googleOathCallback']);
});