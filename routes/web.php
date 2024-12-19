<?php

use App\Http\Controllers\AnimeController;
use App\Http\Controllers\FavoriteListController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SerieController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SERIES
    Route::get('/series', [SerieController::class, 'returnSeries'])->name('serie.catalog');
    Route::get('/serie/{id}', [SerieController::class, 'detail'])->name('serie.detail');
    Route::post('/serie/{id}', [SerieController::class, 'storeToFavoriteList'])->name('serie.store.favoriteList');
    
    // FILMS
    Route::get('/películas', [FilmController::class, 'returnFilms'])->name('film.catalog');
    Route::get('/película/{id}', [FilmController::class, 'detail'])->name('film.detail');
    Route::post('/película/{id}', [FilmController::class, 'storeToFavoriteList'])->name('film.store.favoriteList');

    // ANIMES
    Route::get('/animes', [AnimeController::class, 'returnAnimes'])->name('anime.catalog');
    Route::get('/anime/{id}', [AnimeController::class, 'detail'])->name('anime.detail');

    // FAVORITES LISTS
    Route::get('/listas', [FavoriteListController::class, 'returnFavoritesLists'])->name('favoriteLists');
    Route::post('/listas', [FavoriteListController::class, 'store'])->name('favoriteLists.store');
});

require __DIR__.'/auth.php';
