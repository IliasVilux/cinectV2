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

        $responseTV = $client->request('GET', 'https://api.themoviedb.org/3/genre/tv/list?language=es', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                'Accept' => 'application/json',
            ],
        ]);
        $tvGenres = json_decode($responseTV->getBody())->{'genres'};
        foreach ($tvGenres as &$genre) {
            $genre->id = 's_' . $genre->id;
        }

        $responseMovies = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list?language=es', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                'Accept' => 'application/json',
            ],
        ]);
        $movieGenres = json_decode($responseMovies->getBody())->{'genres'};
        foreach ($movieGenres as &$genre) {
            $genre->id = 'f_' . $genre->id;
        }
        $allGenres = array_merge($tvGenres, $movieGenres);

        $responseAnime = $client->request('GET', 'https://api.jikan.moe/v4/genres/anime');
        $animeGenres = json_decode($responseAnime->getBody())->{'data'};
        $transformedAnimeGenres = array_map(function ($genre) {
            return (object) [
                'id' => $genre->mal_id,
                'name' => $genre->name,
            ];
        }, $animeGenres);
        foreach ($transformedAnimeGenres as &$genre) {
            $genre->id = 'a_' . $genre->id;
        }
        $allGenres = array_merge($allGenres, $transformedAnimeGenres);

        return $allGenres;
    }
}
