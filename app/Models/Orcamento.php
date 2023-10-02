<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Orcamento extends Model
{
    protected $fillable = ['id', 'cliente_id', 'valor', 'acrescimo', 'desconto', 'valor_total', 'forma_pagamento', 'data_entrega', 'data_hora', 'cadastrado_por','desc_produto'];


    public function itens(){
        return $this->hasMany('App\Models\OrcamentoIten');
    }

    public function status(){
        return $this->hasMany('App\Models\OrcamentoSituacao');
    }

    public function getStatusAtual(){
        return $this->hasMany('App\Models\OrcamentoSituacao')->where('fim',NULL);
    }

    public function getPedido(){
        return $this->hasMany('App\Models\OrcamentoSituacao')->where('fim',NULL)->where('status','>',1);
    }

    public function getStatusEmProducao(){
        return $this->hasMany('App\Models\OrcamentoSituacao')->where('fim',NULL)->where('status',2);
    }


    public function getStatusFinalizado(){
        return $this->hasMany('App\Models\OrcamentoSituacao')->where('fim',NULL)->where('status',3);
    }


    public function cliente(){
        return $this->hasOne('App\Models\Cliente','id','cliente_id');
    }

    public function getOrcamento($id){
        return $this->select(DB::raw("orcamentos.id, orcamentos.cliente_id, orcamentos.valor, orcamentos.acrescimo
                                    , orcamentos.desconto, orcamentos.valor_total, orcamentos.forma_pagamento
                                    , f_desc_table_codes(5,orcamentos.forma_pagamento) as desc_forma_pagamento, orcamentos.data_entrega
                                    , DATE_FORMAT(orcamentos.data_entrega,'%d/%m/%Y') AS data_entrega_br
                                    , clientes.cpf_cnpj, clientes.data_nascimento ,DATE_FORMAT(clientes.data_nascimento,'%d/%m/%Y') AS data_nascimento_br, clientes.nome_razaosocial, clientes.cep, clientes.logradouro, clientes.bairro, clientes.numero
                                    , clientes.localidade, clientes.complemento, clientes.uf, clientes.email, clientes.telefone, clientes.celular, clientes.recado, clientes.observacoes"))
                    ->join('clientes','clientes.id','=','orcamentos.cliente_id')
                    ->with('itens')
                    ->with('status')
                    ->with('getStatusAtual')
                    ->find($id);

    }

    public function getOrcamentoClienteValor($id){
        return $this->select(DB::raw("orcamentos.id, orcamentos.valor_total
                                    ,clientes.cpf_cnpj
                                    ,clientes.nome_razaosocial
                                    ,DATE_FORMAT(orcamentos.data_hora,'%d/%m/%Y') AS data"))
                    ->join('clientes','clientes.id','=','orcamentos.cliente_id')
                    ->find($id);
    }

    public function lancarBaixaPedido($id){
        $itens = $this->select('orcamento_itens.*')
                      ->join('orcamento_itens','orcamento_itens.orcamento_id','orcamentos.id')
                      ->join('produtos','produtos.id','orcamento_itens.produto_id')
                      ->where('produtos.controla_estoque',1)
                      ->where('orcamentos.id',$id)
                      ->get();
        if( $itens){

            $baixa_material = new BaixaMaterial();
            $estoque = new Estoque();

            DB::beginTransaction();

            /*
           id, produto_id, quantidade, motivo, cadastrado_por, data_cadastro, created_at, updated_at
           */
   
           foreach( $itens as $item){
                $data['produto_id'] = $item->produto_id;
                $data['quantidade']= $item->quantidade ;
                $data['motivo']= 'LANÇAMENTO SISTEMICO - PEDIDO: '.$id;
                $data['cadastrado_por']= Auth::user()->email;
                $data['data_cadastro']= date('Y-m-d');
        
              
                $insert = $baixa_material->create($data);
                if(! $insert){
                    DB::rollback();
                    return false;
                }

                if(! $estoque->atualizarEstoque($data['produto_id'],$data['quantidade'],0) ){
                    DB::rollBack();
                    return false;
                }
            }

            DB::commit();
            return true;
   

        }
 
        return true;
 

    }

    


}
