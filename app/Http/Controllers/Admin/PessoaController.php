<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Pessoa\PessoaRequest;
use App\Models\Lote;
use App\Models\Pessoa;
use App\Models\TableCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PessoaController extends Controller
{

    private $params = [];
    private $lote = [];
    private $pessoa = [];
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
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastrar Pessoas';
        $this->params['arvore'] = [
            [
                'url' => 'admin/pessoa',
                'titulo' => 'Cadastro de Pessoas'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]
        ];
        $params = $this->params;
        $preload['tipo'] = $codes->select(4);
        $preload['lote_id'] = $this->lote->where('unidade_id', Auth::user()->unidade_id)
            ->orderBy('descricao')
            ->pluck('descricao', 'id');
        return view('admin.pessoa.create', compact('params', 'preload'));
    }

    public function store(PessoaRequest $request)
    {
        $dataForm  = $request->all();
        $insert = $this->pessoa->create($dataForm);

        if ($insert) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao fazer Inserir.']);
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
}
