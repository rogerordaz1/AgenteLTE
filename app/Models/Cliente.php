<?php

namespace App\Models;

use App\Models\Factura;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'id_oficina_comercial',
        'id_agente',
        'servicio',
        'agrupacion',
        'sector',
        'nombre',
        'direccion',
        'cuenta_bancaria',
        'fecha_alta',
    ];

   

    public function ocomercial()
    {
        return $this->belongsTo(Ocomerciale::class);
    }

    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_agente', 'id');
    }
    public function factura()
    {
        return $this->hasOne(Factura::class , 'servicio_cliente' , 'servicio');
    }
}
