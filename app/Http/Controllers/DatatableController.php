<?php

namespace App\Http\Controllers;

use App\Models\Agente;
use App\Models\Cliente;
use App\Models\Factura;
use Illuminate\Http\Request;
use Ramsey\Collection\Collection;

use Yajra\DataTables\Facades\DataTables;
class DatatableController extends Controller
{
    public function clientes()
    {

        return DataTables::of(Factura::all())

            ->toJson();
    }
    public function clientes_agente(Agente $agente)
    {;

        $facturas = collect();
        foreach ($agente->clientes as $key => $cliente) {

            $facturas->push($cliente->factura);
        }

         return DataTables::collection($facturas)->toJson();

           
    }


    public function agentes()
    {

        return DataTables::of(Agente::all())
            ->addColumn('show_clients', '<a href="{{route(\'dashboard.agentes.show\',$id)}}" type="button" class="btn btn-info btn-sm">' . ('Ver Clientes') . '</a>')
            ->rawColumns(['show_clients'])
            ->toJson();
    }
}


// {{route(\'dashboard.agentes.show\',$agente)}}