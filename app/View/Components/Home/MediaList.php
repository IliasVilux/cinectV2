<?php

namespace App\View\Components\Home;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MediaList extends Component
{
    public $title;
    public $items;
    public $mediaType;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $items, $mediaType)
    {
        $this->title = $title;
        $this->items = $items;
        $this->mediaType = $mediaType;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.media-list');
    }
}
