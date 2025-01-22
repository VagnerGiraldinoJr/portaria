<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ControleAcesso\ControleAcessoRequest;
use App\Models\TableCode;
use App\Models\ControleAcesso;
use App\Models\Lote;
use App\Models\Pessoa; // Importar Pessoa para buscar moradores
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ControleAcessoController extends Controller
{
    private $params = [];
    private $controle_acesso;
    private $lote;

    public function __construct(ControleAcesso $controle_acessos, Lote $lotes)
    {
        $this->controle_acesso = $controle_acessos;
        $this->lote = $lotes;

        // Valores padrões dos parâmetros
        $this->params['titulo'] = 'Controle de Acesso da Portaria';
        $this->params['main_route'] = 'admin.controleacesso';
    }

    private function carregarParametrosPadrao()
    {
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')->where('id', $unidadeId)->value('titulo');

        $this->params['unidade_descricao'] = $descricaoUnidade;
        $this->params['subtitulo'] = 'Controle de Acesso da Portaria';
        $this->params['arvore'] = [
            ['url' => route($this->params['main_route'] . '.index'), 'titulo' => 'Controle de Acessos']
        ];
    }

    public function index(Request $request)
    {
        $this->params['subtitulo'] = 'Controle de Acesso da Portaria';
        $this->params['unidade_descricao'] = '';
        $this->params['arvore'][0] = [
            'url' => 'admin/controleacesso',
            'titulo' => 'Controle de Acessos'
        ];

        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;

        $params = $this->params;

        $cacheKey = "controle_acessos_unidade_{$unidadeId}";
        Cache::forget($cacheKey);

        $data = $this->controle_acesso
            ->where('unidade_id', $unidadeId)
            ->with(['lote', 'veiculo'])
            ->get();

        return view('admin.controleacesso.index', compact('params', 'data'));
    }

    public function create(TableCode $codes)
    {
        $this->carregarParametrosPadrao();
        $this->params['subtitulo'] = 'Cadastrar Controle de Acessos';

        $preload = [
            'tipo' => $codes->select(5),
            'unidade' => $this->lote->where('unidade_id', Auth::user()->unidade_id)
                ->orderBy('id', 'asc')
                ->pluck('descricao', 'id')
        ];

        return view('admin.controleacesso.create', [
            'params' => $this->params,
            'preload' => $preload,
        ]);
    }

    public function store(ControleAcessoRequest $request)
    {
        $dataForm = $request->all();
        $dataForm['data_entrada'] = Carbon::now();
        $dataForm['unidade_id'] = Auth::user()->unidade_id;

        $this->controle_acesso->create($dataForm);

        Cache::forget("controle_acessos_unidade_" . Auth::user()->unidade_id);

        return redirect()->route($this->params['main_route'] . '.index')->with('success', 'Controle de acesso criado com sucesso.');
    }

    public function show($id)
    {
        $this->carregarParametrosPadrao();
        $this->params['subtitulo'] = 'Visualizar Controle de Acesso';

        $data = $this->controle_acesso
            ->where('unidade_id', Auth::user()->unidade_id)
            ->with(['veiculo', 'lote'])
            ->findOrFail($id);

        return view('admin.controleacesso.show', [
            'params' => $this->params,
            'data' => $data,
        ]);
    }

    public function edit($id, TableCode $codes)
    {
        $this->carregarParametrosPadrao();
        $this->params['subtitulo'] = 'Editar Controle de Acesso';

        $data = $this->controle_acesso->with(['lote', 'veiculo'])->findOrFail($id);

        $preload = [
            'tipo' => $codes->select(5),
        ];

        return view('admin.controleacesso.create', [
            'params' => $this->params,
            'data' => $data,
            'preload' => $preload,
        ]);
    }

    public function update(Request $request, $id)
    {
        $dataForm = $request->all();
        $dataForm['data_entrada'] = Carbon::parse($dataForm['data_entrada'])->format('Y-m-d H:i:s');

        $this->controle_acesso->findOrFail($id)->update($dataForm);

        Cache::forget("controle_acessos_unidade_" . Auth::user()->unidade_id);

        return redirect()->route($this->params['main_route'] . '.index')->with('success', 'Controle de acesso atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $this->controle_acesso->findOrFail($id)->delete();

        Cache::forget("controle_acessos_unidade_" . Auth::user()->unidade_id);

        return redirect()->route($this->params['main_route'] . '.index')->with('success', 'Controle de acesso excluído com sucesso.');
    }


    public function registrarSaida($id, TableCode $codes)
    {
        $this->params['subtitulo'] = 'Registrar Saída';
        $this->params['arvore'] = [
            ['url' => 'admin/controleacesso', 'titulo' => 'Controles'],
            ['url' => '', 'titulo' => 'Registrar Saída']
        ];

        $params = $this->params;

        $data = $this->controle_acesso->findOrFail($id);

        $preload['tipo'] = $codes->select(5);

        return view('admin.controleacesso.exit', compact('params', 'data', 'preload'));
    }

    /**
     * Endpoint para buscar moradores de um lote
     */
    public function getMoradoresByLote(Request $request)
    {
        $loteId = $request->input('lote_id');

        // Busca os moradores associados ao lote
        $moradores = Pessoa::where('lote_id', $loteId)->get(['id', 'nome_completo']);

        return response()->json($moradores);
    }

    public function getMoradorDetalhes(Request $request)
    {
        $moradorId = $request->input('morador_id');

        // Busca os dados do morador pelo ID
        $morador = Pessoa::find($moradorId);

        if ($morador) {
            return response()->json([
                'id' => $morador->id,
                'nome_completo' => $morador->nome_completo,
                'rg' => $morador->rg,
            ]);
        }

        return response()->json(null, 404);
    }

    public function exit($id)
    {
        $this->carregarParametrosPadrao();

        $data = $this->controle_acesso->findOrFail($id);

        return view('admin.controleacesso.exit', [
            'params' => $this->params,
            'data' => $data,
        ]);
    }

    public function updateexit(Request $request, $id)
{
    $dataForm = $request->all();
    $dataForm['data_saida'] = Carbon::now();

    $this->controle_acesso->findOrFail($id)->update($dataForm);

    Cache::forget("controle_acessos_unidade_" . Auth::user()->unidade_id);

    return redirect()->route($this->params['main_route'] . '.index')->with('success', 'Saída registrada com sucesso.');
}

}
