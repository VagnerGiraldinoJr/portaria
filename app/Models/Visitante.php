<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{

    protected $fillable = [
        'nome',
        'documento',
        'placa_do_veiculo',
        'unidade_id',
        'lote_id',
        'hora_de_entrada',
        'user_id',
        'motivo'

    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }

    // Acessor para hora_de_entrada
    public function getHoraDeEntradaAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    // Acessor para hora_de_saida
    public function getHoraDeSaidaAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }
}
