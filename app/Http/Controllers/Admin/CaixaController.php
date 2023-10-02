<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Caixa;
use App\Models\ContaCorrente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CaixaController extends Controller
{
    public function __construct(Caixa $caixas, ContaCorrente $conta_correntes)
    {
        $this->caixa = $caixas;
        $this->conta_corrente = $conta_correntes;

        // Default values
        $this->params['titulo']='Financeiro';
        $this->params['main_route']='admin.caixa';

    }

    public function index()
    {
        // PARAMS DEFAULT

        $this->params['subtitulo']='Movimento do Caixa';
        $this->params['arvore'][0] = [
                    'url' => 'admin/caixa',
                    'titulo' => 'Caixa'
        ];
        $params = $this->params;

        $caixa = $this->caixa->caixaAberto();
        
        $saldo = ($caixa) ? $this->caixa->saldoAtualCaixa($caixa->id) : null;
        
        $data = $this->caixa->ultimosCaixas();
        
        return view('admin.caixa.index',compact('params','caixa','data','saldo'));

    }

    public function abrir()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='Movimento do Caixa';
        $this->params['arvore'][0] = [
                    'url' => 'admin/caixa',
                    'titulo' => 'Caixa'
        ];

        $params = $this->params;
        $caixa =  $this->caixa->caixaAberto();
        if($caixa){
            return redirect()->route($this->params['main_route'])->withErrors(['Caixa já aberto anteriormente.']);
        }else{
            DB::beginTransaction();
            $dataForm['aberto_por'] =  Auth::user()->email;
            $insert = $this->caixa->create($dataForm);
            if($insert){
                
                $dataForm['operacao'] = 88;
                $dataForm['forma_pagamento'] = 88;
                $dataForm['valor'] = $this->conta_corrente->valorFechamentoCaixa($this->caixa->caixaAnterior($insert->id));
                $dataForm['caixa_id'] =  $insert->id;
                $dataForm['fechado_por'] = Auth::user()->email;
                $dataForm['data_fechamento'] = \Carbon\Carbon::now();

                // + FECHADO, DATA_FECHAMENTO, FECHADO 
                $insert = $this->conta_corrente->create($dataForm);
                if($insert){
                    DB::commit();
                    return redirect()->route($this->params['main_route']) ;
                }else{
                    //  DB::rollback();
                      return redirect()->route($this->params['main_route'])->withErrors(['Falha ao Abrir o caixa.']);
                }
      
            }else{
              //  DB::rollback();
                return redirect()->route($this->params['main_route'])->withErrors(['Falha ao Abrir o caixa.']);
            }

             
        }
    }

    public function fechar()
    {
         // PARAMS DEFAULT
         $this->params['subtitulo']='Movimento do Caixa';
         $this->params['arvore'][0] = [
                     'url' => 'admin/caixa',
                     'titulo' => 'Caixa'
         ];
 
         $params = $this->params;
         $caixa = $this->caixa->where('data_fechamento',NULL)->get()->first();
         if($caixa){
                DB::beginTransaction();

                $dataForm['fechado_por'] = Auth::user()->email;
                $dataForm['data_fechamento'] = \Carbon\Carbon::now();
                $update = $this->caixa->where('id', $caixa->id)->update($dataForm);
                if($update){
                    unset($dataForm['data_fechamento']);
                    $dataForm['fechado'] = 1 ;
                    
                    $update = $this->conta_corrente->where('caixa_id', $caixa->id)->update($dataForm);
                    if( $update !== NULL){
                        
                        $dataForm['operacao'] = 99;
                        $dataForm['forma_pagamento'] = 99;
                        $dataForm['valor'] = $this->caixa->saldoAtualCaixa($caixa->id);
                        $dataForm['caixa_id'] =  $caixa->id;
                        // + FECHADO, DATA_FECHAMENTO, FECHADO 
                        $insert = $this->conta_corrente->create($dataForm);
                        if($insert){
                    
                            DB::commit();
                            return redirect()->route($this->params['main_route']) ;
                        }else{
                            DB::rollback();
                            return redirect()->route($this->params['main_route'])->withErrors('Erro ao fechar o caixa.');
                        }
                    }else{
                        
                        DB::rollback();
                        return redirect()->route($this->params['main_route'])->withErrors('Erro ao fechar o caixa.');
                    }
                    
                }else{
                    
                    DB::rollback();
                    return redirect()->route($this->params['main_route'])->withErrors('Erro ao fechar o conta corrente.');
                }
        }else{
            
            return redirect()->route($this->params['main_route'])->withErrors('Caixa já fechado anteriormente.');
        }

    }

}
