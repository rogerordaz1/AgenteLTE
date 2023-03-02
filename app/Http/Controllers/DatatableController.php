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
        $facturas = Factura::with('cliente')->get();


        return DataTables::of($facturas)
            ->addColumn('oficina_nombre', function ($factura) {
                return $factura->cliente->ocomercial->nombre;
            })
            ->toJson();
    }

    public function agentes()
    {
        $agentes = Agente::with('ocomercial')->get();



        return DataTables::of($agentes)
            ->addColumn('oficina_nombre', function ($agente) {
                return $agente->ocomercial->nombre;
            })
            ->addColumn('created_at_diff', function ($agente) {
                return $agente->created_at->diffForHumans();
            })
            ->addColumn('updated_at_diff', function ($agente) {
                return $agente->updated_at->diffForHumans();
            })
            ->addColumn('show_clients', '<a href="{{route(\'dashboard.agentes.show\',$id)}}" type="button" class="btn btn-outline-primary btn-sm">' . ('Ver Clientes') . '</a>')
            ->rawColumns(['show_clients' , 'created_at_diff' , 'updated_at_diff' ])
            ->toJson();
    }
    public function clientes_agente(Agente $agente)
    {;

        $facturas = collect();
        foreach ($agente->clientes as $cliente) {
            $facturas->push($cliente->factura);
        }

        return DataTables::collection($facturas)
            ->addColumn('unlink_client', function ($facturas) {
                $url = route('dashboard.agentes.removeCliente', $facturas->cliente->id);
                return '
                    <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#confirm-delete-' . $facturas->cliente->id . '">' . __("Eliminar") . '</button>
                    <div class="modal fade" id="confirm-delete-' . $facturas->cliente->id . '" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-label-' . $facturas->cliente->id . '">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirm-delete-label-' . $facturas->cliente->id . '">' . __("Confirmar eliminación") . '</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="' . __("Cerrar") . '">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ' . __("¿Está seguro de que desea quitar al cliente seleccionado?") . '
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">' . __("Cancelar") . '</button>
                                    <form action="' . $url . '" method="POST">
                                        ' . csrf_field() . '
                                        ' . method_field('PUT') . '
                                        <button type="submit" class="btn btn-danger">' . __("Quitar") . '</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            })
            ->rawColumns(['unlink_client'])
            ->toJson();
    }
}


// {{route(\'dashboard.agentes.show\',$agente)}}
