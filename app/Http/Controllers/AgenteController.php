<?php

namespace App\Http\Controllers;

use App\Models\Agente;
use Illuminate\Http\Request;

class AgenteController extends Controller
{

    public function index()
    {
        return view('agentes.index');
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
