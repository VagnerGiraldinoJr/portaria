<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class ControleAcesso extends Model
{
    
    // id, unidade_id, tipo, lote_id, veiculo_id, motorista, motivo, observacao, data_entrada, data_saida, created_at, updated_at

    protected $fillable = ["id","tipo","lote_id","unidade_id","veiculo_id","motorista","data_entrada","data_saida","observacao","motivo","desc_tipo"];


    public function lote(): HasMany
    {
        return $this->HasMany(Lote::class, 'id', 'lote_id');
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

    public function EncomendasNaoEntregues(){
    
        return $this->where('unidade_id', Auth::user()->unidade_id, 'data_saida',NULL)->get()->first();
    }
    
    public function EncomendasEntregues(){

        return $this->where('unidade_id', Auth::user()->unidade_id, 'data_saida',NULL)->get()->first();

   
    }
   
    public function QuantidadesVisitantes(){

        return $this->where('unidade_id', Auth::user()->unidade_id, 'hora_de_saida',NULL)->get()->first();

   
    }
   
}   