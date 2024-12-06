<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $series = Serie::take(6)->get();
        $films = Film::take(6)->get();
        return view('home', ['series' => $series, 'films' => $films]);

    }

}
