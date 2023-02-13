<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(Cliente::class);
    }
}
