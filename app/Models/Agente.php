<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agente extends Model
{
    use HasFactory;


    public function ocomercial(){
        return $this->belongsTo(Ocomerciale::class);
    }

    public function clientes(){
        return $this->hasMany(Cliente::class);
    }
}
