<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pedido\PedidoUpdateRequest;
use App\Models\Orcamento;
use App\Models\OrcamentoSituacao;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\TableCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class PedidoController extends Controller
{
    public function __construct(Orcamento $orcamentos, Produto $produtos, OrcamentoSituacao $orcamento_situacaos)
    {
        $this->orcamento = $orcamentos;
        $this->produto = $produtos;
        $this->orcamento_situacao = $orcamento_situacaos;

        // Default values
        $this->params['titulo']='Pedido';
        $this->params['main_route']='admin.pedido';

    }

    public function index(Request $request)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Pedidos Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/pedido',
                    'titulo' => 'Pedidos'
        ];

        $searchFields = $request->except('_token');
        $searchFields['cpf_cnpj']= (isset($searchFields['cpf_cnpj']) && $searchFields['cpf_cnpj'] !== null )?$searchFields['cpf_cnpj']:'';
        $searchFields['nome_razaosocial']= (isset($searchFields['nome_razaosocial'])  && $searchFields['nome_razaosocial'] !== null) ? $searchFields['nome_razaosocial']:'';
        $searchFields['numero']= (isset($searchFields['numero'])  && $searchFields['numero'] !== null) ? $searchFields['numero']:'';
        $operador = ($searchFields['numero'] == '')?'<>':'=';
        $params = $this->params;

        $data = $this   ->orcamento
                        ->select(DB::raw('orcamentos.id, REPLACE(orcamentos.valor_total, ".",",") AS valor_total,
                                                 DATE_FORMAT(data_hora,"%d/%m/%Y") as data_hora ,c.cpf_cnpj,c.nome_razaosocial
                                                 , s.status , f_desc_table_codes(6, s.status) as desc_status'))
                        ->join('clientes as c','c.id','cliente_id')
                        ->leftJoin('orcamento_situacaos as s',function($join){
                            $join   ->on('s.orcamento_id','orcamentos.id')
                                    ->where('s.fim',NULL);
                        })
                        ->where("nome_razaosocial","like","%".$searchFields['nome_razaosocial']."%")
                        ->where("cpf_cnpj","like","%".$searchFields["cpf_cnpj"]."%")
                        ->where('orcamentos.id',$operador,$searchFields['numero'])
                        ->orderby('orcamentos.id','desc')
                        ->paginate(30);

        return view('admin.pedido.index',compact('params','data','searchFields'));
    }
    
    public function edit($id,TableCode $codes)
    {
        $this->params['subtitulo']='Editar Orçamento';
        $this->params['arvore']=[
           [
               'url' => 'admin/orcamento',
               'titulo' => 'Orçamento'
           ],
           [
               'url' => '',
               'titulo' => 'Editar'
           ]];
        $params = $this->params;

        $data = $this->orcamento->getOrcamento($id);

        // CASTING FOR DECIMAL NUMBERS
        $data['valor'] = number_format((float) str_replace('.', ',',$data['valor']),2, ',', '.');
        $data['valor_total'] =  number_format((float) str_replace('.', ',',$data['valor_total']),2, ',', '.');
        $data['acrescimo'] =  number_format((float) str_replace('.', ',',$data['acrescimo']),2, ',', '.');
        $data['desconto'] =  number_format((float) str_replace('.', ',',$data['desconto']),2, ',', '.');

        $preload['codes'] = $codes->select(2);
        $preload['formas_pagamento'] = $codes->select(5);
        $preload['status'] = $codes->selectExcept(6,1);
        $preload['produtos'] = $this->produto->orderBy('titulo')->get()->pluck('titulo','id');
       
        return view('admin.pedido.create',compact('params', 'data','preload'));
    }

    public function update(PedidoUpdateRequest $request)
    {
        DB::beginTransaction();

        /*
           id, orcamento_id, inicio, fim, status, cadastrado_por, created_at, updated_at
        */

        $dataForm  = $request->only('orcamento_id','status');

        // dd($this->orcamento->getOrcamento($dataForm['orcamento_id']));
        // $data = $this->orcamento->getOrcamento($dataForm['orcamento_id']);

        $situacao = $this->orcamento_situacao->where('orcamento_id',$dataForm['orcamento_id'])->where('fim',NULL);
        // pega o status
        $tmp = $situacao->first();

        if((isset($tmp->status)) 
            && (intval($tmp->status) != intval($dataForm['status'])) 
            && ($situacao->update(['fim' => \Carbon\Carbon::now()])) ){


            /*
            id, produto_id, quantidade, motivo, cadastrado_por, data_cadastro, created_at, updated_at
            */
            if(intval($dataForm['status']) === 3){
                if(! $this->orcamento->lancarBaixaPedido($dataForm['orcamento_id'])){
                    DB::rollback();
                    return Redirect::back()->withErrors(['Falha ao alterar o status!']);   
                }
            }
            
            $dataForm['inicio']= \Carbon\Carbon::now();
            $dataForm['cadastrado_por'] = Auth::user()->name;
            $create = $this->orcamento_situacao->create($dataForm);

            if(!$create){
                DB::rollback();
                return Redirect::back()->withErrors(['Falha ao alterar o status!']);
            }

            DB::commit();
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            DB::rollback();
            return Redirect::back()->withErrors(['Falha ao alterar o status!']);
        }

    }
}
