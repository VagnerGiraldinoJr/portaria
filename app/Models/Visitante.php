<?php

namespace App\Models;


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
    'user_id'
         
    ];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }
}