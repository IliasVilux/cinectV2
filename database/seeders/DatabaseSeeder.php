<?php

namespace Database\Seeders;

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\SerieController;
use App\Models\Serie;
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
            DB::table('series')->insertOrIgnore([
                'id' => $serie->{'id'},
                'poster_path' => $serie->{'poster_path'},
                'name' => $serie->{'name'}, 
                'overview' => $serie->{'overview'},
                'genre_id' => $serie->{'genre_ids'},
                'languages' => $serie->{'languages'},
                'number_of_episodes' => $serie->{'number_of_episodes'},
                'number_of_seasons' => $serie->{'number_of_seasons'},
                'top' => false,
            ]); 
        }

        $filmController = new FilmController();
        $films = $filmController->store();
        foreach ($films as $film)
        {
            DB::table('films')->insertOrIgnore([
                'id' => $film->{'id'},
                'poster_path' => $film->{'poster_path'},
                'name' => $film->{'title'}, 
                'overview' => $film->{'overview'},
                'genre_id' => $film->{'genre_ids'},
                'release_date' => $film->{'release_date'},
            ]); 
        }

        $seasonController = new SeasonController();
        $seasons = $seasonController->store();
        foreach ($seasons as $season)
        {
            DB::table('seasons')->insert([
                'id' => $season->{'id'},
                'name' => $season->{'name'},
                'overview' => $season->{'overview'},
                'number_of_episodes' => $season->{'episodes'},
                'serie_id' => $season->{'serie_id'},
            ]);
        }

        $episodesSeriesController = new EpisodeController();
        $series = Serie::get();

        foreach ($series as $serie)
        {
            $episodesSerie = $episodesSeriesController->storeSeries($serie);
            foreach ($episodesSerie as $episode)
            {
                DB::table('episodes')->insert([
                    'id' => $episode->{'id'},
                    'poster_path' => $episode->{'still_path'},
                    'name' => $episode->{'name'},
                    'overview' => $episode->{'overview'},
                    'runtime' => $episode->{'runtime'},
                    'episode_number' => $episode->{'episode_number'},
                    'season_number' => $episode->{'season_number'},
                    'season_id' => $episode->{'season_id'},
                ]);
            }
        }

        $animeController = new AnimeController;
        $animes = $animeController->store();

        foreach ($animes as $anime)
        {
            DB::table('animes')->insert([
                'trailer_link' => $anime->{'trailer'},
                'release_year' => $anime->{'year'},
                'poster_path' => $anime->{'images'},
                'name' => $anime->{'title'},
                'overview' => $anime->{'synopsis'},
                'number_of_episodes' => $anime->{'episodes'},
                'runtime' => $anime->{'duration'},
                'genre_id' => $anime->{'genres'},
            ]);
        }
    }
}
