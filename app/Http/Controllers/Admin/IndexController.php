<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Orcamento;
use App\Models\Produto;
use Illuminate\Support\Facades\Response;

//use App\Models\Atendimento;

class IndexController extends Controller
{
    public function __construct(User $administradores,Cliente $clientes,Produto $produtos, Orcamento $orcamentos)
    {
        $this->administrador = $administradores;
        $this->cliente = $clientes;
        $this->produto = $produtos;
        $this->orcamento = $orcamentos;
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
        $data['cliente'] = $this->cliente->count();
        $data['produto'] = $this->produto->count();
        $data['orcamento'] = $this->orcamento->count();
        $data['pedido'] = $this->orcamento->has('getPedido')->count();
        $data['pedido_producao'] = $this->orcamento->has('getStatusEmProducao')->count();
        $data['pedido_finalizado'] = $this->orcamento->has('getStatusEmProducao')->count();
        // Criar Pedidos por status

        return view('admin.index',compact('params','data'));
    }

}
