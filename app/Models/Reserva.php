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
        'unidade_id', // Chave estrangeira para Lote
        'lote_id',
        'status',
        'acessorios',
        'celular_responsavel',
        'dt_entrega_chaves',
        'retirado_por',
        'dt_devolucao_chaves',
        'devolvido_por',
    ];

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }

    // Uma Reserva pertence a uma Unidade
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id'); // 'unidade_id' como chave estrangeira
    }

    // Uma Reserva pode ter muitos Visitantes
    // public function visitantes()
    // {
    //     return $this->hasMany(Visitante::class); // Assume uma chave estrangeira de referência na tabela 'visitantes'
    // }

    // Uma Reserva pertence a um Usuário
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id'); // Chave estrangeira 'user_id'
    // }
}


