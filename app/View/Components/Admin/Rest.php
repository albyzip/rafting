<?php

namespace App\View\Components\Admin;

use App\Http\Controllers\RestController;
use Illuminate\View\Component;
use Illuminate\Http\Request;

class Rest extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function get($id)
    {
        $this->id = $id;

        return view('components.admin.rest', ['rest' => RestController::detail($this->id)]);

    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        // return view('components.admin.rest', ['rest' => RestController::detailDescription($this->id)]);
    }
}
