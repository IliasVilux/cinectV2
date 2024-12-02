<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = ['poster_path', 'name', 'overview', 'air_date', 'top', 'genre_id'];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
