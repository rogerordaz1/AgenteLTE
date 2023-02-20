<?php

namespace App\Models;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agente extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'id_oficina_comercial',
        'servicio',
        'agrupacion',
        'sector',
        'nombre',
        'direccion',
        'cuenta_bancaria',
        'fecha_alta',
    ];

    public function ocomercial(){
        return $this->belongsTo(Ocomerciale::class);
    }

    public function clientes(){
        return $this->hasMany(Cliente::class , 'id_agente');
    }
}
