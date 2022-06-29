<?php

namespace App\View\Components;

use Illuminate\View\Component;

class StoriesItem extends Component
{
    public $caption;
    public $imgSrc;
    public $galId;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($caption, $imgSrc, $galId)
    {
        $this->caption = $caption;
        $this->imgSrc = $imgSrc;
        $this->galId = $galId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.stories-item');
    }
}
