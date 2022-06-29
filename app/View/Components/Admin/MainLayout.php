<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class MainLayout extends Component
{
    public $content;
    public $view;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($view ='show', $content = 'RestController')
    {
        $this->view = $view;
        $this->content = $content;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.main-layout',['view' => $this->view, 'content' => $this->content]);
    }
}
