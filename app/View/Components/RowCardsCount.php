<?php

namespace App\View\Components;

use App\Models\Agente;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Ocomerciale;
use App\Models\User;
use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class RowCardsCount extends Component
{
    public $countUser;
    public $roles;
    public $clientes;
    public $agentes;
    public $ocomerciales;
    public $facturas;

    public function __construct()
    {
        $this->countUser = User::all()->count();
        $this->roles = Role::all()->count();
        $this->clientes = Cliente::all()->count();
        $this->agentes = Agente::all()->count();
        $this->ocomerciales = Ocomerciale::all()->count();
        $this->facturas = Factura::all()->count();
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
