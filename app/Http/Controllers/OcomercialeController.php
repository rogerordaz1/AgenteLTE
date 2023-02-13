<?php

namespace App\Http\Controllers;

use App\Models\Ocomerciale;
use Illuminate\Http\Request;

class OcomercialeController extends Controller
{
   
    public function index()
    {
        $comerciales = Ocomerciale::all();
        return view(
            'comerciales.index',
            [
                'comerciales' => $comerciales
            ]
        );
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     
     */
    public function show($id)
    {
        $comercial = Ocomerciale::find($id);
        $clientes = $comercial->clientes;

        return view('comerciales.show' , [
            'comercial' =>  $comercial,
            'clientes' => $clientes
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
