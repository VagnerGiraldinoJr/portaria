<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    private $params = [];
    private $reserva = [];
    private $lote = [];


    public function __construct(Reserva $reservas, Lote $lotes)
    {
        $this->reserva = $reservas;
        $this->lote = $lotes;

        // DEFAULT VALUES
        $this->params['titulo'] = 'Reserva de áreas comuns';
        $this->params['main_route'] = 'admin.reserva';
    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastro de Reserva';
        $this->params['unidade_descricao'] = '';
        $this->params['arvore'][0] = [
            'url' => 'admin/reserva',
            'titulo' => 'Cadastro Reserva'
        ];

        // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        // Adicionar a descrição da unidade aos parâmetros
        $this->params['unidade_descricao'] = $descricaoUnidade;
        // Final do bloco da descricao

        $reservas = Reserva::where('unidade_id', Auth::user()->unidade_id)->get();
    
        $params = $this->params;
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();

        $data = $this->reserva
            ->with('lote')->where('unidade_id', Auth::user()->unidade_id)
            ->orderByRaw("CASE WHEN status = 'Pendente' THEN 1 ELSE 0 END DESC")
            ->orderByRaw('dt_entrega_chaves IS NULL DESC, dt_devolucao_chaves IS NULL DESC')
            ->get();


        foreach ($reservas as $reserva) {
            // Verifica se dt_entrega_chaves está preenchido e o status não é 'Confirmada'
            if (!empty($reserva->dt_entrega_chaves) && $reserva->status != 'Confirmada') {
                $reserva->status = 'Confirmada';
                $reserva->save();
            }

            // Verifica se dt_devolucao_chaves está preenchido e o status não é 'Encerrado'
            if (!empty($reserva->dt_devolucao_chaves) && $reserva->status != 'Encerrado') {
                $reserva->status = 'Encerrado';
                $reserva->save();
            }
        }

        return view('admin.reserva.index', compact('params', 'data', 'reservas'));
    }

    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastrar Reserva';
        $this->params['arvore'] = [
            [
                'url' => 'admin/reserva',
                'titulo' => 'Cadastro de Reserva'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]
        ];

        $params = $this->params;
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();

        $preload['lote_id'] = $this->lote->where('unidade_id', Auth::user()->unidade_id)
            ->orderByDesc('descricao') // Ordenar por descricao em ordem decrescente
            ->get()->pluck('descricao', 'id');

        return view('admin.reserva.create', compact('params', 'preload', 'lotes'));
    }

    public function store(Request $request)
    {


        // Validação dos dados
        $validatedData = $request->validate([
            'area' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'limpeza' => 'required|string',
            'status' => 'required|string',
            'acessorios' => 'required|string',
            'lote_id' => 'required|exists:lotes,id', // Valida que a lote_id existe na tabela lotes
            'celular_responsavel' => 'required|string'
        ]);

        // Verificação da existência de reserva com a mesma data e área
        $existingReserva = Reserva::where('data_inicio', $validatedData['data_inicio'])
            ->where('area', $validatedData['area'])
            ->first();

        if ($existingReserva) {
            return redirect()->back()->withErrors(['data_inicio' => 'Já existe uma reserva para esta área nesta data.']);
        }

        // Criação da reserva
        $reserva = new Reserva();
        $reserva->user_id = Auth::id(); // Adiciona o user_id do usuário autenticado
        $reserva->unidade_id = $validatedData['lote_id'];
        $reserva->area = $validatedData['area'];
        $reserva->data_inicio = $validatedData['data_inicio'];
        $reserva->limpeza = $validatedData['limpeza'];
        $reserva->status = $validatedData['status'];
        $reserva->acessorios = $validatedData['acessorios'];
        $celularResponsavel = $request->input('celular_responsavel');
        $celularLimpo = preg_replace('/[^0-9]/', '', $celularResponsavel);
        $reserva->celular_responsavel = $celularLimpo;
        $reserva->save();

        // Redireciona para a lista de reservas com uma mensagem de sucesso
        return redirect()->route('admin.reserva.index')->with('success', 'Reserva criada com sucesso');
    }

    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'area' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'limpeza' => 'required|string',
            'status' => 'required|string',
            'acessorios' => 'required|string',
            'celular_responsavel' => 'required|string|max:15',
            'dt_entrega_chaves' => 'required|date_format:d-m-Y H:i:s',
            'retirado_por' => 'required|string|max:255',
            'devolvido_por' => 'required|string|max:255',
            'dt_devolucao_chaves' => 'required|date_format:d-m-Y H:i:s',
        ]);
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();
        $reserva = Reserva::findOrFail($id);

        $reserva->area = $validatedData['area'];
        $reserva->data_inicio = $validatedData['data_inicio'];
        $reserva->limpeza = $validatedData['limpeza'];
        $reserva->status = $validatedData['status'];
        $reserva->acessorios = $validatedData['acessorios'];
        $celularResponsavel = $validatedData['celular_responsavel'];
        $celularLimpo = preg_replace('/[^0-9]/', '', $celularResponsavel);
        $reserva->celular_responsavel = $celularLimpo;

        $reserva->dt_entrega_chaves = \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $validatedData['dt_entrega_chaves']);
        $reserva->retirado_por = $validatedData['retirado_por'];
        $reserva->status = 'Confirmada'; // Atualiza o status para 'Confirmada' após entrega das chaves



        // Atualiza os campos dt_entrega_chaves e dt_devolucao_chaves se presentes no request
        if (isset($validatedData['dt_entrega_chaves'])) {
            $reserva->dt_entrega_chaves = $validatedData['dt_entrega_chaves'];
        }
        if (isset($validatedData['dt_devolucao_chaves'])) {
            $reserva->dt_devolucao_chaves = $validatedData['dt_devolucao_chaves'];
        }

        // Verifica e atualiza o status com base em dt_entrega_chaves e dt_devolucao_chaves
        if (!empty($reserva->dt_entrega_chaves)) {
            $reserva->status = 'Confirmada';
        }

        if (!empty($reserva->dt_devolucao_chaves)) {
            $reserva->status = 'Encerrado';
        }

        $reserva->save();

        return redirect()->route('admin.reserva.index')->with('success', 'Reserva atualizada com sucesso!');
    }


    public function showRetireForm($id)
    {

        $this->params['subtitulo'] = 'Entrega das Chaves da reserva';
        $this->params['arvore'] = [
            [
                'url' => 'admin/reserva',
                'titulo' => 'Lista Reserva'
            ],
            [
                'url' => '',
                'titulo' => 'Entregando as Chaves'
            ]
        ];
        $params = $this->params;
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();
        $reserva = Reserva::findOrFail($id);
        return view('admin.reserva.retire', compact('reserva', 'params'));
    }

    public function showReturnForm($id)
    {
        $this->params['subtitulo'] = 'Devolução das Chaves da reserva';
        $this->params['arvore'] = [
            [
                'url' => 'admin/reserva',
                'titulo' => 'Lista Reserva'
            ],
            [
                'url' => '',
                'titulo' => 'Devolução das Chaves'
            ]
        ];

        $params = $this->params;
        $reserva = Reserva::findOrFail($id);
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();

        return view('admin.reserva.return', compact('reserva', 'params'));
    }

    public function retire(Request $request, $id)
    {
        // Validar os dados do formulário
        $validatedData = $request->validate([
            'dt_entrega_chaves' => 'required|date_format:d-m-Y H:i:s',
            'retirado_por' => 'required|string|max:100',
        ]);
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();
        // Encontrar a reserva pelo ID
        $reserva = Reserva::findOrFail($id);

        // Atualizar os campos
        $reserva->dt_entrega_chaves = Carbon::createFromFormat('d-m-Y H:i:s', $validatedData['dt_entrega_chaves'])->toDateTimeString();
        $reserva->retirado_por = $validatedData['retirado_por'];

        // Atualiza o status para 'Confirmada' após entrega das chaves
        $reserva->status = 'Confirmada';

        // Salvar as alterações
        $reserva->save();

        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('admin.reserva.index')->with('success', 'Chaves da reserva foram retiradas e status atualizado para Confirmada.');
    }

    public function return(Request $request, $id)
    {
        // Validar os dados do formulário
        $validatedData = $request->validate([
            'dt_devolucao_chaves' => 'required|date_format:d-m-Y H:i:s',
            'devolvido_por' => 'required|string|max:100',
        ]);

        // Encontrar a reserva pelo ID
        $reserva = Reserva::findOrFail($id);
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();
        // Atualizar os campos
        $reserva->dt_devolucao_chaves = Carbon::createFromFormat('d-m-Y H:i:s', $validatedData['dt_devolucao_chaves'])->toDateTimeString();
        $reserva->devolvido_por = $validatedData['devolvido_por'];

        // Atualiza o status para 'Encerrado' após a devolução das chaves
        if (!empty($reserva->dt_entrega_chaves) && $reserva->status != 'Encerrado') {
            $reserva->status = 'Encerrado';
        }

        // Salvar as alterações
        $reserva->save();

        // Redirecionar com uma mensagem de sucesso
        return redirect()->route('admin.reserva.index')->with('success', 'Chaves devolvidas com sucesso e status atualizado, se necessário.');
    }

    public function updateReturn(Request $request, $id)
    {
        // Validação dos dados
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();
        $request->validate([
            'dt_devolucao_chaves' => 'required|date_format:d-m-Y H:i:s',
            'devolvido_por' => 'required|string|max:255',
        ]);


        try {
            // Encontrar a reserva pelo ID
            $reserva = Reserva::findOrFail($id);

            // Atualizar os campos necessários
            $reserva->dt_devolucao_chaves = \Carbon\Carbon::createFromFormat('d-m-Y H:i:s', $request->dt_devolucao_chaves)->format('Y-m-d H:i:s');
            $reserva->devolvido_por = $request->devolvido_por;
            // Salvar as alterações
            $reserva->save();

            // Redirecionar ou retornar uma resposta de sucesso
            return redirect()->route('admin.reserva.index')->with('success', 'Dados de devolução atualizados com sucesso.');
        } catch (\Exception $e) {
            // Tratar qualquer exceção aqui
            return back()->withErrors(['message' => 'Erro ao atualizar os dados de devolução.']);
        }
    }

    public function relatorio(Request $request)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Relatório ref. as reservas';
        $this->params['unidade_descricao'] = '';
        $this->params['arvore'][0] = [
            'url' => 'admin/reserva/relatorio',
            'titulo' => 'Relatório de Reservas'
        ];

        // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        // Adicionar a descrição da unidade aos parâmetros
        $this->params['unidade_descricao'] = $descricaoUnidade;
        // Final do bloco da descricao


        $params = $this->params;

        $query = Reserva::query();

        // Filtro obrigatório: unidade_id do usuário autenticado
        $query->where('unidade_id', Auth::user()->unidade_id);

        // Inicialize reserva como uma coleção vazia
        $reserva = collect();


        // Verifique se há filtros aplicados
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Execute a consulta sem paginação
        $reserva = $query->get();

        // Retorne a view com os dados filtrados
        return view('admin.reserva.relatorio', compact('params', 'reserva'));
    }
}
