<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Anime extends Model
{
    use HasFactory;

    protected $fillable = ['trailer_link', 'poster_path', 'name', 'overview', 'top', 'number_of_episodes', 'genre_id'];

    public function favoriteLists(): MorphToMany
    {
        return $this->morphToMany(FavoriteList::class, 'content', 'favorite_list_content', 'content_id', 'favorite_list_id');
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'content');
    }
}
