<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    public function series(): HasMany
    {
        return $this->hasMany(Serie::class);
    }

    public function films(): HasMany
    {
        return $this->hasMany(Film::class);
    }

    public function animes(): HasMany
    {
        return $this->hasMany(Anime::class);
    }
}
