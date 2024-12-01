<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SerieController extends Controller
{
    private $tmdb_api_key;

    public function __construct()
    {
        $this->tmdb_api_key = env('TMDB_API_KEY');
    }

    public function store()
    {
        $contador = 1;
        $allSeries = array();
        $genreMap = [
            10759 => 1,  // Action & Adventure -> Action
            16 => 17,    // Animation -> Animation
            35 => 3,     // Comedy -> Comedy
            80 => 18,    // Crime -> Crime
            99 => 2,     // Documentary -> Adventure
            18 => 4,     // Drama -> Drama
            10751 => 19, // Family -> Family
            10762 => 2,  // Kids -> Adventure
            9648 => 7,   // Mystery -> Mystery
            10763 => 10, // News -> Suspense
            10764 => 9,  // Reality -> Sci-Fi
            10765 => 9,  // Sci-Fi & Fantasy -> Sci-Fi
            10766 => 15, // Soap -> Shoujo
            10767 => 10, // Talk -> Suspense
            10768 => 21, // War & Politics -> War
            37 => 1     // Western -> Action
        ];

        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        do {
            $response = $client->request('GET', 'https://api.themoviedb.org/3/discover/tv', [
                'query' => [
                    'language' => 'en-US',
                    'page' => $contador,
                ],
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                    'Accept' => 'application/json',
                ],
            ]);

            $responseSeries = json_decode($response->getBody())->{'results'};

            foreach ($responseSeries as $serie)
            {
                if (isset($serie->{'genre_ids'}) && !empty($serie->{'genre_ids'})){
                    $firstGenreId = $serie->{'genre_ids'}[0];
                    if (array_key_exists($firstGenreId, $genreMap)) {
                        $serie->{'genre_ids'} = $genreMap[$firstGenreId];
                    } else {
                        $serie->{'genre_ids'} = null; 
                    }
                } else {
                    $serie->{'genre_ids'} = null;
                }
                $allSeries[] = $serie;
            }

            $contador++;
        } while ($contador  <= 5);

        return $allSeries;
    }

    public function index()
    {
        $series = DB::table('series')->get();
        return view('series-catalog', ['series' => $series]);
    }

    public function detail($id)
    {
        $serie = DB::table('series')->where('id', $id)->first();
        return view('detail', ['media' => $serie]);
    }
}
