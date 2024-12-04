<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = ['poster_path', 'name', 'overview', 'air_date', 'languages', 'number_of_episodes', 'number_of_seasons', 'top', 'genre_id'];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }
}
