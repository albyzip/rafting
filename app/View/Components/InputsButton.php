<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputsButton extends Component
{
    public $text;
    public $color;
    public $size;
    public $class;
    public $heading;
    public $headingName;
    public $padding;
    public $type;
    public $target;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($text, $color, $size, $class ='', $padding='', $heading ='', $headingName='', $type='button', $target='')
    {
        $this->text = $text;
        $this->color = $color;
        $this->size = $size;
        $this->class = $class;
        $this->padding = $padding;
        $this->heading = $heading;
        $this->headingName = $headingName;
        $this->type = $type;
        $this->target = $target;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.inputs-button');
    }
}
