<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class RowCardsCount extends Component
{
    public $countUser;
    public $roles;
    public function __construct()
    {
        $this->countUser = User::all()->count();
        $this->roles = Role::all()->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.row-cards-count');
    }
}
