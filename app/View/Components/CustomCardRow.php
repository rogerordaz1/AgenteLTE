<?php

namespace App\View\Components;

use App\Models\User;
use App\Models\Agente;
use App\Models\Cliente;
use App\Models\Factura;
use App\Models\Ocomerciale;
use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class CustomCardRow extends Component
{
    public $countUser;
    public $roles;
    public $clientes;
    public $agentes;
    public $ocomerciales;
    public $facturas;
    public $totalFactutas;
    public $totalAtraso;

    public function __construct()
    {
        $this->countUser = User::all()->count();
        $this->roles = Role::all()->count();
        $this->clientes = Cliente::all()->count();
        $this->agentes = Agente::all()->count();
        $this->ocomerciales = Ocomerciale::all()->count();
        $this->facturas = Factura::all()->count();
        $this->totalFactutas = Factura::sum('total');
        $this->totalAtraso = Factura::sum('atraso');
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.custom-card-row');
    }
}
