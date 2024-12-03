<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Serie;
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
        $genres = DB::table('genres')->get();
        $genreMap = [];

        foreach ($genres as $genre) {
            $genreMap[$genre->id] = $genre->id; // Mapeo directo de IDs
        }

        $contador = 1;
        $allSeries = array();

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
                    $serie->{'genre_ids'} = $serie->{'genre_ids'}[0];
                } else {
                    $serie->{'genre_ids'} = null;
                }
                $allSeries[] = $serie;
            }

            $contador++;
        } while ($contador  <= 5);

        return $allSeries;
    }

    public function returnSeries(Request $request)
    {
        $query = Serie::query();

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

        $series = $query->get();

        return view('serie.catalog', ['series' => $series]);
    }

    public function detail($id)
    {
        $serie = Serie::with('genre')->find($id);

        if (!$serie) {
            abort(404, 'Serie no encontrada');
        }

        return view('serie.detail', ['media' => $serie]);
    }
}
