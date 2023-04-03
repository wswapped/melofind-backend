<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    //Function that searches either an album or an artist

    public function searchAlbumArtist(Request $request)
    {
        $searchQuery = $request->input("searchQuery");

        $albumData = $this->searchAlbum($searchQuery);
        $artistData = $this->searchArtist($searchQuery);

        return [
            'albums' => $albumData,
            'artists' => $artistData,
        ];
    }

    private function searchAlbum(string $searchQuery){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ws.audioscrobbler.com/2.0/?method=album.search&album=' . urlencode($searchQuery) . '&api_key=' . env('LASTFM_API_KEY') . '&format=json',
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

    private function searchArtist(string $searchQuery){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://ws.audioscrobbler.com/2.0/?method=artist.search&artist=' . urlencode($searchQuery) . '&api_key=' . env('LASTFM_API_KEY') . '&format=json',
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
