<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NAgredado extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre',
        'servicio',
        'id_agente',
    ];

    protected $table = 'n_agredados';


    public function agente()
    {
        return $this->belongsTo(Agente::class, 'id_agente');
    }
}
