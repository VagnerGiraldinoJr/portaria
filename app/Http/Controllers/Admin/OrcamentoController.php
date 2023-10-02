<?php

namespace App\Http\Controllers\Admin;

use App\Models\Orcamento;
use App\Models\TableCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Orcamento\OrcamentoInsertRequest;
use App\Http\Requests\Admin\Orcamento\OrcamentoUpdateRequest;
use App\Http\Requests\Admin\Orcamento\ValidaCpfCnpj as ValidaCpfCnpj;
use App\Models\Cliente;
use App\Models\OrcamentoIten;
use App\Models\OrcamentoSituacao;
use App\Models\Produto;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrcamentoController extends Controller
{



    public function __construct(Orcamento $orcamentos, Produto $produtos, OrcamentoIten $orcamentoItens, Cliente $clientes , OrcamentoSituacao $orcamento_situacaos)
    {
        $this->orcamento = $orcamentos;
        $this->orcamento_iten = $orcamentoItens;
        $this->produto = $produtos;
        $this->cliente = $clientes;
        $this->orcamento_situacao = $orcamento_situacaos;

        // Default values
        $this->params['titulo']='Orçamento';
        $this->params['main_route']='admin.orcamento';

    }

    public function index(Request $request)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Orçamentos Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/orcamento',
                    'titulo' => 'Orçamentos'
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
                                                 , s.status'))
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

        return view('admin.orcamento.index',compact('params','data','searchFields'));
    }

    public function create(TableCode $codes)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Orçamento';
        $this->params['arvore']=[
           [
               'url' => 'admin/orcamento',
               'titulo' => 'Orçamento'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $preload['codes'] = $codes->select(2);
       $preload['formas_pagamento'] = $codes->select(5);

       $preload['produtos'] = $this->produto->orderBy('titulo')->get()->pluck('titulo','id');

       return view('admin.orcamento.create',compact('params','preload'));
    }

    public function store(OrcamentoInsertRequest $request)
    {
        DB::beginTransaction();

        /*
            id, cliente_id, valor, acrescimo, desconto, valor_total, forma_pagamento,
            situacao, data_entrega, data_hora, cadastrado_por
        */

        $dataForm  = $request->except('produto_id','quantidade','valor_unitario');

        $dataForm['situacao'] = 1;
        $dataForm['cadastrado_por'] = Auth::user()->email;

        // CASTING FOR DECIMAL NUMBERS
        $dataForm['valor'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['valor']));
        $dataForm['valor_total'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['valor_total']));
        $dataForm['acrescimo'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['acrescimo']));
        $dataForm['desconto'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['desconto']));


        $insert = $this->orcamento->create($dataForm);
        if($insert){
            $dataFormItens  = $request->only(['produto_id','quantidade','valor_unitario']);
            $orcamento_id = $insert->id;
            foreach($dataFormItens['produto_id'] as $i => $v ){
                 /*
                    id, orcamento_id, produto_id, quantidade, valor, created_at, updated_at
                */
                $data['orcamento_id'] = $orcamento_id;
                $data['produto_id'] = $dataFormItens['produto_id'][$i];
                $data['quantidade'] = (float) str_replace(',', '.',str_replace('.', '', $dataFormItens['quantidade'][$i]));
                $data['valor'] = (float) str_replace(',', '.',str_replace('.', '', $dataFormItens['valor_unitario'][$i]));
                if(!$this->orcamento_iten->create($data)){
                    return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao Inserir Itens.']);
                    DB::rollBack();
                }

            }

            $data['orcamento_id'] =  $orcamento_id;
            $data['status'] = 1;
            $data['inicio'] = \Carbon\Carbon::now();
            $data['cadastrado_por'] = Auth::user()->name;

            if(!$this->orcamento_situacao->create($data)){
                return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao Inserir Status.']);
                DB::rollBack();
            }

            DB::commit();
            return redirect()->route($this->params['main_route'].'.index');

        }else{
            DB::rollback();
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao Inserir.']);
        }
    }

    public function show($id,TableCode $codes)
    {
        $this->params['subtitulo']='Deletar Orçamento';
        $this->params['arvore']=[
           [
               'url' => 'admin/orcamento',
               'titulo' => 'Orçamento'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
       $params = $this->params;

       $data = $this->orcamento->find($id);
       $preload['codes'] = $codes->select(2);
       return view('admin.orcamento.show',compact('params','data','preload'));
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
        $data['valor'] = (float) str_replace('.', ',',$data['valor']);
        $data['valor_total'] = (float) str_replace('.', ',',$data['valor_total']);
        $data['acrescimo'] = (float) str_replace('.', ',',$data['acrescimo']);
        $data['desconto'] = (float) str_replace('.', ',',$data['desconto']);



        $preload['codes'] = $codes->select(2);
        $preload['formas_pagamento'] = $codes->select(5);
        $preload['produtos'] = $this->produto->orderBy('titulo')->get()->pluck('titulo','id');
        return view('admin.orcamento.create',compact('params', 'data','preload'));
    }

    public function update(OrcamentoUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        /*
            id, cliente_id, valor, acrescimo, desconto, valor_total, forma_pagamento,
            situacao, data_entrega, data_hora, cadastrado_por
        */

        $dataForm  = $request->only('valor','acrescimo','desconto','valor_total','data_entrega');



        // CASTING FOR DECIMAL NUMBERS
        $dataForm['valor'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['valor']));
    //    dd($dataForm['valor']);
        $dataForm['acrescimo'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['acrescimo']));
        $dataForm['desconto'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['desconto']));
        $dataForm['valor_total'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['valor_total']));

        $update = $this->orcamento->find($id)->update($dataForm);
        if($update){
            $delete = $this->orcamento_iten->where('orcamento_id',$id)->delete();
            if($delete){
                $dataFormItens  = $request->only(['produto_id','quantidade','valor_unitario']);
                foreach($dataFormItens['produto_id'] as $i => $v ){
                    /*
                        id, orcamento_id, produto_id, quantidade, valor, created_at, updated_at
                    */
                    $data['orcamento_id'] = $id;
                    $data['produto_id'] = $dataFormItens['produto_id'][$i];
                    $data['quantidade'] = (float) str_replace(',', '.',str_replace('.', '', $dataFormItens['quantidade'][$i]));
                    $data['valor'] = (float) str_replace(',', '.',str_replace('.', '', $dataFormItens['valor_unitario'][$i]));
                    if(!$this->orcamento_iten->create($data)){
                        return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
                        DB::rollBack();
                    }

                }
                DB::commit();
                return redirect()->route($this->params['main_route'].'.index');
            }else{
                DB::rollback();
                return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao atualizar itens do pedido.']);
            }

        }else{
            DB::rollback();
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }

    }

    public function getOrcamentoById(Request $request)
    {
        $id = $request->only('id');
        $data = $this->orcamento->getOrcamento($id);

        return response()->json($data);
    }

    public function print($id)
    {

        $data = $this->orcamento->getOrcamento($id);

        
        $pdf = PDF::loadView('admin.print.orcamento',compact('data'));
     //   return view('admin.print.orcamento',compact('data'));
        return $pdf->download('orcamento_dominare_'.$id.'.pdf');
    }
}
