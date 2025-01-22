<?php

namespace App\Models;

use App\Models\Visitante as ModelsVisitante;
use App\Models\Visitante;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = [
        'id',
        'titulo'
    ];


    // Se houver uma relação direta entre Unidade e Visitante:
    public function visitante()
    {
        return $this->hasMany(Visitante::class);
    }

    public function lotes()
    {
        return $this->hasMany(Lote::class, 'unidade_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'unidade_id');
    }


    public function pessoas()
    {
        return $this->hasManyThrough(
            Pessoa::class, // Modelo de destino
            Lote::class,   // Modelo intermediário
            'unidade_id',  // Chave estrangeira em Lote que referencia Unidade
            'lote_id',     // Chave estrangeira em Pessoa que referencia Lote
            'id',          // Chave local em Unidade
            'id'           // Chave local em Lote
        );
    }
}
