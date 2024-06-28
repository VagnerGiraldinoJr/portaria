<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    private $params = [];
    private $reserva;
    private $lote;

    public function __construct(Reserva $reservas, Lote $lotes)
    {
        $this->reserva = $reservas;
        $this->lote = $lotes;

        // DEFAULT VALUES
        $this->params['titulo'] = 'Reserva de áreas comuns';
        $this->params['main_route'] = 'admin.reserva';
    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastro de Reserva';
        $this->params['arvore'][0] = [
            'url' => 'admin/reserva',
            'titulo' => 'Cadastro Reserva'
        ];
        $params = $this->params;
        $data = $this->reserva->with('lote')->get();
        return view('admin.reserva.index', compact('params', 'data'));
    }

    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastrar Reserva';
        $this->params['arvore'] = [
            [
                'url' => 'admin/reserva',
                'titulo' => 'Cadastro de Reserva'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]
        ];

        $params = $this->params;
        $lotes = Lote::where('unidade_id', Auth::user()->unidade_id)->get();
        $preload['lote_id'] = $this->lote->where('unidade_id', Auth::user()->unidade_id)
            ->orderByDesc('descricao') // Ordenar por descricao em ordem decrescente
            ->get()->pluck('descricao', 'id');
        return view('admin.reserva.create', compact('params', 'preload', 'lotes'));
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
            'lote_id' => 'required|exists:lotes,id', // Valida que a lote_id existe na tabela lotes
            'celular_responsavel' => 'required|string'
        ]);

        // Criação da reserva
        $reserva = new Reserva();
        $reserva->user_id = Auth::id(); // Adiciona o user_id do usuário autenticado
        $reserva->unidade_id = $validatedData['lote_id'];
        $reserva->area = $validatedData['area'];
        $reserva->data_inicio = $validatedData['data_inicio'];
        $reserva->limpeza = $validatedData['limpeza'];
        $reserva->status = $validatedData['status'];
        $reserva->acessorios = $validatedData['acessorios'];       
        $celularResponsavel = $request->input('celular_responsavel');
        $celularLimpo = preg_replace('/[^0-9]/', '', $celularResponsavel);
        $reserva->celular_responsavel = $celularLimpo;
        $reserva->save();

        // Redireciona para a lista de reservas com uma mensagem de sucesso
        return redirect()->route('admin.reserva.index')->with('success', 'Reserva criada com sucesso');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'area' => 'required|string|max:255',
            'data_inicio' => 'required|date',
            'limpeza' => 'required|string',
            'status' => 'required|string',
            'acessorios' => 'required|string',
            'celular_responsavel' => 'required|string|max:15',
        ]);
    
        $reserva = Reserva::findOrFail($id);
    
        $reserva->area = $validatedData['area'];
        $reserva->data_inicio = $validatedData['data_inicio'];
        $reserva->limpeza = $validatedData['limpeza'];
        $reserva->status = $validatedData['status'];
        $reserva->acessorios = $validatedData['acessorios'];
        $celularResponsavel = $validatedData['celular_responsavel'];
        $celularLimpo = preg_replace('/[^0-9]/', '', $celularResponsavel);
        $reserva->celular_responsavel = $celularLimpo;
    
        $reserva->save();
    
        return redirect()->route('admin.reserva.index')->with('success', 'Reserva atualizada com sucesso!');
    }
    



    }
