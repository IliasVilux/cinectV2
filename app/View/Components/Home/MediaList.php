<?php

namespace App\View\Components\Home;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MediaList extends Component
{
    public $title;
    public $items;

    /**
     * Create a new component instance.
     */
    public function __construct($title, $items)
    {
        $this->title = $title;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home.media-list');
    }
}
