<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model
{
    protected $fillable = [        
        "nome_completo",
        "celular",
        "rg",
        "tipo",
        "lote_id",
        "desc_tipo"
        
    ];

    protected $appends = ['desc_tipo'];

    public function getDescTipoAttribute()
    {
        $codes = new TableCode();
        return (isset($this->tipo) && $this->tipo != NULL) ? $codes->getDescricaoById(4,$this->tipo) : '' ;  
    }
   
    public function lote()
    {
        return $this->belongsTo(Lote::class,'unidade_id');
    }
 

}

