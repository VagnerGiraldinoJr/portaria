<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Unidade;
use App\Models\Visitante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class VisitanteController extends Controller
{
    private $params = [];
    private Visitante $visitante;

    /**
     * Construtor do VisitanteController
     *
     * @param Visitante $visitantes Instância do modelo Visitante
     */
    public function __construct(Visitante $visitantes)
    {
        $this->visitante = $visitantes;

        // DEFAULT VALUES
        $this->params['titulo'] = 'Visitantes';
        $this->params['main_route'] = 'admin.visitante';
    }

    public function index()
    {
        // Definir os parâmetros padrão
        $this->params['subtitulo'] = 'Cadastro de Visitantes';
        $this->params['arvore'][0] = [
            'url' => 'admin/visitante',
            'titulo' => 'Cadastro Visitantes',
        ];

        // Obter a descrição da unidade com base no usuário logado
        $this->params['unidade_descricao'] = Unidade::where('id', Auth::user()->unidade_id)->value('titulo');

        $params = $this->params;

        // Buscar visitantes apenas da unidade logada
        $visitantes = Visitante::with(['lote', 'unidade'])
            ->where('unidade_id', Auth::user()->unidade_id) // Filtra pela unidade do usuário logado
            ->orderByRaw('hora_de_saida IS NULL DESC') // Registros sem saída primeiro
            ->orderByDesc('created_at') // Ordena por data de criação decrescente
            ->get();

        return view('admin.visitante.index', compact('visitantes', 'params'));
    }

    public function create()
    {
        // Definir os parâmetros padrão
        $this->params['subtitulo'] = 'Cadastrar Visitante';
        $this->params['arvore'] = [
            ['url' => 'admin/visitante', 'titulo' => 'Cadastro de Visitantes'],
            ['url' => '', 'titulo' => 'Cadastrar']
        ];

        $params = $this->params;

        // Buscar os lotes da unidade do usuário logado
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)
            ->pluck('descricao', 'id'); // Retorna um array com ID como chave e descrição como valor

        return view('admin.visitante.create', compact('params', 'lotes'));
    }

    public function edit($id)
    {
        $visitante = Visitante::findOrFail($id);

        $params = [
            'titulo' => 'Editar Visitante',
            'subtitulo' => 'Atualizar informações do visitante',
        ];

        return view('admin.visitante.create', compact('params', 'visitante'));
    }


    public function store(Request $request)
    {
        // Validação dos dados
        $validatedData = $request->validate([
            'nome' => 'required|string|max:191',
            'documento' => 'required|string|max:191',
            'placa_do_veiculo' => 'nullable|string|max:191',
            'lote_id' => 'required|exists:lotes,id', // Garantir que lote_id seja obrigatório e válido
            'hora_de_entrada' => 'required|date_format:Y-m-d\TH:i',
            'motivo' => 'nullable|string|max:255',
            'celular' => 'nullable|string|max:15',
        ]);

        // Obtém o lote e valida que pertence à unidade do usuário logado
        $lote = Lote::find($validatedData['lote_id']);
        if (!$lote || $lote->unidade_id !== Auth::user()->unidade_id) {
            return back()->withErrors(['lote_id' => 'O lote selecionado não pertence à sua unidade.'])->withInput();
        }

        // Criar visitante diretamente usando `create()`
        Visitante::create([
            'nome' => strtoupper($validatedData['nome']), // Converter nome para maiúsculas
            'documento' => $validatedData['documento'],
            'placa_do_veiculo' => $validatedData['placa_do_veiculo'] ?? null,
            'unidade_id' => Auth::user()->unidade_id, // Garantir que seja a unidade do usuário logado
            'lote_id' => $validatedData['lote_id'],
            'hora_de_entrada' => $validatedData['hora_de_entrada'],
            'user_id' => Auth::id(),
            'motivo' => $validatedData['motivo'] ?? null,
            'celular' => $validatedData['celular'] ?? null,
        ]);

        return redirect()->route('admin.visitante.index')->with('success', 'Entrada do visitante criada com sucesso.');
    }



    public function exit($id)
    {

        // Definir subtítulo e árvore de navegação
        $this->params['subtitulo'] = 'Editar Saída Visitante';
        $this->params['arvore'] = [
            [
                'url' => 'admin/visitante',
                'titulo' => 'Controles'
            ],
            [
                'url' => '',
                'titulo' => 'Editar'
            ]
        ];

        $params = $this->params;
        $data = Visitante::find($id);

        // Verificar se o visitante foi encontrado
        if ($data) {
            // Verificar se a hora de saída não está definida
            if (is_null($data->hora_de_saida)) {
                // Atualizar a hora de saída com a hora atual
                $data->hora_de_saida = now();
                $data->save();

                // Redirecionar para a lista de visitantes com uma mensagem de sucesso
                return redirect()->route('admin.visitante.index')->with('success', 'Hora de saída registrada com sucesso.');
            } else {
                // Redirecionar com uma mensagem de erro se a hora de saída já estiver registrada
                return redirect()->route('admin.visitante.index')->with('error', 'Hora de saída já registrada.');
            }
        } else {
            // Redirecionar com uma mensagem de erro se o visitante não for encontrado
            return redirect()->route('admin.visitante.index')->with('error', 'Visitante não encontrado.');
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:191',
            'documento' => 'nullable|string|max:191',
            'placa_do_veiculo' => 'nullable|string|max:10',
            'unidade_id' => 'required|exists:unidades,id',
            'lote_id' => 'nullable|exists:lotes,id',
            'motivo' => 'nullable|string|max:191',
            'celular' => 'nullable|string|max:15', // Adicionando a validação do celular
        ]);

        $visitante = Visitante::findOrFail($id);
        $visitante->nome = strtoupper($request->input('nome'));
        $visitante->documento = $request->input('documento');
        $visitante->placa_do_veiculo = $request->input('placa_do_veiculo');
        $visitante->unidade_id = $request->input('unidade_id');
        $visitante->lote_id = $request->input('lote_id');
        $visitante->motivo = $request->input('motivo');
        $visitante->celular = $request->input('celular'); // Atualizando o celular
        $visitante->save();

        return redirect()->route('admin.visitante.index')->with('success', 'Visitante atualizado com sucesso!');
    }


    public function updateexit(Request $request, $id)
    {
        $dataForm  = $request->only('hora_de_saida');

        $dataForm['hora_de_saida'] = Carbon::parse($dataForm['hora_de_saida'])->format('Y-m-d H:i:s');
        dd($dataForm);

        if ($this->visitante->find($id)->update($dataForm)) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao editar.']);
        }
    }
}
