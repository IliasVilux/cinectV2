<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $series = DB::table('series')->take(6)->get();
        return view('home', ['series' => $series]);

    }

}
