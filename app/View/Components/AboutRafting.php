<?php

namespace App\View\Components;

use App\Http\Controllers\SiteOptionsController;
use Illuminate\View\Component;

class AboutRafting extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.about-rafting', ['options' => SiteOptionsController::show('section_2')]);
    }
}
