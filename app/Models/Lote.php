<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $fillable = ["unidade_id","descricao"];

    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidade_id');
    }
   
}

