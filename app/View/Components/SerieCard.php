<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SerieCard extends Component
{
    public $serie;

    /**
     * Create a new component instance.
     */
    public function __construct($serie)
    {
        $this->serie = $serie;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.serie-card');
    }
}
