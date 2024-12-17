<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class FavoriteList extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function films(): MorphToMany
    {
        return $this->morphedByMany(Film::class, 'content', 'favorite_list_content');
    }

    public function series(): MorphToMany
    {
        return $this->morphedByMany(Serie::class, 'content', 'favorite_list_content');
    }

    public function animes(): MorphToMany
    {
        return $this->morphedByMany(Anime::class, 'content', 'favorite_list_content');
    }
}
