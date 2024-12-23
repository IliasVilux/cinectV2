<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = ['poster_path', 'name', 'overview', 'air_date', 'languages', 'number_of_episodes', 'number_of_seasons', 'top', 'genre_id'];

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }

    public function episodes(): HasManyThrough
    {
        return $this->hasManyThrough(Episode::class, Season::class);
    }

    public function favoriteLists(): MorphToMany
    {
        return $this->morphToMany(FavoriteList::class, 'content', 'favorite_list_content', 'content_id', 'favorite_list_id');
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'content');
    }
}
