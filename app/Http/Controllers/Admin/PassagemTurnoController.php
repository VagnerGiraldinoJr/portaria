<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\PassagemTurno;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PassagemTurnoController extends Controller
{
    private $params = [];
    private $unidade = [];
    private $lote = [];


    public function __construct(Unidade $unidades)
    {

        $params = $this->params;
        $this->unidade = $unidades;
        // Default values
        $this->params['titulo'] = 'Passagem de Turno';
        $this->params['main_route'] = 'admin.passagem_turno';
    }

    public function index()
    {
        $params = $this->params;
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Registro Passagem de Turno';
        $this->params['unidade_descricao'] = '';
        $this->params['arvore'][0] = [
            'url' => 'admin/passagem_turno',
            'titulo' => 'Registrar Passagem de Turno'
        ];

        // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;

        // Aplicar filtro de unidade_id
        $passagens = PassagemTurno::with('user', 'unidade')->get();

        return view('admin.passagem_turno.index', ['params' => $this->params]);
    }

    public function create()
    {

        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Registro Passagem de Turno';
        $this->params['arvore'] = [
            [
                'url' => 'admin/passagem_turno',
                'titulo' => 'Registrar Passagem de Turno'
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

        $unidades = auth()->user()->unidade;


        return view('admin.passagem_turno.create', compact('params', 'lotes', 'unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unidade_id' => 'required|exists:unidades,id',
            'inicio_turno' => 'required|date',
            'fim_turno' => 'required|date',
            'itens' => 'required|array',
            'ocorrencias' => 'nullable|string',
        ]);

        PassagemTurno::create([
            'user_id' => auth()->id(), //ID do usuário autenticado
            'unidade_id' => $request->input('unidade_id'),
            'inicio_turno' => $request->input('inicio_turno'),
            'fim_turno' => $request->input('itens'),
            'ocorrencias' => $request->input('ocorrencias'),
        ]);

        return redirect()->route('passagem_turno.index')
            ->with('success', 'passagem de turno registrado com sucesso!!!');
    }
}
