<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Orcamento;
use App\Models\Produto;
use App\Models\ControleAcesso;
use App\Models\Pessoa;
use App\Models\Lote;
use App\Models\Visitante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

//use App\Models\Atendimento;

class IndexController extends Controller
{
    private $administrador = [];
    private $controleacesso = [];
    private $produto = [];
    private $orcamento = [];
    private $params = [];
    private $pessoa = [];
    private $visitante = [];
    private $lote = [];
    public function __construct(
        User $administradores,
        ControleAcesso $controleacessos,
        Produto $produtos, 
        Orcamento $orcamentos, 
        Lote $lotes,
        Pessoa $pessoas,
        Visitante $visitantes)
    {
        $this->administrador = $administradores;
        $this->controleacesso = $controleacessos;
        $this->produto = $produtos;
        $this->orcamento = $orcamentos;
        $this->pessoa = $pessoas;
        $this->lote = $lotes; 
        $this->visitante = $visitantes; 

        // Default values
        $this->params['titulo']='Indicadores - Portaria';
        $this->params['main_route']='admin';

    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='';      

        $params = $this->params;
        $data['admin'] = $this->administrador->where('unidade_id', Auth::user()->unidade_id)->count();
        $data['controleacesso'] = $this->controleacesso->where('unidade_id', Auth::user()->unidade_id)->count();
        $data['EncomendasNaoEntregues'] = $this->controleacesso->where('unidade_id', Auth::user()->unidade_id)->whereNull('data_saida')->count();
        $data['EncomendasEntregues'] = $this->controleacesso->where('unidade_id', Auth::user()->unidade_id)->whereNotNull('data_saida')->count();
        $data['produto'] = $this->produto->count();
        $data['orcamento'] = $this->orcamento->count();
        $data['pedido'] = $this->orcamento->has('getPedido')->count();
        $data['pedido_producao'] = $this->orcamento->has('getStatusEmProducao')->count();
        $data['pedido_finalizado'] = $this->orcamento->has('getStatusEmProducao')->count();
        $data['QuantidadesVisitantes'] = $this->visitante->where('unidade_id', Auth::user()->unidade_id)->whereNull('hora_de_saida')->count();
        $unidadeId = Auth::user()->unidade_id;

        $dataresults = DB::table('pessoas')
            ->join('lotes', 'pessoas.lote_id', '=', 'lotes.id')
            ->join('unidades', 'lotes.unidade_id', '=', 'unidades.id')
            ->select(DB::raw('COUNT(pessoas.id) as total_pessoas'))
            ->where('lotes.unidade_id', $unidadeId)
            ->groupBy('unidades.id')
            ->first();
    
        $totalPessoas = $dataresults ? $dataresults->total_pessoas : 0;
                 
      
        return view('admin.index',compact('params','data', 'totalPessoas'));
    }

}