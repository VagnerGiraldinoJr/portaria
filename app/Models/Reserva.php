<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

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

    // Em App\Models\Reserva
    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

    // Uma Reserva pertence a uma Unidade
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id'); // 'unidade_id' como chave estrangeira
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($reserva) {
            if ($reserva->lote->estaInadimplente()) {
                throw ValidationException::withMessages([
                    'lote' => 'Este lote está inadimplente e não pode fazer reservas.'
                ]);
            }
        });
    }
}
