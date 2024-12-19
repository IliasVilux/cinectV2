<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\FavoriteList;
use Error;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jorenvh\Share\ShareFacade;

class AnimeController extends Controller
{
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

    public function returnAnimes(Request $request)
    {
        $query = Anime::query();

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

        $animes = $query->get();

        return view('anime.catalog', ['animes' => $animes]);
    }

    public function detail($id)
    {
        $anime = Anime::find($id);

        if (!$anime) {
            abort(404, 'Anime no encontrado');
        }

        $shareButtons = ShareFacade::page(url('anime.detail', $id))
            ->whatsapp()
            ->twitter()
            ->facebook()
            ->getRawLinks();

        $user = Auth::user();
        $lists = FavoriteList::where('user_id', $user->id)
        ->whereDoesntHave('animes', function ($query) use ($id) {
            $query->where('content_id', $id)
                    ->where('content_type', Anime::class);
        })->get();

        return view('anime.detail', ['media' => $anime, 'shareButtons' => $shareButtons, 'lists' => $lists]);
    }

    public function storeToFavoriteList(Request $request, $animeId) {
        $user = Auth::user();
        $list = FavoriteList::where('id', $request->input('list_id'))->where('user_id', $user->id)->first();
        $anime = Anime::find($animeId);

        $list->animes()->attach($anime->id, ['content_type' => Anime::class]);
        $list->save();

        return redirect()->route('anime.detail',['id' => $animeId])->with('success', "Se ha añadido el anime {$anime->name} a la lista {$list->name}.");
    }
}
