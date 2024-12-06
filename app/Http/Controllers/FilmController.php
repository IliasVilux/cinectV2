<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    private $tmdb_api_key;

    public function __construct()
    {
        $this->tmdb_api_key = env('TMDB_API_KEY');
    }

    public function store()
    {
        $contador = 1;
        $allFilms = array();

        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        do {
            $response = $client->request('GET', 'https://api.themoviedb.org/3/discover/movie', [
                'query' => [
                    'language' => 'es-ES',
                    'page' => $contador,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                    'Accept' => 'application/json',
                ],
            ]);
            $responseFilms = json_decode($response->getBody())->{'results'};

            foreach ($responseFilms as $film)
            {
                $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/' . $film->id . '?language=es-ES', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                        'Accept' => 'application/json',
                    ],
                ]);
                $responseDetail = json_decode($response->getBody());

                $film->{'runtime'} = $responseDetail->{'runtime'};

                if (isset($film->{'genre_ids'}) && !empty($film->{'genre_ids'})){
                    $film->{'genre_ids'} = $film->{'genre_ids'}[0];
                } else {
                    $film->{'genre_ids'} = null;
                }

                $allFilms[] = $film;
            }

            $contador++;
        } while ($contador  <= 5);

        return $allFilms;
    }
}
