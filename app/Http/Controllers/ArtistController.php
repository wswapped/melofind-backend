<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArtistFavorite;
use App\Models\User;
use Auth;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getArtist(Request $request)
    {
        $artist = urlencode($request->input("artist"));
        $mbid = $request->input("mbid");

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ws.audioscrobbler.com/2.0/?method=artist.getInfo&artist=' .  $artist .'&mbid='. $mbid . '&api_key=' . env('LASTFM_API_KEY') . '&format=json',
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

    public function getTracskAndAlbums(Request $request)
    {
        $artist = $request->input("artist");
        $mbid = $request->input("mbid");

        $topTracks = $this->sendLastFmRequest('artist.getTopTracks', [
            'artist' => $artist,
            'mbid' => $mbid,
        ]);

        $topAlbums = $this->sendLastFmRequest('artist.getTopAlbums', [
            'artist' => $artist,
            'mbid' => $mbid,
        ]);
        return [
            'tracks' => $topTracks,
            'albums' => $topAlbums,
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Store favorite artist

        // Verify if this artist is not already saved
        $checkFavorite = ArtistFavorite::where([
            'created_by' => Auth::id(),
            'mbid' => $request->input('mbid'),
            'name' => $request->input('name'),
        ])->count();

        if(!$checkFavorite){
            $artist = $request->except('created_by');
            $artist['created_by'] = Auth::id();
            $favorite = ArtistFavorite::create($artist);
            return response([
                'message' => 'Artist added to favorites',
                'id'  => $favorite->id,
            ]);
        }else{
            return response([
                'message' => 'Artist is already your favorite'
            ], 400);
        }
    }

    public function checkFavorite(Request $request)
    {
        // Checks if an artist is favorite
        $checkFavorite = ArtistFavorite::where([
            'created_by' => Auth::id(),
            'mbid' => $request->input('mbid'),
            'name' => $request->input('name'),
        ])->first();

        $favorite = false;
        if($checkFavorite){
            $favorite = true;
        }
        return [
            'favorite' => $favorite,
            'id' => $checkFavorite->id??false,
        ];
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
    public function destroy($id, Request $request)
    {
        // Checks if an artist is favorite before
        $checkFavorite = ArtistFavorite::find($id);

        if($checkFavorite){
            $checkFavorite->delete();
            return response(['message' => 'Artist removed from your favorites']);
        }else{
            return response(['message' => 'Artist is not your favorite'], 400);
        }
    }

    private function sendLastFmRequest(string $method, array $params)
    {
        $queryParams = http_build_query($params);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ws.audioscrobbler.com/2.0/?method=' . $method . '&' .  $queryParams . '&api_key=' . env('LASTFM_API_KEY') . '&format=json',
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
}
