<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Anime;
use App\Models\FavoriteList;
use App\Models\Film;
use App\Models\Serie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteListController extends Controller
{
    public function returnFavoritesLists()
    {
        $user = Auth::user();
        $lists = FavoriteList::where('user_id', $user->id)->get();
        foreach ($lists as $list) {
            $series = $list->morphedByMany(Serie::class, 'content', 'favorite_list_content')->get();
            $films = $list->morphedByMany(Film::class, 'content', 'favorite_list_content')->get();
            $animes = $list->morphedByMany(Anime::class, 'content', 'favorite_list_content')->get();
    
            $list->allContents = $films->merge($series)->merge($animes);
        }

        return view('favoriteLists', ['lists' => $lists]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $list = new FavoriteList;
        $list->name = $request->input('name');
        $list->user_id = $user->id;
        $list->save();

        return redirect()->route('favoriteLists')->with('success', 'Lista creada con éxito.');
    }
}
