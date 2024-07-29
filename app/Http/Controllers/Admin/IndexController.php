<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Orcamento;
use App\Models\Produto;
use App\Models\ControleAcesso;
use App\Models\Pessoa;
use App\Models\Lote;
use App\Models\Roles;
use App\Models\Reserva;
use App\Models\Role;
use App\Models\Visitante;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    private $administrador = [];
    private $controleacesso = [];
    private $produto = [];
    private $orcamento = [];
    private $params = [];
    private $visitante = [];
    private $reserva = [];
    private $pessoas = [];
    private $lotes = [];
    private $roles = [];

    public function __construct(User $administradores, ControleAcesso $controleacessos, Produto $produtos, Orcamento $orcamentos,
        Lote $lotes, Pessoa $pessoas, Visitante $visitantes, Reserva $reservas, Role $roles)
    {
        $this->administrador = $administradores;
        $this->controleacesso = $controleacessos;
        $this->produto = $produtos;
        $this->orcamento = $orcamentos;
        $this->visitante = $visitantes;
        $this->reserva = $reservas;
        $this->pessoas = $pessoas;
        $this->lotes = $lotes;
        $this->roles = $roles;

        // Default values
        $this->params['titulo']= 'Controle de Acesso da Portaria' ;
        $this->params['main_route'] = 'admin';
    }
    
    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = '';        
        $this->params['unidade_descricao']= 'admin' ;
        $unidadeId = Auth::user()->unidade_id;

        // Obter a descrição da unidade
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
            // Adicionar a descrição da unidade aos parâmetros
            $this->params['unidade_descricao'] = $descricaoUnidade;
                       
        $params = $this->params;
       
       
        $data['controleacesso'] = $this->controleacesso->where('unidade_id', $unidadeId)->count();
        $data['EncomendasNaoEntregues'] = $this->controleacesso->where('unidade_id', $unidadeId)->whereNull('data_saida')->count();
        $data['EncomendasEntregues'] = $this->controleacesso->where('unidade_id', $unidadeId)->whereNotNull('data_saida')->count();
        $data['produto'] = $this->produto->count();
        $data['orcamento'] = $this->orcamento->count();
        $data['pedido'] = $this->orcamento->has('getPedido')->count();
        $data['pedido_producao'] = $this->orcamento->has('getStatusEmProducao')->count();
        $data['pedido_finalizado'] = $this->orcamento->has('getStatusEmProducao')->count();
        $data['QuantidadesVisitantes'] = $this->visitante->where('unidade_id', $unidadeId)->whereNull('hora_de_saida')->count();
        $data['QuantidadesCadVisitantes'] = $this->visitante->where('unidade_id', $unidadeId)->count();
        $data['QuantidadesReservas'] = $this->reserva->where('unidade_id', $unidadeId)->whereNull('dt_entrega_chaves')->count();

        $dataresults = DB::table('pessoas')
            ->join('lotes', 'pessoas.lote_id', '=', 'lotes.id')
            ->join('unidades', 'lotes.unidade_id', '=', 'unidades.id')
            ->select(DB::raw('COUNT(pessoas.id) as total_pessoas'))
            ->where('lotes.unidade_id', $unidadeId)
            ->groupBy('unidades.id')
            ->first();

        $totalPessoas = $dataresults ? $dataresults->total_pessoas : 0;
      
        return view('admin.index', compact('params', 'data', 'totalPessoas'));
    }
}
