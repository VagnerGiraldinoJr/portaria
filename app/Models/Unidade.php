<?php

namespace App\Models;

use App\Models\Visitante as ModelsVisitante;
use App\Models\Visitante;
use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = [
        'id', 'titulo'
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
        return $this->hasManyThrough(Pessoa::class, 'lote_id', Lote::class, 'id');
    }
}
