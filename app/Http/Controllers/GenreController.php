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

        $responseMovies = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list?language=es', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                'Accept' => 'application/json',
            ],
        ]);
        $movieGenres = json_decode($responseMovies->getBody())->{'genres'};

        $existingGenres = array_column($tvGenres, 'name');
        $uniqueMovieGenres = array_filter($movieGenres, function ($genre) use ($existingGenres) {
            return !in_array($genre->name, $existingGenres);
        });
        $allGenres = array_merge($tvGenres, $uniqueMovieGenres);

        $responseAnime = $client->request('GET', 'https://api.jikan.moe/v4/genres/anime');
        $animeGenres = json_decode($responseAnime->getBody())->{'data'};

        $existingGenres = array_column($allGenres, 'name');
        $uniqueAnimeGenres = array_filter($animeGenres, function ($genre) use ($existingGenres) {
            return !in_array($genre->name, $existingGenres);
        });
        $allGenres = array_merge($allGenres, $uniqueAnimeGenres);

        return $allGenres;
    }
}
