<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Serie;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    private $tmdb_api_key;

    public function __construct()
    {
        $this->tmdb_api_key = env('TMDB_API_KEY');
    }

    public function storeSeries(Serie $serie)
    {
        $series = Serie::get();

        $allEpisodes = array();

        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        foreach ($serie->seasons as $index => $season) {
            $seasonNumber = $index + 1;
            if ($season->number_of_episodes >= 2)
            {
                for ($i = 1; $i <= 2; $i++) {
                    try {
                        $response = $client->request('GET', 'https://api.themoviedb.org/3/tv/' . $serie->id . '/season/' . $seasonNumber . '/episode/' . $i . '?language=es-ES', [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                                'Accept' => 'application/json',
                            ],
                        ]);
                        $episode = json_decode($response->getBody());
                        $episode->{'season_id'} = $season->id;

                        $allEpisodes[] = $episode;
                    } catch (RequestException $e) {
                        continue;
                    }
                }
            }
        }

        return $allEpisodes;
    }
}
