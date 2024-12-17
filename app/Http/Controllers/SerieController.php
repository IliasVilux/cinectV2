<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FavoriteList;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jorenvh\Share\ShareFacade;

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

        $client = new \GuzzleHttp\Client([
            'verify' => false,
        ]);
        do {
            $response = $client->request('GET', 'https://api.themoviedb.org/3/discover/tv', [
                'query' => [
                    'language' => 'es-ES',
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
                $response = $client->request('GET', 'https://api.themoviedb.org/3/tv/' . $serie->id . '?language=es-ES', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->tmdb_api_key,
                        'Accept' => 'application/json',
                    ],
                ]);
                $responseDetail = json_decode($response->getBody());
                
                $serie->{'languages'} = implode(',', $responseDetail->{'languages'});
                $serie->{'number_of_episodes'} = $responseDetail->{'number_of_episodes'};
                $serie->{'number_of_seasons'} = $responseDetail->{'number_of_seasons'};
                
                if (isset($serie->{'genre_ids'}) && !empty($serie->{'genre_ids'})){
                    $serie->{'genre_ids'} = 's_' . $serie->{'genre_ids'}[0];
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
        $serie = Serie::find($id);

        if (!$serie) {
            abort(404, 'Serie no encontrada');
        }

        $shareButtons = ShareFacade::page(url('serie.detail', $id))
            ->whatsapp()
            ->twitter()
            ->facebook()
            ->getRawLinks();

        $user = Auth::user();
        $lists = FavoriteList::where('user_id', $user->id)
        ->whereDoesntHave('contents', function ($query) use ($id) {
            $query->where('content_id', $id)
                ->where('content_type', Serie::class);
        })->get();

        return view('serie.detail', ['media' => $serie, 'shareButtons' => $shareButtons, 'lists' => $lists]);
    }

    public function storeToFavoriteList(Request $request, $serieId) {
        $user = Auth::user();
        $list = FavoriteList::where('id', $request->input('list_id'))->where('user_id', $user->id)->first();
        $serie = Serie::find($serieId);

        $list->contents()->attach($serie->id, ['content_type' => Serie::class]);
        $list->save();

        return redirect()->route('serie.detail',['id' => $serieId])->with('success', 'Lista creada con éxito.');
    }
}
