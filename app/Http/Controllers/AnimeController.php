<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Error;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    private $tmdb_api_key;

    public function __construct()
    {
        $this->tmdb_api_key = env('TMDB_API_KEY');
    }

    public function store()
    {
        set_time_limit(300);

        $contador = 1;
        $allAnimes = array();

        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        do{
            try
            {
                $response = $client->get('https://api.jikan.moe/v4/anime/' . $contador . '/full');
                $responseDetail = json_decode($response->getBody())->{'data'};
                
                $responseDetail->{'trailer'} = $responseDetail->{'trailer'}->{'url'};
                $responseDetail->{'images'} = $responseDetail->{'images'}->{'webp'}->{'image_url'};
                if (isset($responseDetail->{'genres'}) && !empty($responseDetail->{'genres'})){
                    $responseDetail->{'genres'} = 'a_' . $responseDetail->{'genres'}[0]->{'mal_id'};
                } else {
                    $responseDetail->{'genres'} = null;
                }

                $allAnimes[] = $responseDetail;
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    $statusCode = $e->getResponse()->getStatusCode();

                    if ($statusCode == 429) {
                        sleep(1);
                        continue;
                    } elseif ($statusCode == 404) {
                        $contador++;
                        continue;
                    }
                } else {
                    continue;
                }
            }

            if ($contador % 3 == 0) {
                sleep(1);
            }

            $contador++;
        } while ($contador <= 100);

        return $allAnimes;
    }
}
