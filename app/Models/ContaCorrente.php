<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContaCorrente extends Model
{
    //  id, valor, operacao, forma_pagamento, tipo_retirada, data_hora, cadastrado_por,
    //  referencia, pedido_id, extornado, motivo_extorno, fechado, fechado_por, deleted_at, created_at, updated_at

    protected $fillable = ['id','caixa_id', 'valor', 'operacao', 'forma_pagamento', 'data_hora','cadastrado_por','referencia','pedido_id','extornado','motivo_extorno','fechado', 'fechado_por'];


    public function getTotalEntradaSaidaAteData($operacao, $date)
    {

        $total  =  $this->select('valor')
                        ->whereDate('operacao',$operacao)
                        ->whereDate('data_hora','<=',$date)
                        ->get()
                        ->sum("valor");
        return $total;
    }

    public function getEntradaSaidaIntervalo($date_inicio, $data_fim,$paginate=30)
    {

        //id, caixa_id, valor, operacao, forma_pagamento, data_hora, cadastrado_por, 
        // referencia, pedido_id, extornado, motivo_extorno, fechado, fechado_por

        $total  =  $this->selectRaw("id,caixa_id, valor, operacao, data_hora,
                                        if(operacao <> 88 AND operacao <> 99
                                            , concat(f_desc_table_codes(7,operacao), ': ',referencia )
                                            , concat('-- ', f_desc_table_codes(7,operacao), ' --') ) AS desc_operacao   
                                            
                                        ,referencia, pedido_id, extornado, motivo_extorno, fechado, fechado_por   
                                        ")
                        ->whereDate('data_hora','>=',$date_inicio)
                        ->whereDate('data_hora','<=',$data_fim)
                        ->paginate($paginate);
        return $total;
    }

    public function getStatusCaixa(){
        return $this->where('fechado',0)->count() > 0 ? true : false;
    }

    public function getLancamentosContaCorrente(){
        return $this->where('fechado',0)->count() > 0 ? true : false;
    }

    public function valorFechamentoCaixa($caixa_id){
        $valor = $this->selectRaw("CAST( IFNULL(valor,0) AS DECIMAL(10,2) ) as valor")
                                ->where('caixa_id',$caixa_id)
                                ->where('operacao',99)
                                ->get()
                                ->first();

        return ($valor) ? $valor->valor : 0;
    }

    public function valorAberturaCaixa($caixa_id){
        $valor = $this->selectRaw("CAST( IFNULL(valor,0) AS DECIMAL(10,2) ) as valor")
                                ->where('caixa_id',$caixa_id)
                                ->where('operacao',88)
                                ->get()
                                ->first();

        return ($valor) ? $valor->valor : 0;
    }
}


