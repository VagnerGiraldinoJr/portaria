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
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class ControleAcessoController extends Controller
{
    private $params = [];

    public function __construct()
    {
        $this->params['titulo'] = 'Controle de Acesso da Portaria';
        $this->params['main_route'] = 'admin.controleacesso';
    }

    public function index(Request $request)
    {
        $this->params['subtitulo'] = 'Controle de Acesso da Portaria';

        $this->params['unidade_descricao'] = Cache::remember(
            'unidade_descricao_' . Auth::user()->unidade_id,
            60,
            fn() => Auth::user()->unidade->titulo // Supondo que `unidade` é um relacionamento no modelo User
        );

        return view('admin.controleacesso.index', [
            'params' => $this->params,
        ]);
    }
    public function fetchData(Request $request)
    {
        $data = ControleAcesso::where('unidade_id', Auth::user()->unidade_id)
            ->with(['lote', 'veiculo'])
            ->orderByRaw('data_saida IS NULL DESC');

        return DataTables::eloquent($data)->toJson(); // Certifique-se de que isso está correto
    }
    public function create()
    {
        $this->params['subtitulo'] = 'Cadastrar Controle de Acessos';

        $preload = [
            'tipo' => TableCode::select('descricao')->where('pai', 5)->get(), // Supondo que 'select' retorna os códigos necessários
            'unidade' => Lote::where('unidade_id', Auth::user()->unidade_id)
                ->orderBy('id', 'asc')
                ->pluck('descricao', 'id'),
        ];

        return view('admin.controleacesso.create', [
            'params' => $this->params,
            'preload' => $preload,
        ]);
    }

    public function store(ControleAcessoRequest $request)
    {
        $dataForm = $request->validated();
        $dataForm['data_entrada'] = now();
        $dataForm['unidade_id'] = Auth::user()->unidade_id;

        $this->controle_acesso->create($dataForm);

        return redirect()->route($this->params['main_route'] . '.index');
    }

    public function show($id)
    {
        $this->params['subtitulo'] = 'Visualizar Controle de Acesso';

        $data = ControleAcesso::where('unidade_id', Auth::user()->unidade_id)
            ->with(['pessoa', 'veiculo'])
            ->findOrFail($id);

        return view('admin.controleacesso.show', [
            'params' => $this->params,
            'data' => $data,
        ]);
    }

    public function edit($id)
    {
        $this->params['subtitulo'] = 'Editar Controle de Acesso';

        $data = ControleAcesso::with(['pessoa', 'veiculo'])->findOrFail($id);

        $preload = [
            'tipo' => TableCode::select('descricao')->where('pai', 5)->get(),
        ];

        return view('admin.controleacesso.create', [
            'params' => $this->params,
            'data' => $data,
            'preload' => $preload,
        ]);
    }

    public function update(Request $request, $id)
    {
        $dataForm = $request->only([
            'tipo',
            'lote_id',
            'veiculo_id',
            'motorista',
            'motivo',
            'observacao',
            'data_entrada'
        ]);

        $dataForm['data_entrada'] = Carbon::parse($dataForm['data_entrada'])->format('Y-m-d H:i:s');

        ControleAcesso::where('id', $id)
            ->where('unidade_id', Auth::user()->unidade_id)
            ->update($dataForm);

        return redirect()->route($this->params['main_route'] . '.index');
    }

    public function exit($id)
    {
        $this->params['subtitulo'] = 'Marcar Saída';

        $data = ControleAcesso::findOrFail($id);

        $preload = [
            'tipo' => TableCode::select('descricao')->where('pai', 5)->get(),
        ];

        return view('admin.controleacesso.exit', [
            'params' => $this->params,
            'data' => $data,
            'preload' => $preload,
        ]);
    }

    public function updateexit(Request $request, $id)
    {
        $dataForm = $request->only('data_saida', 'retirado_por');
        $dataForm['data_saida'] = now();

        ControleAcesso::where('id', $id)
            ->where('unidade_id', Auth::user()->unidade_id)
            ->update($dataForm);

        return redirect()->route($this->params['main_route'] . '.index');
    }

    public function destroy($id)
    {
        $controleAcesso = ControleAcesso::findOrFail($id);
        $controleAcesso->delete();

        return redirect()->route($this->params['main_route'] . '.index');
    }

    public function relatorio(Request $request)
    {
        $this->params['subtitulo'] = 'Relatório de Controle de Acessos';

        $query = ControleAcesso::where('unidade_id', Auth::user()->unidade_id);

        if ($request->filled('data_entrada')) {
            $query->whereDate('data_entrada', '>=', $request->data_entrada);
        }

        if ($request->filled('data_saida')) {
            $query->whereDate('data_saida', '<=', $request->data_saida);
        }

        $controleAcessos = $query->paginate(15);

        return view('admin.controleacesso.relatorio', [
            'params' => $this->params,
            'controleAcessos' => $controleAcessos,
        ]);
    }
}
