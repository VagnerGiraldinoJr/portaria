<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Lote;
use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    private $params = [];
    private $reserva = [];
    private $lote = [];

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
            'url' => 'admin/reserva ',
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
        $preload['lote_id'] = $this->lote->where('unidade_id', Auth::user()->unidade_id)
            ->orderByDesc('descricao') // Ordenar por data_inicio em ordem decrescente
            ->get()->pluck('descricao', 'id');


        return view('admin.reserva.create', compact('params', 'preload'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'area' => 'required|string|max:255',
            'limpeza' => 'required|string',
        ]);

        $reserva = new Reserva();
        $reserva->user_id = auth()->id();
        $reserva->unidade_id = $request->lote_id;
        $reserva->area = $request->area;
        $reserva->data_inicio = $request->data_inicio;
        $reserva->limpeza = $request->limpeza;
        $reserva->status = $request->status;
        $reserva->acessorios = $request->acessorios;
        
        $reserva->save();

        return redirect()->route('admin.reserva.index')->with('success', 'Reserva criada com sucesso.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'area' => 'required',
            'data_inicio' => 'required|date_format:Y-m-d H:i:s',
            'data_fim' => 'required|date_format:Y-m-d H:i:s',
            'limpeza' => 'required',
            'status' => 'required',
            'acessorios' => 'required',
        ]);

        $reserva = Reserva::findOrFail($id);
        $reserva->update([
            'area' => $request->input('area'),
            'lote_id' => $request->input('lote_id'),
            'data_inicio' => $request->input('data_inicio'),
            'data_fim' => $request->input('data_fim'),
            'limpeza' => $request->input('limpeza'),
            'status' => $request->input('status'),
            'acessorios' => $request->input('acessorios')
        ]);
        //reserva 001
        return redirect()->route('admin.reserva.index')->with('success', 'Reserva atualizada com sucesso!');
    }
}
