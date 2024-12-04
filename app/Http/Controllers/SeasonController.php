<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    private $tmdb_api_key;

    public function __construct()
    {
        $this->tmdb_api_key = env('TMDB_API_KEY');
    }

    public function store()
    { 
        $series = Serie::get();

        $allSeasons = array();

        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        foreach ($series as $serie)
        {
            for ($i = 1; $i <= $serie->number_of_seasons; $i++) {
                try {
                    $response = $client->request('GET', 'https://api.themoviedb.org/3/tv/' . $serie->id . '/season/' . $i . '?language=es-ES', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                            'Accept' => 'application/json',
                        ],
                    ]);
                    $season = json_decode($response->getBody());
                    $season->{'episodes'} = count($season->{'episodes'});
                    $season->{'serie_id'} = $serie->id;
    
                    $allSeasons[] = $season;
                } catch (RequestException $e) {
                    continue;
                }
            }
        }

        return $allSeasons;
    }
}
