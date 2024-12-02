<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    private $tmdb_api_key;

    public function __construct()
    {
        $this->tmdb_api_key = env('TMDB_API_KEY');
    }

    public function store()
    {
        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        $response = $client->request('GET', 'https://api.themoviedb.org/3/genre/tv/list?language=es', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                'Accept' => 'application/json',
            ],
        ]);
        $responseGenres = json_decode($response->getBody())->{'genres'};
        
        return $responseGenres;
    }
}
