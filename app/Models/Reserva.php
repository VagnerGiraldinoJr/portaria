<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    protected $fillable = [
        'user_id',
        'area',
        'data_inicio',
        'limpeza',
        'unidade_id',
        'status',
        'acessorios',
        'celular_responsavel',
        'dt_entrega_chaves',
        'retirado_por',
        'dt_devolucao_chaves',
        'devolvido_por',
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
