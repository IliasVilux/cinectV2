<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function setRating($mediaId, Request $request, $mediaType)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $rating = Rating::where('content_id', $mediaId)
                        ->where('user_id', $user->id)
                        ->first();

        if ($rating) {
            $rating->update(['rating' => $validated['rating']]);
        } else {
            Rating::create([
                'user_id' => $user->id,
                'content_id' => $mediaId,
                'rating' => $validated['rating']
            ]);
        }

        switch ($mediaType) {
            case 'serie':
                return redirect()->route('serie.detail', ['id' => $mediaId])
                                 ->with('success', "Se ha añadido tu puntuación.");
            case 'anime':
                return redirect()->route('anime.detail', ['id' => $mediaId])
                                 ->with('success', "Se ha añadido tu puntuación.");
            case 'película':
                return redirect()->route('film.detail', ['id' => $mediaId])
                                 ->with('success', "Se ha añadido tu puntuación.");
            default:
                return redirect()->route('home')->with('error', "Tipo de medio no válido.");
        }
    }
}
