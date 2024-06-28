<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'user_id',
        'area',
        'lote_id',
        'data_inicio',
        'limpeza',
        'status',
        'acessorios',
        'celular_responsavel'
    ];

    // Definindo a relação 'lote'
    public function lote()
    {
        return $this->belongsTo(Lote::class, 'id');
    }

    // Definindo a relação 'Unidades'
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }
}
