<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class ControleAcesso extends Model
{
    
    protected $fillable = ["id","tipo","pessoa_id","unidade_id","veiculo_id","motorista","data_entrada","data_saida","observacao","motivo","destino","desc_tipo"];


    public function pessoa(): HasMany
    {
        return $this->HasMany(Pessoa::class, 'id', 'pessoa_id');
    }

    public function veiculo(): HasMany
    {
        return $this->HasMany(Veiculo::class, 'id', 'veiculo_id');
    }

    public function getDescTipoAttribute()
    {
        $codes = new TableCode();
        return (isset($this->tipo) && $this->tipo != NULL) ? $codes->getDescricaoById(5,$this->tipo) : '' ;  
    }

    // public function getDataSaidaNull(){
       
    //     return $this->HasMany(ControleAcesso::class)->where('data_saida', null);           
        
    // }
}
