<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anime extends Model
{
    use HasFactory;

    protected $fillable = ['trailer_link', 'poster_path', 'name', 'overview', 'top', 'number_of_episodes', 'genre_id'];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }
}
