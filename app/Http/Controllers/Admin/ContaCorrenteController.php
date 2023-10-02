<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ContaCorrente\EntradaRequest;
use App\Http\Requests\Admin\ContaCorrente\ExtornoRequest;
use App\Http\Requests\Admin\ContaCorrente\SaidaRequest;
use App\Models\Caixa;
use App\Models\ContaCorrente;
use App\Models\Orcamento;
use App\Models\TableCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContaCorrenteController extends Controller
{
    public function __construct(ContaCorrente $conta_correntes, Orcamento $orcamentos, Caixa $caixas)
    {
        // Default values
        $this->params['titulo']='Financeiro';
        $this->params['main_route']='admin.conta_corrente';
        $this->conta_corrente = $conta_correntes;
        $this->orcamento = $orcamentos;
        $this->caixa = $caixas;
    }


    public function index(Request $request)
    {
        // PARAMS DEFAULT

        $this->params['subtitulo']='Movimento da Conta Corrente';
        $this->params['arvore'][0] = [
                    'url' => 'admin/contacorrente',
                    'titulo' => 'Conta Corrente'
        ];
        $params = $this->params;

        $searchFields = $request->only('data_inicio','data_fim');
        $searchFields['data_inicio']= (isset($searchFields['data_inicio']) && $searchFields['data_inicio'] !== null )?$searchFields['data_inicio']:\Carbon\Carbon::now()->toDateString();
        $searchFields['data_fim']= (isset($searchFields['data_fim']) && $searchFields['data_fim'] !== null )?$searchFields['data_fim']:\Carbon\Carbon::now()->toDateString();

        $data = $this->conta_corrente->getEntradaSaidaIntervalo($searchFields['data_inicio'],$searchFields['data_fim'],30);
        return view('admin.conta_corrente.index',compact('params','data','searchFields'));

    }


    public function entradas(TableCode $codes)
    {
        // PARAMS DEFAULT

        $this->params['subtitulo']='Registrar Entrada';
        $this->params['arvore'][0] = [
                    'url' => 'admin/entradas',
                    'titulo' => 'Financeiro'
        ];
        $params = $this->params;

        $preload['formas_pagamento'] = $codes->select(5)->toArray();
        $preload['referencia'] = $codes->select(8,0)->toArray();
        $preload['caixa'] = $this->caixa->where('data_fechamento',NULL)->get()->first();

       
        //dd($preload['referencia']);

        return view('admin.entrada.index',compact('params','preload'));

    }

    public function saidas(TableCode $codes)
    {
        // PARAMS DEFAULT


        $this->params['subtitulo']='Registrar Saídas';
        $this->params['arvore'][0] = [
                    'url' => 'admin/saidas',
                    'titulo' => 'Financeiro'
        ];
        $params = $this->params;

        $preload['formas_pagamento'] = $codes->select(5)->toArray();
        $preload['referencia'] = $codes->select(8,1)->toArray();
        $preload['caixa'] = $this->caixa->where('data_fechamento',NULL)->get()->first();

        //dd($preload['referencia']);

        return view('admin.saida.index',compact('params','preload'));

    }

    public function registrarEntrada(EntradaRequest $request)
    {
        $dataForm = $request->all();
        
        $caixa = $this->caixa->where('data_fechamento',NULL)->get()->first();
        if($caixa){

            // id, valor, operacao, forma_pagamento, data_hora, cadastrado_por, referencia, pedido_id, extornado, motivo_extorno, deleted_at, created_at, updated_at
            // CASTING FOR DECIMAL NUMBERS
            $dataForm['valor'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['valor']));

            if($dataForm['pedido'] > 0 && $dataForm['tipo_referencia'] == 1 ){
                $dataForm['referencia'] = "*** PEDIDO Nº: ".$dataForm['pedido']." ***";
            }
            $dataForm['valor'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['valor']));

            
            $dataForm['caixa_id'] = $caixa->id;
            $dataForm['cadastrado_por'] = Auth::user()->email;
            $dataForm['data_hora'] = \Carbon\Carbon::now()->setTimezone('America/Sao_Paulo');

            $insert = $this->conta_corrente->create($dataForm);
            if($insert){
                return redirect()->route($this->params['main_route'].'.entradas')->with('jsAlert','Entrada Inserida com sucesso');
            }else{
                return redirect()->route($this->params['main_route'].'.entradas')->withErrors(['Falha ao fazer Inserir.']);
            }
        }else{
            return redirect()->route($this->params['main_route'].'.entradas')->withErrors(['Nenhum caixa aberto no momento.']);
        }
    }

    public function registrarSaida(SaidaRequest $request)
    {
        $dataForm = $request->all();

        
        $caixa = $this->caixa->where('data_fechamento',NULL)->get()->first();
       
        if($caixa){
            // id, valor, operacao, forma_pagamento, data_hora, cadastrado_por, referencia, pedido_id, extornado, motivo_extorno, deleted_at, created_at, updated_at
            // CASTING FOR DECIMAL NUMBERS
            $dataForm['caixa_id'] = $caixa->id;
            $dataForm['valor'] = (float) str_replace(',', '.',str_replace('.', '', $dataForm['valor']));
            $dataForm['cadastrado_por'] = Auth::user()->email;
            $dataForm['data_hora'] = \Carbon\Carbon::now()->setTimezone('America/Sao_Paulo');
            try {
                //code...
                $insert = $this->conta_corrente->create($dataForm);
            } catch (\Exception $e) {
                //throw $th;
                dd($e);
            }
            
           
            
            if($insert){
               
                return redirect()->route($this->params['main_route'].'.saidas')->with('jsAlert','Saida Inserida com sucesso');
            }else{
                return redirect()->route($this->params['main_route'].'.saidas')->withErrors(['Falha ao fazer Inserir.']);
            }
        }else{
            return redirect()->route($this->params['main_route'].'.saidas')->withErrors(['Nenhum caixa aberto no momento.']);
        }
    }

    public function getPedido($id)
    {
        return response()->json($this->orcamento->getOrcamentoClienteValor($id));
    }

    public function show($id, TableCode $codes)
    {

        
        $this->params['subtitulo']='Lançamento Conta Corrente';
        $this->params['arvore'][0] = [
                    'url' => 'admin/contacorrente',
                    'titulo' => 'Conta Corrente'
        ];
       $params = $this->params;

       $data = $this->conta_corrente->find($id);
       $data['desc_extornado'] = $codes->getDescricaoById(1,$data['extornado']);

       $preload['formas_pagamento'] = $codes->select(5)->toArray();
       $preload['operacao'] = $codes->select(7,1)->toArray();
       
     
       return view('admin.conta_corrente.show',compact('params','data','preload'));
    }


    public function extornar(ExtornoRequest $request,$id)
    {
        $data = $this->conta_corrente->find($id);
        
        $dataForm  = $request->only(['motivo_extorno']);
        $dataForm['extornado'] = 1;
      
        if($data->update($dataForm)){
            return redirect()->route($this->params['main_route'].'.index');
        }else{
            return redirect()->route($this->params['main_route'].'.index')->withErrors(['Falha ao extornar registro.']);
        }

        
    }
}
