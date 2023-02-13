<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Factura;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DatatableController extends Controller
{
    public function clientes(){
        
        // return DataTables::of($clientes)
        // ->addColumn('total',function($clientes){
        //     return $clientes->factura->total;
        //   })
        // ->toJson();
    }
}
