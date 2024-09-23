<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservaPiscinaController extends Controller
{
    private $params = [];
    private $reserva = [];
    private $lote = [];

    public function __construct(Reserva $reservas, Lote $lotes)
    {
        $this->reserva = $reservas;
        $this->lote = $lotes;

        // DEFAULT VALUES
        $this->params['titulo'] = 'Reserva de Piscina';
        $this->params['main_route'] = 'admin.reserva.piscina';
    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastro de Reserva';
        $this->params['unidade_descricao'] = '';
        $this->params['arvore'][0] = [
            'url' => 'admin/reserva/piscina',
            'titulo' => 'Cadastro Reserva'
        ];

        // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;

        // Aplicar filtro de unidade_id
        $data = Reserva::where('unidade_id', $unidadeId)
            ->with('lote')
            ->where('unidade_id', $unidadeId)
            ->where('area', 'like', '%PISCINA%')
            ->orderBy('dt_entrega_chaves', 'desc')
            ->get();

        return view('admin.reserva.piscina.index', ['params' => $this->params, 'data' => $data]);
    }

    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastrar Reserva Piscina';
        $this->params['arvore'] = [
            [
                'url' => 'admin/reserva/create',
                'titulo' => 'Cadastro de Reserva Piscina'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]
        ];

        // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;

        $params = $this->params;
        $lotes = Lote::where('unidade_id', $unidadeId)->get();

        $preload['unidade_id'] = DB::table('lotes')
            ->where('unidade_id', $unidadeId)
            ->orderByDesc('descricao')
            ->get()->pluck('descricao', 'id');
        return view('admin.reserva.piscina.create', compact('params', 'preload', 'lotes'));
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
            'lote_id' => 'required|exists:lotes,id', // Valida que o lote_id existe na tabela lotes
            'celular_responsavel' => 'required|string'
        ]);

        $user_id = Auth::id();
        if (!$user_id) {
            return back()->withErrors(['user_id' => 'User ID is missing'])->withInput();
        }

        // Verificação da existência de reserva com a mesma data e área
        $existingReserva = Reserva::where('data_inicio', $validatedData['data_inicio'])
            ->where('area', $validatedData['area'])
            ->first();

        if ($existingReserva) {
            return redirect()->back()->withErrors(['data_inicio' => 'Já existe uma reserva para esta área nesta data.']);
        }

        // Criação da reserva
        $reserva = new Reserva();
        $reserva->user_id = $user_id; // Adiciona o user_id do usuário autenticado
        $reserva->unidade_id = Auth::user()->unidade_id; // Adiciona a unidade_id do usuário autenticado
        $reserva->lote_id = $validatedData['lote_id']; // Adiciona o lote_id do formulário
        $reserva->area = $validatedData['area'];
        $reserva->data_inicio = $validatedData['data_inicio'];
        $reserva->limpeza = $validatedData['limpeza'];
        $reserva->status = $validatedData['status'];
        $reserva->acessorios = $validatedData['acessorios'];
        $celularResponsavel = $request->input('celular_responsavel');
        $celularLimpo = preg_replace('/[^0-9]/', '', $celularResponsavel);
        $reserva->celular_responsavel = $celularLimpo;

        $reserva->save();

        return redirect()->route('admin.reserva.index')->with('success', 'Reserva criada com sucesso');
    }

    public function edit($id)
    {
        $reserva = Reserva::findOrFail($id);
        $lotes = Lote::all();
        $params = $this->params;
        return view('admin.reserva.edit', compact('reserva', 'lotes', 'params'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'area' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'limpeza' => 'required|string',
            'status' => 'required|string',
            'acessorios' => 'required|string',
            'celular_responsavel' => 'required|string|max:20',
            'dt_entrega_chaves' => 'nullable|date_format:Y-m-d H:i:s',
            'retirado_por' => 'nullable|string|max:100',
            'dt_devolucao_chaves' => 'nullable|date_format:Y-m-d H:i:s',
            'devolvido_por' => 'nullable|string|max:100',
        ]);

        $reserva = Reserva::where('unidade_id', Auth::user()->unidade_id)->findOrFail($id);

        $reserva->area = $validatedData['area'];
        $reserva->data_inicio = $validatedData['data_inicio'];
        $reserva->limpeza = $validatedData['limpeza'];
        $reserva->status = $validatedData['status'];
        $reserva->acessorios = $validatedData['acessorios'];
        $celularResponsavel = $validatedData['celular_responsavel'];
        $celularLimpo = preg_replace('/[^0-9]/', '', $celularResponsavel);
        $reserva->celular_responsavel = $celularLimpo;

        $reserva->save();

        return redirect()->route('admin.reserva.piscina.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $reserva = Reserva::where('unidade_id', Auth::user()->unidade_id)->findOrFail($id);
        $reserva->delete();

        return redirect()->route('admin.reserva.piscina.index')->with('success', 'Reserva removida com sucesso!');
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
        $reserva = Reserva::where('unidade_id', Auth::user()->unidade_id)->findOrFail($id);
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
        $reserva = Reserva::where('unidade_id', Auth::user()->unidade_id)->findOrFail($id);

        return view('admin.reserva.return', compact('reserva', 'params'));
    }

    public function retire(Request $request, $id)
    {
        // Validação da entrada
        $validatedData = $request->validate([
            'dt_entrega_chaves' => 'required|date_format:d-m-Y H:i:s',
            'retirado_por' => 'required|string|max:100',
        ]);

        // Encontrar a reserva
        $reserva = Reserva::where('unidade_id', Auth::user()->unidade_id)->findOrFail($id);

        // Converter data para o formato Y-m-d H:i:s
        $reserva->dt_entrega_chaves = Carbon::createFromFormat('d-m-Y H:i:s', $validatedData['dt_entrega_chaves'])->format('Y-m-d H:i:s');

        // Atualizar outros campos
        $reserva->retirado_por = $validatedData['retirado_por'];
        $reserva->status = 'Confirmada';
        $reserva->save();

        return redirect()->route('admin.reserva.piscina.index')->with('success', 'Chaves da reserva foram retiradas e status atualizado para Confirmada.');
    }

    public function return(Request $request, $id)
    {
        // Validação da entrada
        $validatedData = $request->validate([
            'dt_devolucao_chaves' => 'required|date_format:d-m-Y H:i:s',
            'devolvido_por' => 'required|string|max:100',
        ]);

        // Encontrar a reserva
        $reserva = Reserva::where('unidade_id', Auth::user()->unidade_id)->findOrFail($id);

        // Converter data para o formato Y-m-d H:i:s
        $reserva->dt_devolucao_chaves = Carbon::createFromFormat('d-m-Y H:i:s', $validatedData['dt_devolucao_chaves'])->format('Y-m-d H:i:s');
        $reserva->devolvido_por = $validatedData['devolvido_por'];

        // Atualizar o status se necessário
        if (!empty($reserva->dt_entrega_chaves) && $reserva->status != 'Encerrado') {
            $reserva->status = 'Encerrado';
        }

        // Salvar as alterações
        $reserva->save();

        return redirect()->route('admin.reserva.index')->with('success', 'Chaves devolvidas com sucesso e status atualizado, se necessário.');
    }

    public function updateReturn(Request $request, $id)
    {
        // Validação da entrada
        $validatedData = $request->validate([
            'dt_devolucao_chaves' => 'required|date_format:d-m-Y H:i:s',
            'devolvido_por' => 'required|string|max:255',
        ]);

        try {
            // Encontrar a reserva
            $reserva = Reserva::where('unidade_id', Auth::user()->unidade_id)->findOrFail($id);

            // Converter a data para o formato Y-m-d H:i:s
            $reserva->dt_devolucao_chaves = Carbon::createFromFormat('d-m-Y H:i:s', $validatedData['dt_devolucao_chaves'])->format('Y-m-d H:i:s');
            $reserva->devolvido_por = $validatedData['devolvido_por'];

            // Salvar as alterações
            $reserva->save();

            return redirect()->route('admin.reserva.piscina.index')->with('success', 'Dados de devolução atualizados com sucesso.');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Erro ao atualizar os dados de devolução.']);
        }
    }

    public function relatorio(Request $request)
    {
        $this->params['subtitulo'] = 'Relatório ref. as reservas';
        $this->params['unidade_descricao'] = '';
        $this->params['arvore'][0] = [
            'url' => 'admin/reserva/relatorio',
            'titulo' => 'Relatório de Reservas'
        ];

        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;

        $params = $this->params;

        $query = Reserva::with('lote')->where('unidade_id', $unidadeId);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $reserva = $query->get();

        return view('admin.reserva.relatorio', compact('params', 'reserva'));
    }
}
