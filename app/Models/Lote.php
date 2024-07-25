<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = ["unidade_id","descricao"];

    // Um Lote pode ter muitas Reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'lote_id'); 
    }
   
}

