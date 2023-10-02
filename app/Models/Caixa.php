<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Caixa extends Model
{
    //id, data_abertura, data_fechamento, fechado_por, created_at, updated_at
    

    protected $fillable = [
        'id', 'data_abertura', 'data_fechamento','aberto_por' ,'fechado_por'
    ];

    
    public function ultimosCaixas(){
        return $this->select(DB::raw("  DATE_FORMAT(data_abertura,'%d/%m%/%Y %H:%i') as data_abertura,
                                        DATE_FORMAT(data_fechamento,'%d/%m%/%Y %H:%i') as data_fechamento, 
                                        aberto_por, fechado_por,
                                        (SELECT IFNULL(ca.valor,0)  
                                           FROM conta_correntes ca
                                          WHERE ca.operacao = 88 
                                            AND ca.caixa_id = caixas.id ) as valor_abertura ,
                                        (SELECT IFNULL(cf.valor,0)  
                                           FROM conta_correntes cf
                                          WHERE cf.operacao = 99 
                                            AND cf.caixa_id = caixas.id ) as valor_fechamento "))
                    ->orderBy('id','desc')
                    ->limit(15)
                    ->get();
    }

    public function caixaAberto(){
        return $this->where('data_fechamento',NULL)->get()->first();
    }

    public function caixaAnterior($caixa_id){
        return $this->where('id','<',$caixa_id)->max('id');
               
    }

    public function saldoAtualCaixa($caixa_id){
        
        $valor =  $this->select(DB::raw(" CAST( IFNULL( 
                                                ((SELECT IFNULL(ce.valor,0) 
                                                    FROM conta_correntes ce
                                                   WHERE ce.operacao = 88 
                                                     AND ce.extornado <> 1
                                                     AND ce.caixa_id = caixas.id ) + 
                                                    (SELECT IFNULL(SUM(ce.valor),0) 
                                                    FROM conta_correntes ce
                                                   WHERE ce.operacao = 1 
                                                     AND ce.extornado <> 1
                                                     AND ce.caixa_id = caixas.id ) - 
                                                 (SELECT IFNULL(SUM(cs.valor),0) 
                                                    FROM conta_correntes cs
                                                   WHERE cs.operacao = 0 
                                                     AND cs.extornado <> 1 
                                                     AND cs.caixa_id = caixas.id)), 0 ) AS DECIMAL(10,2)) AS valor"))
                                ->where('id',$caixa_id)
                                ->get()
                                ->first();
        return $valor->valor;
         
    }


}
