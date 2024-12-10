<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Jorenvh\Share\ShareFacade;

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
                    $film->{'genre_ids'} = 'f_' .$film->{'genre_ids'}[0];
                } else {
                    $film->{'genre_ids'} = null;
                }

                $allFilms[] = $film;
            }

            $contador++;
        } while ($contador  <= 5);

        return $allFilms;
    }

    public function returnFilms(Request $request)
    {
        $query = Film::query();

        $orderBy = $request->get('order_by', null);
        $direction = 'asc';

        if (str_contains($orderBy, '_desc')) {
            $direction = 'desc';
            $orderBy = str_replace('_desc', '', $orderBy);
        } elseif (str_contains($orderBy, '_asc')) {
            $orderBy = str_replace('_asc', '', $orderBy);
        }


        $searchTerm = $request->get('search', null);
        if (!empty($searchTerm)) {
            $query->where('name', 'LIKE', '%' . $searchTerm . '%');
        }

        if ($orderBy) {
            $query->orderBy($orderBy, $direction);
        }

        $films = $query->get();

        return view('film.catalog', ['films' => $films]);
    }

    public function detail($id)
    {
        $film = Film::find($id);

        if (!$film) {
            abort(404, 'Película no encontrada');
        }

        $shareButtons = ShareFacade::page(url('film.detail', $id))
            ->whatsapp()
            ->twitter()
            ->facebook()
            ->getRawLinks();

        return view('film.detail', ['media' => $film, 'shareButtons' => $shareButtons]);
    }
}
