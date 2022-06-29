<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class Content extends Component
{
    public $content;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $path = 'App\\Http\\Controllers\\'.$this->content;
        $cont = new $path;
        return view('components.admin.content', ['cont' => $cont->showPreview()] );
    }
}
