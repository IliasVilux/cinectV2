<?php

namespace Database\Seeders;

use App\Http\Controllers\GenreController;
use App\Http\Controllers\SerieController;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $genreController = new GenreController();
        $genres = $genreController->store();
        foreach ($genres as $genre)
        {
            DB::table('genres')->insert([
                'id' => $genre->{'id'},
                'name' => $genre->{'name'}, 
            ]); 
        }

        $serieController = new SerieController();
        $series = $serieController->store();
        foreach ($series as $serie)
        {
            DB::table('series')->insert([
                'poster_path' => $serie->{'poster_path'},
                'name' => $serie->{'name'}, 
                'overview' => $serie->{'overview'},
                'genre_id' => $serie->{'genre_ids'},
                'air_date' => $serie->{'first_air_date'},
                // 'seasons' => $serie->{'season_number'},
                // 'total_episodes' => $serie->{'episode_count'},
                // 'puntuation' => $serie->{'vote_average'},
                'top' => false,
            ]); 
        }
    }
}
