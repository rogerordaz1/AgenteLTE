<?php

namespace App\Http\Controllers;

use App\Models\Agente;
use App\Models\Cliente;
use App\Models\Ocomerciale;
use Illuminate\Http\Request;

class AgenteController extends Controller
{

    public function index()
    {
        $ocomerciales = Ocomerciale::all();
        // $ocomercialesNombres = $ocomerciales->sortBy('nombre')->pluck('nombre')->unique();
        return view('agentes.index', [
            'ocomerciales' => $ocomerciales
        ]);
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        $agente = Agente::find($id);
        return view(
            'agentes.show_clientes',
            [
                'agente' => $agente,
            ]
        );
    }
    public function selectClientes(Request $request)
{
    $servicio = $request->input('servicio');

    $clientes = Cliente::where('servicio', 'like', '%' . $servicio . '%')->limit(50)->get();

    return response()->json(['results' => $clientes]);
}

    public function edit(Agente $agente)
    {

        // $clientes = Cliente::get(['id','nombre','servicio'])->paginate(50);
        $clientes = Cliente::paginate(50);
        return view(
            'agentes.edit',
            [
                'agente' => $agente,
                'clientes' =>$clientes
            ]
        );
    }


    public function update(Request $request, Agente $agente)
    {


    }
    public function addCliente(Request $request, Agente $agente)
    {
        $cliente = Cliente::where('id' , $request->get('servicio'))->first();
        $cliente->id_agente = $agente->id;
        $cliente->save();
        toast('Has adicionado el servicio: ' . $cliente->servicio .' al agente ' .$agente->nombre,'success');
        return redirect(route('dashboard.agentes.show', $agente));

    }
    public function removeCliente($id)
    {
        $cliente = Cliente::where('id' , $id)->first();
        $cliente->id_agente = null;
        $cliente->save();
        toast('Has quitado el cliente: ' . $cliente->nombre .'correctamente' , 'success');
        return back();
    }


    public function destroy($id)
    {
        //
    }
}
