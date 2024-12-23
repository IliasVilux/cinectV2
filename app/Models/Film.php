<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Film extends Model
{
    use HasFactory;

    protected $fillable = ['poster_path', 'name', 'overview', 'top', 'release_date', 'genre_id'];

    public function favoriteLists(): MorphToMany
    {
        return $this->morphToMany(FavoriteList::class, 'content', 'favorite_list_content', 'content_id', 'favorite_list_id');
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'content');
    }
}
