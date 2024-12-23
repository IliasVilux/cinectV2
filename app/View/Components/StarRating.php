<?php

namespace App\View\Components;

use App\Models\Anime;
use App\Models\Film;
use App\Models\Rating;
use App\Models\Serie;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class StarRating extends Component
{
    public $rating;
    public $mediaId;
    public $mediaType;
    public $avgRating;

    /**
     * Create a new component instance.
     */
    public function __construct($mediaId, $mediaType)
    {
        $user = Auth::user();
        $rating = Rating::where('content_id', $mediaId)
                        ->where('user_id', $user->id)
                        ->first();
        $this->rating = $rating ? $rating->rating : 0;
        $this->mediaType = $mediaType;
        $this->avgRating = Rating::where('content_id', $mediaId)->avg('rating');

        switch ($mediaType)
        {
            case 'serie':
                $this->mediaId = Serie::find($mediaId);
                break;
            case 'película':
                $this->mediaId = Film::find($mediaId);
                break;
            case 'anime':
                $this->mediaId = Anime::find($mediaId);
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.star-rating', ['rating' => $this->rating, 'mediaId' => $this->mediaId, 'mediaType' => $this->mediaType, 'avgRating' => $this->avgRating]);
    }
}
