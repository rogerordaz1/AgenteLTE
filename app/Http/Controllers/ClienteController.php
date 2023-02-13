<?php

namespace App\Http\Controllers;


use App\Models\Cliente;
use App\Models\Factura;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
   
    public function index()
    {
        $facturas = Factura::all();
       
       return view('clientes.index' ,[
        'facturas' => $facturas
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
        $cliente = Cliente::find($id);
        
        return view('clientes.show' , [ 
            'cliente' => $cliente
        ]);
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
