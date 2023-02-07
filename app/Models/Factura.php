<?php

namespace App\Models;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Factura extends Model
{
    protected $table = 'facturas';

    protected $fillable = [

        'oficina',
        'agrupacion',
        'cuenta',
        'no_factura',
        'nombre_cliente',
        'servicio_cliente',
        'cuota',
        'LDN',
        'LDI',
        'local',
        'otros',
        'impuesto',
        'comision',
        'facturado',
        'atrasos',
        'total',

    ];

    use HasFactory;

    public function clinte()
    {
        return $this->belongsTo(Cliente::class, 'servicio', 'servicio_cliente');
    }
}
