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
    public function __construct(User $administradores,ControleAcesso $controleacessos,Produto $produtos, Orcamento $orcamentos, Pessoa $pessoas)
    {
        $this->administrador = $administradores;
        $this->controleacesso = $controleacessos;
        $this->produto = $produtos;
        $this->orcamento = $orcamentos;
        $this->pessoa = $pessoas;

        //$this->atendimento = $atendimentos;


        // Default values
        $this->params['titulo']='Bem Vindo';
        $this->params['main_route']='admin';

    }


    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo']='';

        $params = $this->params;
        $data['admin'] = $this->administrador->count();
        $data['controleacesso'] = $this->controleacesso->count();
        $data['EncomendasNaoEntregues'] = $this->controleacesso->whereNull('data_saida',NULL)->count();
    
        //$data['controleacesso'] = $this->controleacesso->whereisnotNull('data_saida',NULL)->count();
        $data['produto'] = $this->produto->count();
        $data['orcamento'] = $this->orcamento->count();
        $data['pedido'] = $this->orcamento->has('getPedido')->count();
        $data['pedido_producao'] = $this->orcamento->has('getStatusEmProducao')->count();
        $data['pedido_finalizado'] = $this->orcamento->has('getStatusEmProducao')->count();
        $data['pessoas'] = $this->pessoa->count();

        return view('admin.index',compact('params','data'));
    }

}