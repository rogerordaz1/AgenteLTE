<?php

namespace App\Http\Controllers;

use App\Models\Agente;
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


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
