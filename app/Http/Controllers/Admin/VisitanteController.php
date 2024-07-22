<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Unidade;
use App\Models\Visitante;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VisitanteController extends Controller
{
    private $params = [];
    private $visitante = [];

    public function __construct(Visitante $visitantes)
    {
        $this->visitante = $visitantes;

        // DEFAULT VALUES
        $this->params['titulo'] = 'Visitantes';
        $this->params['main_route'] = 'admin.visitante';
    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastro de Visitantes';
        $this->params['unidade_descricao']= '';
        $this->params['arvore'][0] = [
            'url' => 'admin/visitante ',
            'titulo' => 'Cadastro Visitantes'
        ];
        
        // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('lotes')
            ->where('unidade_id', $unidadeId)
            ->value('descricao');
            // Adicionar a descrição da unidade aos parâmetros
            $this->params['unidade_descricao'] = $descricaoUnidade;
        // Final do bloco da descricao

        
        $params = $this->params;
        $visitantes = Visitante::with('unidade', 'lote')->where('unidade_id', Auth::user()->unidade_id)->get();
        $resultados = Lote::with(['unidade.users'])->where('unidade_id', Auth::user()->unidade_id)->get();
        $data = $this->visitante->where('unidade_id', Auth::user()->unidade_id)->get();
       
        return view('admin.visitante.index', compact('resultados', 'visitantes', 'params', 'data'));
    }

    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastrar Visitante';
        $this->params['arvore'] = [
            [
                'url' => 'admin/visitante',
                'titulo' => 'Cadastro de Visitantes'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]
        ];

        $params = $this->params;
        $unidades = Unidade::all();
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();
        $data = $this->visitante->select('visitantes.*')->where('visitantes.unidade_id', Auth::user()->unidade_id)->get();

        return view('admin.visitante.create', compact('unidades', 'lotes', 'params'));
    }

    public function store(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'nome' => 'required|string|max:191',
            'documento' => 'required|string|max:191',
            'placa_do_veiculo' => 'required|string|max:191',
            'lote_id' => 'nullable|exists:lotes,id',
            'hora_de_entrada' => 'required|date_format:Y-m-d\TH:i',
            'motivo' => 'nullable|string',
        ]);

        $user_id = Auth::id();
        if (!$user_id) {
            return back()->withErrors(['user_id' => 'User ID is missing'])->withInput();
        }

        // Obtém o ID do lote a partir do formulário
        $lote_id = $request->lote_id;

        // Obtém o ID da unidade a partir do registro do lote
        $dataForm['unidade_id'] = Auth::user()->unidade_id;
        $unidade_id = Lote::find($lote_id)->unidade_id ?? null;


        // Cria um novo registro de visitante com os dados fornecidos e o ID do usuário logado
        $visitante = new Visitante([
            'nome' => $request->nome,
            'documento' => $request->documento,
            'placa_do_veiculo' => $request->placa_do_veiculo,
            'unidade_id' => $unidade_id,
            'lote_id' => $lote_id,
            'hora_de_entrada' => $request->hora_de_entrada,
            'user_id' => $user_id,
            'motivo' => $request->motivo,
        ]);

        $visitante->save();


        return redirect()->route('admin.visitante.index')->with('success', 'Entrada do Visitante criada com sucesso.');
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
        $data = $this->visitante->find($id);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
