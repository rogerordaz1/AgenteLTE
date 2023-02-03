<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $fillable = [
        'id',
        'id_oficina_comercial',
        'id_agente',
        'servicio',
        'sector',
        'nombre',
        'direccion',
        'cuenta_bancaria',
        'fecha_alta',
    ];

    use HasFactory;

    public function ocomercial()
    {
        return $this->belongsTo(Ocomerciale::class);
    }

    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_agente', 'id');
    }
}
