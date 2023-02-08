<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DatatableController extends Controller
{
    public function clientes(){
        return DataTables::of(Cliente::all())->toJson();
    }
}