<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ControleAcessosExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ControleAcesso\ControleAcessoRequest;
use App\Models\TableCode;
use App\Models\ControleAcesso;
use App\Models\Lote;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;


class ControleAcessoController extends Controller
{
    private $params = [];
    private $controle_acesso = [];
    private $lote;
    public function __construct(ControleAcesso $controle_acessos, Lote $lotes)
    {
        $this->controle_acesso = $controle_acessos;
        $this->lote = $lotes;
        // Default values
        $this->params['titulo'] = 'Controle de Acesso da Portaria';
        $this->params['main_route'] = 'admin.controleacesso';
    }

    public function index(Request $request)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Controle de Acesso da Portaria';
        $this->params['arvore'][0] = [
            'url' => 'admin/controleacesso',
            'titulo' => 'Controle de Acessos'
        ];
        $params = $this->params;

        // Dados atuais
        $data = $this->controle_acesso
            ->where('unidade_id', Auth::user()->unidade_id)
            ->with('lote')
            ->with('veiculo')
            ->orderByRaw('data_saida IS NULL DESC')
            ->get();

        return view('admin.controleacesso.index', compact('params', 'data'));
    }


    public function create(TableCode $codes)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastrar Controle de Acessos';
        $this->params['arvore'] = [
            [
                'url' => 'admin/controleacesso',
                'titulo' => 'Controle de Acesso'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]
        ];

        // preload          
        $preload['tipo'] = $codes->select(5);

        // Buscar os lotes (unidades) ordenados por descrição em ordem ascendente
        $preload['unidade'] = Lote::where('unidade_id', Auth::user()->unidade_id)
            ->orderBy('id', 'asc') // Ordenar por descrição em ordem ascendente
            ->pluck('descricao', 'id');

        $params = $this->params;

        return view('admin.controleacesso.create', compact('params', 'preload'));
    }

    public function store(ControleAcessoRequest $request)
    {
        $dataForm  = $request->all();
        // id, unidade_id, tipo, lote_id, veiculo_id, motorista, motivo, observacao, data_entrada, data_saida, created_at, updated_at

        $dataForm['data_entrada'] = Carbon::now()->format('Y-m-d H:i:s');
        $dataForm['unidade_id'] = Auth::user()->unidade_id;
        $insert = $this->controle_acesso->create($dataForm);
        if ($insert) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao fazer Inserir.']);
        }
    }
    public function show($id, TableCode $codes)
    {
        $this->params['subtitulo'] = 'Atualizar Controle de Acesso';
        $this->params['arvore'] = [
            [
                'url' => 'admin/controle_acessos',
                'titulo' => 'Controle de Acessos'
            ],
            [
                'url' => '',
                'titulo' => 'Editar'
            ]
        ];
        $params = $this->params;
        $data = $this->controle_acesso->with('pessoa')->with('veiculo')->find($id);
        $data = $this->controle_acesso->where('unidade_id', Auth::user()->unidade_id)->where('id', $id)->first();
        $preload['tipo'] = $codes->select(5);


        return view('admin.controleacesso.show', compact('params', 'data', 'preload'));
    }

    public function edit($id, TableCode $codes)
    {
        $this->params['subtitulo'] = 'Editar Controle de Acesso';
        $this->params['arvore'] = [
            [
                'url' => 'admin/controleacesso',
                'titulo' => 'Controles'
            ],
            [
                'url' => '',
                'titulo' => 'Editar'
            ]
        ];
        $params = $this->params;

        $data = $this->controle_acesso->with('pessoa')->with('veiculo')->find($id);

        $preload['tipo'] = $codes->select(5);
        return view('admin.controleacesso.create', compact('params', 'data', 'preload'));
    }

    public function exit($id, TableCode $codes)
    {
        $this->params['subtitulo'] = 'Editar Controle de Acesso';
        $this->params['arvore'] = [
            [
                'url' => 'admin/controleacesso',
                'titulo' => 'Controles'
            ],
            [
                'url' => '',
                'titulo' => 'Editar'
            ]
        ];
        $params = $this->params;

        $data = $this->controle_acesso->find($id);

        $preload['tipo'] = $codes->select(5);
        return view('admin.controleacesso.exit', compact('params', 'data', 'preload'));
    }

    public function update(Request $request, $id)
    {
        $dataForm  = $request->all();
        //Pull
        $dataForm['data_entrada'] = Carbon::parse($dataForm['data_entrada'])->format('Y-m-d H:i:s');

        if ($this->controle_acesso->find($id)->update($dataForm)) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao editar.']);
        }
    }


    public function updateexit(Request $request, $id)
    {
        $dataForm  = $request->only('data_saida', 'retirado_por');

        $dataForm['data_saida'] = Carbon::parse($dataForm['data_saida'])->format('Y-m-d H:i:s');

        if ($this->controle_acesso->find($id)->update($dataForm)) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {
        $data = $this->controle_acesso->find($id);

        if ($data->delete()) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao deletar.']);
        }
    }

    public function contador()
    {
        $data  = $this->controle_acesso('data_saida');
    }


    public function relatorio(Request $request)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Relatório de Controle de Acessos';
        $this->params['arvore'][0] = [
            'url' => 'admin/controleacesso/relatorio',
            'titulo' => 'Relatório de Controle de Acessos'
        ];
        $params = $this->params;

        // Relatorio
        $query = ControleAcesso::query();

        // Inicialize controleAcessos como uma coleção vazia
        $controleAcessos = collect();

        // Filtros do relatório
        if ($request->filled('unidade_id')) {
            $query->where('unidade_id', $request->unidade_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('data_entrada')) {
            $query->whereDate('data_entrada', $request->data_entrada);
        }

        if ($request->filled('data_saida')) {
            $query->whereDate('data_saida', $request->data_saida);
        }

        // Formate as datas usando Carbon
        $dataEntrada = $request->filled('data_entrada') ? Carbon::parse($request->data_entrada)->format('d/m/Y H:i:s') : '';
        $dataSaida = $request->filled('data_saida') ? Carbon::parse($request->data_saida)->format('d/m/Y H:i:s') : '';

        $controleAcessos = $query->where('unidade_id', Auth::user()->unidade_id)->get();
        // Adicione paginação
        $controleAcessos = $query->paginate(10);
        // Renderizar a view com os resultados do relatório
        return view('admin.controleacesso.relatorio', compact('params', 'controleAcessos', 'dataEntrada', 'dataSaida'));
    }
}
