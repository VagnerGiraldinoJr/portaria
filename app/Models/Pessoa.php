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
        "unidade_id"
    ];
    public function getDescTipoAttribute()
    {
        $codes = new TableCode();
        return (isset($this->tipo) && $this->tipo != NULL) ? $codes->getDescricaoById(4,$this->tipo) : '' ;  
    }

    // public function getTempoPermanenciaAttribute()
    // {

    //     $to_time = strtotime($this->data_entrada);
    //     $from_time = strtotime($this->data_saida);
    //     return round(abs($to_time - $from_time) / 60,2). " Min.";
    // }



}
