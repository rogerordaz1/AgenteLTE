<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class CountCard extends Component
{
   
    public $count;
    public $text;
    public $color;
    public $link;



    public function __construct($count = 0,$text,$color, $link)
    {
        $this->count = $count;
        $this->text = $text;
        $this->color = $color;
        $this->link = $link;
        
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.count-card');
    }
}
