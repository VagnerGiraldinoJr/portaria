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

    public function __construct(
        User $administradores,
        ControleAcesso $controleacessos,
        Produto $produtos,
        Orcamento $orcamentos,
        Lote $lotes,
        Pessoa $pessoas,
        Visitante $visitantes,
        Reserva $reservas,
        Role $roles
    ) {
        $this->administrador = $administradores;
        $this->controleacesso = $controleacessos;
        $this->produto = $produtos;
        $this->orcamento = $orcamentos;
        $this->visitante = $visitantes;
        $this->reserva = $reservas;
        $this->pessoas = $pessoas;
        $this->lotes = $lotes;
        $this->roles = $roles;

        $this->params['titulo'] = 'Controle de Acesso da Portaria';
        $this->params['main_route'] = 'admin';
    }

    public function index()
    {
        $this->params['subtitulo'] = '';
        $this->params['unidade_descricao'] = 'admin';
        $unidadeId = Auth::user()->unidade_id;

        // Obter a descrição da unidade
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;

        $params = $this->params;

        // Dados de Acesso
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

        // Total de Pessoas
        $dataresults = DB::table('pessoas')
            ->join('lotes', 'pessoas.lote_id', '=', 'lotes.id')
            ->join('unidades', 'lotes.unidade_id', '=', 'unidades.id')
            ->select(DB::raw('COUNT(pessoas.id) as total_pessoas'))
            ->where('lotes.unidade_id', $unidadeId)
            ->groupBy('unidades.id')
            ->first();

        $totalPessoas = $dataresults ? $dataresults->total_pessoas : 0;

        // 🔄 **Carregando Eventos, Reservas e Reservas Piscina para o Calendário**
        $eventos = DB::table('eventos')
            ->select('id', 'title', 'start', 'end', DB::raw("'evento' as type"), DB::raw("'Confirmada' as status"))
            ->where('unidade_id', $unidadeId)
            ->get();

        $reservas = DB::table('reservas')
            ->select('id', DB::raw("CONCAT('Reserva: ', area) as title"), 'data_inicio as start', 'data_inicio as end', DB::raw("'reserva' as type"), 'status')
            ->where('unidade_id', $unidadeId)
            ->where('area', 'not like', '%PISCINA%')
            ->get();

        $reservasPiscina = DB::table('reservas')
            ->select('id', DB::raw("CONCAT('Reserva Piscina: ', area) as title"), 'data_inicio as start', 'data_inicio as end', DB::raw("'reserva_piscina' as type"), 'status')
            ->where('unidade_id', $unidadeId)
            ->where('area', 'like', '%PISCINA%')
            ->get();

        $data['eventos'] = $eventos->merge($reservas)->merge($reservasPiscina)->map(function ($evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->title,
                'start' => $evento->start,
                'end' => $evento->end ?? $evento->start,
                'type' => $evento->type,
                'status' => $evento->status ?? 'Pendente',
            ];
        });

        $data['QuantidadesControleAcessoPorMes'] = DB::table('controle_acessos')
            ->select(DB::raw("DATE_FORMAT(data_entrada, '%Y-%m') as mes"), DB::raw('COUNT(*) as total_reservas'))
            ->where('unidade_id', Auth::user()->unidade_id)
            ->whereNotNull('data_entrada')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('admin.index', compact('params', 'data', 'totalPessoas'));
    }
}
