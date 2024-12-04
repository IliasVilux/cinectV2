<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Season extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'overview', 'number_of_episodes', 'serie_id'];

    public function serie(): BelongsTo
    {
        return $this->belongsTo(Serie::class);
    }
}
