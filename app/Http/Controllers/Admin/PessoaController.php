<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pessoa\PessoaRequest;
use App\Models\Lote;
use App\Models\Pessoa;
use App\Models\TableCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PessoaController extends Controller
{

    private $params = [];

    private Pessoa $pessoa;
    private Lote $lote;
    public function __construct(Pessoa $pessoas, Lote $lotes)
    {

        $this->pessoa = $pessoas;
        $this->lote = $lotes;

        // Default values
        $this->params['titulo'] = 'Pessoas';
        $this->params['main_route'] = 'admin.pessoa';
    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastro de Pessoas';
        $this->params['arvore'][0] = [
            'url' => 'admin/pessoa ',
            'titulo' => 'Cadastro Pessoas'
        ];

        $params = $this->params;

        $data = $this->pessoa->with('lote')
            ->whereHas('lote', function ($query) {
                $query->where('unidade_id', Auth::user()->unidade_id);
            })->get();
        //Isso garante que o relacionamento com os lotes está sendo respeitado e que apenas as pessoas vinculadas a lotes da unidade do usuário serão carregadas.
        return view('admin.pessoa.index', compact('params', 'data'));
    }

    public function create(TableCode $codes)
    {
        $this->params['subtitulo'] = 'Cadastrar Pessoas';
        $this->params['arvore'] = [
            ['url' => 'admin/pessoa', 'titulo' => 'Cadastro de Pessoas'],
            ['url' => '', 'titulo' => 'Cadastrar']
        ];

        $params = $this->params;

        // Carregar os tipos e os lotes
        $preload['tipo'] = $codes->select(4);
        $preload['lote_id'] = $this->lote->where('unidade_id', Auth::user()->unidade_id)
            ->orderBy('descricao')
            ->pluck('descricao', 'id');

        $data = null; // Para evitar problemas se não houver dados a serem carregados

        

        return view('admin.pessoa.create', compact('params', 'preload', 'data'));
    }



    public function store(PessoaRequest $request)
    {
        // Obter todos os dados do request
        $dataForm = $request->all();

        // Validação adicional caso seja necessário
        $request->validate([
            'nome_completo' => 'required|string|max:191',
            'rg' => 'nullable|string|max:191',
            'celular' => 'nullable|string|max:15',
            'tipo' => 'required|string|max:191',
            'lote_id' => 'required|exists:lotes,id',
            'email' => 'nullable|email|max:191', // Valida o campo de e-mail
        ]);

        // Converter o campo 'nome_completo' para UPPERCASE
        if (isset($dataForm['nome_completo'])) {
            $dataForm['nome_completo'] = strtoupper($dataForm['nome_completo']);
        }

        // Inserir os dados no banco de dados
        try {
            $insert = $this->pessoa->create($dataForm);

            if ($insert) {
                return redirect()->route($this->params['main_route'] . '.index')
                    ->with('success', 'Cadastro realizado com sucesso!');
            }
        } catch (\Exception $e) {
            // Log do erro (opcional)
            Log::error('Erro ao cadastrar pessoa: ' . $e->getMessage());
            return redirect()->route($this->params['main_route'] . '.create')
                ->withErrors(['Erro ao cadastrar. Por favor, tente novamente.']);
        }
    }



    public function show($id, TableCode $codes)
    {
        $this->params['subtitulo'] = 'Deletar Pessoas';
        $this->params['arvore'] = [
            [
                'url' => 'admin/pessoa',
                'titulo' => 'Pessoas'
            ],
            [
                'url' => '',
                'titulo' => 'Editar'
            ]
        ];
        $params = $this->params;
        $data = $this->pessoa->with('lote')
            ->whereHas('lote', function ($query) {
                $query->where('unidade_id', Auth::user()->unidade_id);
            })->where('pessoas.id', $id)->first();

        $preload['lote_id'] = $this->lote->where('unidade_id', Auth::user()->unidade_id)
            ->orderByDesc('descricao') // Ordenar por data_inicio em ordem decrescente
            ->get()->pluck('descricao', 'id');

        $preload['tipo'] = $codes->select(4);

        return view('admin.pessoa.show', compact('params', 'data', 'preload'));
    }

    public function edit($id, TableCode $codes)
    {
        $this->params['subtitulo'] = 'Editar Cadastro Pessoas';
        $this->params['arvore'] = [
            [
                'url' => 'admin/pessoa',
                'titulo' => 'Pessoas'
            ],
            [
                'url' => '',
                'titulo' => 'Editar'
            ]
        ];
        $params = $this->params;

        $data = $this->pessoa->with('lote')
            ->whereHas('lote', function ($query) {
                $query->where('unidade_id', Auth::user()->unidade_id);
            })->where('pessoas.id', $id)->first();

        $preload['lote_id'] = $this->lote->where('unidade_id', Auth::user()->unidade_id)
            ->orderByDesc('descricao') // Ordenar por data_inicio em ordem decrescente
            ->get()->pluck('descricao', 'id');

        $preload['tipo'] = $codes->select(4);
        return view('admin.pessoa.create', compact('params', 'data', 'preload'));
    }


    public function update(Request $request, $id)
    {
        $dataForm  = $request->all();

        //ajustar no veículo
        $pessoa = $this->pessoa->join('lotes', 'lotes.id', '=', 'pessoas.lote_id')
            ->where('lotes.unidade_id', Auth::user()->unidade_id)
            ->where('pessoas.id', $id)->first();

        if (($pessoa != null) && $this->pessoa->find($id)->update($dataForm)) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {
        $pessoa = Pessoa::findOrFail($id);

        if ($pessoa->delete()) {
            return redirect()->route($this->params['main_route'] . '.index')->with('success', 'Morador excluído com sucesso!');
        }

        return redirect()->route($this->params['main_route'] . '.index')->withErrors(['Erro ao excluir o morador.']);
    }

    public function getPessoasByLote(Request $request)
    {
        $loteId = $request->input('lote_id');

        // Busca as pessoas do lote e inclui a classificação
        $pessoas = Pessoa::where('lote_id', $loteId)
            ->select('id', 'nome_completo', 'rg', 'celular', 'tipo') // Inclua 'tipo' para a classificação
            ->get();

        return response()->json($pessoas);
    }

    public function relatorio(Request $request)
    {
        // Captura os filtros opcionais enviados pela requisição (GET ou POST)
        $nome = $request->input('nome'); // Filtro opcional para o nome da pessoa
        $lote = $request->input('lote'); // Filtro opcional para o lote

        // Consulta com os filtros e relacionamentos
        $data = $this->pessoa->with([
            'lote' => function ($query) {
                $query->select('id', 'descricao', 'inadimplente', 'inadimplente_em', 'unidade_id') // Inclui unidade_id para carregar o relacionamento
                    ->with(['unidade' => function ($subQuery) {
                        $subQuery->select('id', 'titulo'); // Seleciona apenas os campos necessários da tabela unidades
                    }]);
            }
        ])
            ->select('id', 'nome_completo', 'rg', 'celular', 'tipo', 'lote_id') // Inclui os campos necessários da tabela pessoas
            ->when($nome, function ($query, $nome) {
                $query->where('nome_completo', 'like', '%' . $nome . '%');
            })
            ->when($lote, function ($query, $lote) {
                $query->whereHas('lote', function ($subQuery) use ($lote) {
                    $subQuery->where('descricao', 'like', '%' . $lote . '%');
                });
            })
            ->whereHas('lote', function ($query) {
                $query->where('unidade_id', Auth::user()->unidade_id);
            })
            ->get();

        // Retorna a view com os dados filtrados
        return view('admin.pessoa.relatorio', [
            'params' => $this->params, // Parâmetros adicionais (títulos, etc.)
            'pessoas' => $data // Dados filtrados para exibição no relatório
        ]);
    }
}
