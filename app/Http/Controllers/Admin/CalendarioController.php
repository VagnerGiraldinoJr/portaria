<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    private $params = [];

    public function __construct()
    {
        $this->params['titulo'] = 'Calendário';
        $this->params['main_route'] = 'admin.calendario';
    }

    public function index(Request $request)
    {
        $this->params['subtitulo'] = 'Calendário de Eventos';
        $this->params['arvore'][0] = [
            'url' => 'admin/calendario',
            'titulo' => 'Calendário'
        ];

        $params = $this->params;

        // Obter ID da Unidade
        $unidadeId = Auth::user()->unidade_id;

        // Obter Eventos
        $eventos = DB::table('eventos')
            ->select('id', 'title', 'start', 'end', DB::raw("'evento' as type"), DB::raw("'Confirmada' as status"))
            ->where('unidade_id', $unidadeId)
            ->get();

        // Obter Reservas (exceto Piscina)
        $reservas = DB::table('reservas')
            ->select('id', DB::raw("CONCAT('Reserva: ', area) as title"), 'data_inicio as start', 'data_inicio as end', DB::raw("'reserva' as type"), 'status')
            ->where('unidade_id', $unidadeId)
            ->where('area', 'not like', '%PISCINA%')
            ->get();

        // Obter Reservas de Piscina
        $reservasPiscina = DB::table('reservas')
            ->select('id', DB::raw("CONCAT('Reserva Piscina: ', area) as title"), 'data_inicio as start', 'data_inicio as end', DB::raw("'reserva_piscina' as type"), 'status')
            ->where('unidade_id', $unidadeId)
            ->where('area', 'like', '%PISCINA%')
            ->get();

        // Mesclar todos os dados
        $data['eventos'] = $eventos->merge($reservas)->merge($reservasPiscina)->map(function ($evento) {
            return [
                'id' => $evento->id,
                'title' => $evento->title,
                'start' => $evento->start,
                'end' => $evento->end,
                'type' => $evento->type,
                'status' => $evento->status ?? 'Pendente'
            ];
        });

        return view('admin.calendario.index', compact('params', 'data'));
    }


    public function create()
    {
        $this->params['subtitulo'] = 'Cadastrar Evento';
        $this->params['arvore'] = [
            ['url' => 'admin/calendario', 'titulo' => 'Calendário'],
            ['url' => '', 'titulo' => 'Cadastrar']
        ];
        $params = $this->params;

        return view('admin.calendario.create', compact('params'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'description' => 'nullable|string'
        ]);

        DB::table('eventos')->insert([
            'title' => $validated['title'],
            'start' => $validated['start'],
            'end' => $validated['end'] ?? null,
            'description' => $validated['description'] ?? null,
            'unidade_id' => Auth::user()->unidade_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('admin.calendario.index')
            ->with('success', 'Evento cadastrado com sucesso!');
    }


    public function show($id)
    {
        $this->params['subtitulo'] = 'Detalhes do Evento';
        $this->params['arvore'] = [
            ['url' => 'admin/calendario', 'titulo' => 'Calendário'],
            ['url' => '', 'titulo' => 'Detalhes']
        ];
        $params = $this->params;

        $data = ['id' => $id, 'title' => 'Evento Exemplo', 'start' => '2025-01-10'];

        return view('admin.calendario.show', compact('params', 'data'));
    }

    public function edit($id)
    {
        $this->params['subtitulo'] = 'Editar Evento';
        $this->params['arvore'] = [
            ['url' => 'admin/calendario', 'titulo' => 'Calendário'],
            ['url' => '', 'titulo' => 'Editar']
        ];
        $params = $this->params;

        $data = ['id' => $id, 'title' => 'Evento Exemplo', 'start' => '2025-01-10'];

        return view('admin.calendario.edit', compact('params', 'data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'start' => 'nullable|date',
            'end' => 'nullable|date|after_or_equal:start'
        ]);

        $updated = DB::table('eventos')
            ->where('id', $id)
            ->where('unidade_id', Auth::user()->unidade_id)
            ->update([
                'title' => $validated['title'] ?? DB::raw('title'),
                'start' => $validated['start'] ?? DB::raw('start'),
                'end' => $validated['end'] ?? DB::raw('end'),
                'updated_at' => now()
            ]);

        return response()->json(['success' => $updated]);
    }

    public function destroy($id)
    {
        $deleted = DB::table('eventos')
            ->where('id', $id)
            ->where('unidade_id', Auth::user()->unidade_id)
            ->delete();

        return response()->json(['success' => $deleted]);
    }
}
