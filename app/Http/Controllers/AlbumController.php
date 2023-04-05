<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlbumFavorite;
use App\Models\User;
use Auth;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getAlbum(Request $request)
    {
        $name = urlencode($request->input("name"));
        $artist = urlencode($request->input("artist"));
        $mbid = $request->input("mbid");

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ws.audioscrobbler.com/2.0/?method=album.getInfo&album=' . $name . '&artist=' .  $artist .'&mbid='. $mbid . '&api_key=' . env('LASTFM_API_KEY') . '&format=json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Store album favorite

        // Verify if this album is not already saved
        $checkFavorite = AlbumFavorite::where([
            'created_by' => Auth::id(),
            'mbid' => $request->input('mbid'),
            'name' => $request->input('name'),
            'artist' => $request->input('artist'),
        ])->count();

        if(!$checkFavorite){
            $album = $request->except('created_by');
            $album['created_by'] = Auth::id();
            $favorite = AlbumFavorite::create($album);
            return response([
                'message' => 'Album favorited',
                'favorite_id'  => $favorite->id,
            ]);
        }else{
            return response([
                'message' => 'Album is already your favorite'
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
