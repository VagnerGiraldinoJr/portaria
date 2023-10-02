<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\TableCode;
use App\Http\Requests\Admin\Produto\ProdutoRequest;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class ProdutoController extends Controller
{   
    private $params = [];
    private $produto = [];

    public function __construct(Produto $produtos)
    {
        $this->produto = $produtos;

        // Default values
        $this->params['titulo']='Produto';
        $this->params['main_route']='admin.produto';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Produtos Cadastrados';
        $this->params['arvore'][0] = [
                    'url' => 'admin/produto',
                    'titulo' => 'Produtos'
        ];

        $params = $this->params;
        $data = DB::select('SELECT id, titulo, tipo, unidade_medida, controla_estoque,
                            f_desc_table_codes(3,tipo) as desc_tipo ,
                            f_desc_table_codes(4,unidade_medida) as desc_unidade_medida ,
                            f_desc_table_codes(1,controla_estoque) as desc_controla_estoque
                            FROM produtos
                            ORDER BY titulo');
        return view('admin.produto.index',compact('params','data'));
    }

    public function create(TableCode $codes)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Cadastrar Produto';
        $this->params['arvore']=[
           [
               'url' => 'admin/produto',
               'titulo' => 'Produto'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $preload['controla_estoque'] = $codes->select(1);
       $preload['tipo'] = $codes->select(3);
       $preload['unidade_medida'] = $codes->select(4);

       return view('admin.produto.create',compact('params','preload'));
    }

    public function store(ProdutoRequest $request)
    {
        $dataForm  = $request->all();

        $insert = $this->produto->create($dataForm);
        if($insert){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao fazer Inserir.']);
        }
    }

    public function show($id,TableCode $codes)
    {
        $this->params['subtitulo']='Deletar Produto';
        $this->params['arvore']=[
           [
               'url' => 'admin/produto',
               'titulo' => 'Produto'
           ],
           [
               'url' => '',
               'titulo' => 'Deletar'
           ]];
       $params = $this->params;

       $data = $this->produto->find($id);
       $preload['controla_estoque'] = $codes->select(1);
       $preload['tipo'] = $codes->select(3);
       $preload['unidade_medida'] = $codes->select(4);

       return view('admin.produto.show',compact('params','data','preload'));
    }

    public function edit($id,TableCode $codes)
    {
        $this->params['subtitulo']='Editar Produto';
        $this->params['arvore']=[
           [
               'url' => 'admin/produto',
               'titulo' => 'Produto'
           ],
           [
               'url' => '',
               'titulo' => 'Cadastrar'
           ]];
       $params = $this->params;
       $data = $this->produto->find($id);
       $preload['controla_estoque'] = $codes->select(1);
       $preload['tipo'] = $codes->select(3);
       $preload['unidade_medida'] = $codes->select(4);

       return view('admin.produto.create',compact('params', 'data','preload'));
    }

    public function update(ProdutoRequest $request, $id)
    {
        $data = $this->produto->find($id);

        $dataForm  = $request->all();

        if($data->update($dataForm)){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao editar.']);
        }
    }

    // public function destroy($id)
    // {
    //     $data = $this->produto->find($id);

    //     if($data->delete()){
    //         return redirect()->route($this->params['main_route'].'.index');
    //     }else{
    //         return redirect()->route($this->params['main_route'].'.create')->withErrors(['Falha ao deletar.']);
    //     }
    // }
}
