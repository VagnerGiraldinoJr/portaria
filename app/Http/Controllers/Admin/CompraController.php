<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Compra\CompraInsertRequest;
use App\Http\Requests\Admin\Compra\CompraUpdateRequest;
use App\Models\Compra;
use App\Models\CompraIten;
use App\Models\Estoque;
use App\Models\Produto;
use App\Models\TableCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function __construct(Compra $compras, Produto $produtos, CompraIten $compraItens , Estoque $estoques)
    {
        $this->compra = $compras;
        $this->compraiten = $compraItens;
        $this->produto = $produtos;
        $this->estoque = $estoques;

        // Default values
        $this->params['titulo']='Compra';
        $this->params['main_route']='admin.compra';
    }

    public function index(Request $request)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Compras Cadastradas';
        $this->params['arvore'][0] = [
                    'url' => 'admin/compra',
                    'titulo' => 'Compras'
        ];

        $searchFields = $request->except('_token');
        $searchFields['cpf_cnpj']= (isset($searchFields['cpf_cnpj']) && $searchFields['cpf_cnpj'] !== null )?$searchFields['cpf_cnpj']:'';
        $searchFields['nome_razaosocial']= (isset($searchFields['nome_razaosocial'])  && $searchFields['nome_razaosocial'] !== null) ? $searchFields['nome_razaosocial']:'';
        $searchFields['numero']= (isset($searchFields['numero'])  && $searchFields['numero'] !== null) ? $searchFields['numero']:'';
        $operador = ($searchFields['numero'] == '')?'<>':'=';

        $params = $this->params;

        $data = $this   ->compra
                        ->select(DB::raw('compras.id, REPLACE(compras.valor_total, ".",",") AS valor_total,
                                                 DATE_FORMAT(compras.data_hora,"%d/%m/%Y") as data_hora 
                                                 ,compras.cpf_cnpj,compras.nome_razaosocial'))
                        ->where("compras.nome_razaosocial","like","%".$searchFields['nome_razaosocial']."%")
                        ->where("compras.cpf_cnpj","like","%".$searchFields["cpf_cnpj"]."%")
                        ->where('compras.id',$operador,$searchFields['numero'])
                        ->orderby('compras.id','desc')
                        ->paginate(30);
        return view('admin.compra.index',compact('params','data','searchFields'));
    }

    public function create(TableCode $codes)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Compra';
        $this->params['arvore']=[
           [
               'url' => 'admin/compra',
               'titulo' => 'Compra'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
        $params = $this->params;

        $preload['produtos'] = $this->produto->orderBy('titulo')->get()->pluck('titulo','id');
        return view('admin.compra.create',compact('params','preload'));
    }

    public function store(CompraInsertRequest $request)
    {
        DB::beginTransaction();

        /*
        id, cpf_cnpj, nome_razaosocial, valor, acrescimo, desconto
        , valor_total, data_entrada, data_hora
        , cadastrado_por, deleted_at, created_at, updated_at
        */

        $dataForm  = $request->except('produto_id','quantidade','valor_unitario');

        $dataForm['cadastrado_por'] = Auth::user()->email;

        // CASTING FOR DECIMAL NUMBERS
        $dataForm['valor'] = (float) str_replace('.', ',', $dataForm['valor']);
        $dataForm['valor_total'] = (float) str_replace('.', ',', $dataForm['valor_total']);
        $dataForm['acrescimo'] = (float) str_replace('.', ',', $dataForm['acrescimo']);
        $dataForm['desconto'] = (float) str_replace('.', ',', $dataForm['desconto']);

        $insert = $this->compra->create($dataForm);
        if($insert){
            $dataFormItens  = $request->only(['produto_id','quantidade','valor_unitario']);
            $compra_id = $insert->id;
            foreach($dataFormItens['produto_id'] as $i => $v ){
                 /*
                    id, compra_id, produto_id, quantidade, valor, created_at, updated_at
                */
                $data['compra_id'] = $compra_id;
                $data['produto_id'] = $dataFormItens['produto_id'][$i];
                $data['quantidade'] = (float) str_replace('.', ',', $dataFormItens['quantidade'][$i]);
                $data['valor'] = (float) str_replace('.', ',', $dataFormItens['valor_unitario'][$i]);
                if(!$this->compraiten->create($data)){
                    return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
                    DB::rollBack();
                }
                if(! $this->estoque->atualizarEstoque($data['produto_id'],$data['quantidade'],1)){
                    return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao atualizar o estoque.']);
                    DB::rollBack();
                }
            }

            DB::commit();
            return redirect()->route($this->params['main_route'].'.index');

        }else{
            DB::rollback();
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }
    }

    public function show($id,TableCode $codes)
    {
        $this->params['subtitulo']='Deletar Compra';
        $this->params['arvore']=[
           [
               'url' => 'admin/compra',
               'titulo' => 'Compra'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
       $params = $this->params;

       $data = $this->compra->find($id);

       $preload['produtos'] = $this->produto->orderBy('titulo')->get()->pluck('titulo','id');
       return view('admin.compra.show',compact('params','data','preload'));
    }

    public function edit($id)
    {
        $this->params['subtitulo']='Editar Compra';
        $this->params['arvore']=[
           [
               'url' => 'admin/compra',
               'titulo' => 'Compra'
           ],
           [
               'url' => '',
               'titulo' => 'Editar'
           ]];
        $params = $this->params;

        $data = $this->compra->getCompra($id);


        // CASTING FOR DECIMAL NUMBERS
        $data['valor'] = str_replace('.', ',',$data['valor']);
        $data['valor_total'] =  str_replace('.', ',',$data['valor_total']);
        $data['acrescimo'] =  str_replace('.', ',',$data['acrescimo']);
        $data['desconto'] =  str_replace('.', ',',$data['desconto']);

        $preload['produtos'] = $this->produto->orderBy('titulo')->get()->pluck('titulo','id');
        return view('admin.compra.create',compact('params', 'data','preload'));
    }

    public function update(CompraUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        /*
            id, cpf_cnpj, nome_razaosocial, valor, acrescimo, desconto, valor_total, data_entrada, data_hora, cadastrado_por
            , deleted_at, created_at, updated_at
        */

        $dataForm  = $request->only('valor','acrescimo','desconto','valor_total','data_entrada','cpf_cnpj', 'nome_razaosocial');
        // CASTING FOR DECIMAL NUMBERS
        $dataForm['valor'] = (float) str_replace('.', ',', $dataForm['valor']);
        $dataForm['acrescimo'] = (float) str_replace('.', ',', $dataForm['acrescimo']);
        $dataForm['desconto'] = (float) str_replace('.', ',', $dataForm['desconto']);
        $dataForm['valor_total'] = (float) str_replace('.', ',', $dataForm['valor_total']);

        $update = $this->compra->find($id)->update($dataForm);
        if($update){
            if(! $this->baixarEstoqueCompra($id) ){
                return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao atualizar o estoque.']);
                DB::rollBack();
            }

            $delete = $this->compraiten->where('compra_id',$id)->delete();
            if($delete){
                $dataFormItens  = $request->only(['produto_id','quantidade','valor_unitario']);
                foreach($dataFormItens['produto_id'] as $i => $v ){
                    /*
                        id, compra_id, produto_id, quantidade, valor, created_at, updated_at
                    */
                    $data['compra_id'] = $id;
                    $data['produto_id'] = $dataFormItens['produto_id'][$i];
                    $data['quantidade'] = (float) str_replace('.', ',',$dataFormItens['quantidade'][$i]);
                    $data['valor'] = (float) str_replace('.', ',', $dataFormItens['valor_unitario'][$i]);
                    if(!$this->compraiten->create($data)){
                        return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
                        DB::rollBack();
                    }

                    if(! $this->estoque->atualizarEstoque($data['produto_id'],$data['quantidade'],1)){
                        return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao atualizar o estoque.']);
                        DB::rollBack();
                    }

                }
                DB::commit();
                return redirect()->route($this->params['main_route'].'.index');
            }else{
                DB::rollback();
                return back()->withErrors(['Falha ao atualizar itens do pedido.']);
            }

        }else{
            DB::rollback();
            return back()->withErrors(['Falha ao fazer Inserir.']);
        }

    }

    public function destroy($id)
    {
        DB::beginTransaction();
        $data = $this->compra->find($id);
        if(!$data->delete()){
            DB::rollback();
            return back()->withErrors(['Falha ao deletar.']);
        }

        if(! $this->baixarEstoqueCompra($id) ){
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao atualizar o estoque.']);
            DB::rollBack();
        }

        if(! $this->compraiten->where('compra_id',$id)->delete()){
            DB::rollback();
            return back()->withErrors(['Falha ao deletar.']);
        }
        DB::commit();
        return redirect()->route($this->params['main_route'].'.index');
    }

    public function getCompraById(Request $request)
    {
        $id = $request->only('id');
        $data = $this->compra->getCompra($id);

        return response()->json($data);
    }

    public function baixarEstoqueCompra($compra_id){
        $itens = $this->compraiten->select('produto_id','quantidade')->where('compra_id',$compra_id)->get();

        foreach($itens as $i => $v){
            if(! $this->estoque->atualizarEstoque($v['produto_id'],$v['quantidade'],0)){
                return false;
            }
        }
        return true;

    }

}
