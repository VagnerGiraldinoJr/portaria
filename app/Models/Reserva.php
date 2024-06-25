<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'user_id',
        'area',
        'unidade_id',
        'data_inicio',
        'limpeza',
        'status',
    ];

    // Definindo a relação 'lote'
    public function lote()
    {
        return $this->belongsTo(Lote::class, 'unidade_id');
    }

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }
}