<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'area',
        'unidade_id',
        'data_inicio',
        'data_fim',
        'limpeza',
        'status',
    ];
    
      // Definindo a relação 'lote'
    public function lote()
    {
        return $this->belongsTo(Lote::class,'unidade_id');
    }

}
