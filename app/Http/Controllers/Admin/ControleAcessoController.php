<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ControleAcesso\ControleAcessoRequest;
use App\Models\TableCode;
use App\Models\ControleAcesso;
use App\Models\Lote;
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

    /**
     * Carrega os parâmetros padrão (como título e unidade).
     */
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

    /**
     * Lista todos os registros com cache.
     */
    public function index(Request $request)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Controle de Acesso da Portaria';
        $this->params['unidade_descricao'] = '';
        $this->params['arvore'][0] = [
            'url' => 'admin/controleacesso',
            'titulo' => 'Controle de Acessos'
        ];

        // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;

        $params = $this->params;

        // Adicionando cache com Redis
        $cacheKey = "controle_acessos_unidade_{$unidadeId}";
        Cache::forget($cacheKey);

        $data = $this->controle_acesso
            ->where('unidade_id', $unidadeId)
            ->with(['lote', 'veiculo'])
            ->get();

        return view('admin.controleacesso.index', compact('params', 'data'));
    }


    /**
     * Mostra a tela de criação.
     */
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

    /**
     * Salva um novo registro.
     */
    public function store(ControleAcessoRequest $request)
    {
        $dataForm = $request->validated();
        $dataForm['data_entrada'] = Carbon::now();
        $dataForm['unidade_id'] = Auth::user()->unidade_id;

        $this->controle_acesso->create($dataForm);

        // Limpar o cache para atualizar os registros
        Cache::forget("controle_acessos_unidade_" . Auth::user()->unidade_id);

        return redirect()->route($this->params['main_route'] . '.index');
    }

    /**
     * Mostra um registro específico.
     */
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

    /**
     * Mostra a tela de edição.
     */
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

    /**
     * Atualiza um registro.
     */
    public function update(Request $request, $id)
    {
        $dataForm = $request->validated();
        $dataForm['data_entrada'] = Carbon::parse($dataForm['data_entrada'])->format('Y-m-d H:i:s');

        $this->controle_acesso->findOrFail($id)->update($dataForm);

        Cache::forget("controle_acessos_unidade_" . Auth::user()->unidade_id);

        return redirect()->route($this->params['main_route'] . '.index');
    }

    /**
     * Exclui um registro.
     */
    public function destroy($id)
    {
        $this->controle_acesso->findOrFail($id)->delete();

        Cache::forget("controle_acessos_unidade_" . Auth::user()->unidade_id);

        return redirect()->route($this->params['main_route'] . '.index');
    }

    /**
     * Relatório de controle de acessos.
     */
    public function relatorio(Request $request)
    {
        $this->carregarParametrosPadrao();
        $this->params['subtitulo'] = 'Relatório de Controle de Acessos';

        $query = $this->controle_acesso
            ->where('unidade_id', Auth::user()->unidade_id);

        if ($request->filled('data_entrada')) {
            $query->whereDate('data_entrada', '>=', $request->input('data_entrada'));
        }

        if ($request->filled('data_saida')) {
            $query->whereDate('data_saida', '<=', $request->input('data_saida'));
        }

        $controleAcessos = $query->get();

        return view('admin.controleacesso.relatorio', [
            'params' => $this->params,
            'controleAcessos' => $controleAcessos,
        ]);
    }

    public function exit($id, TableCode $codes)
    {
        $this->params['subtitulo'] = 'Registrar Saída';
        $this->params['arvore'] = [
            [
                'url' => 'admin/controleacesso',
                'titulo' => 'Controles'
            ],
            [
                'url' => '',
                'titulo' => 'Registrar Saída'
            ]
        ];

        $params = $this->params;

        $data = $this->controle_acesso->findOrFail($id);

        $preload['tipo'] = $codes->select(5);

        return view('admin.controleacesso.exit', compact('params', 'data', 'preload'));
    }
    public function updateexit(Request $request, $id)
    {
        $dataForm = $request->only('data_saida', 'retirado_por');

        $dataForm['data_saida'] = Carbon::parse($dataForm['data_saida'])->format('Y-m-d H:i:s');

        $controleAcesso = $this->controle_acesso->findOrFail($id);

        if ($controleAcesso->update($dataForm)) {
            Cache::forget("controle_acessos_unidade_" . Auth::user()->unidade_id);

            return redirect()->route('admin.controleacesso.index')->with('success', 'Saída registrada com sucesso.');
        } else {
            return redirect()->route('admin.controleacesso.exit', $id)->withErrors(['Falha ao registrar a saída.']);
        }
    }
}
