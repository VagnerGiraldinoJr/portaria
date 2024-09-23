<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassagemTurno extends Model
{
    protected $table = 'passagens_turno';
    
    protected $fillable = [
        'user_id',
        'unidade_id',
        'inicio_turno',
        'fim_turno',
        'itens',
        'ocorrencias'
    ];

    // Relacionamento com o porteiro
    protected function user(){
        return $this->belongsTo(User::class);
    }
    // Relacionamento com unidade
    public function unidade(){
        return $this->belongsTo(Unidade::class);
    }

}
