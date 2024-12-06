<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MediaCard extends Component
{
    public $media;
    public $mediaType;

    /**
     * Create a new component instance.
     */
    public function __construct($media, $mediaType)
    {
        $this->media = $media;
        $this->mediaType = $mediaType;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.media-card');
    }
}
