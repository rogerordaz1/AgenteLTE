<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CustomCard extends Component
{
    public $count;
    public $text;
    public $color;

    public $icon;



    public function __construct($count = 0, $text, $color ,$icon)
    {
        $this->count = $count;
        $this->text = $text;
        $this->color = $color;

        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.custom-card');
    }
}
