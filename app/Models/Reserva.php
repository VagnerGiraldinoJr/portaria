<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

        return $this->belongsTo(Lote::class, 'unidade_id');
    }

    // Definindo a relação 'Unidades'
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    // Se houver uma relação direta entre Unidade e Visitante:
    public function visitante()
    {
        return $this->hasMany(Visitante::class);
    }

  

    public function users()
    {
        return $this->hasMany(User::class, 'unidade_id');
    }


    public function pessoas()
    {
        return $this->hasManyThrough(Pessoa::class, 'lote_id', Lote::class, 'id');
    }
}
