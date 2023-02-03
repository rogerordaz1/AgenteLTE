<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ocomerciale extends Model
{

    use HasFactory;


    protected $table = 'ocomerciales';

    protected $fillable = [
        'id',
        'nombre',
        'direccion',
    ];



    public function clientes(){
        return $this->hasMany(Cliente::class , 'id_oficina_comercial' , 'id');
    }
    
    public function agentes(){
        return $this->hasMany(Agente::class , 'id_oficina_comercial' , 'id');
    }

}
