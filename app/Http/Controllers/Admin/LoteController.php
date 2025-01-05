<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Lote\LoteRequest;
use App\Models\Lote;
use App\Models\TableCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoteController extends Controller
{

    private $params = [];
    private $lote = [];
    public function __construct(Lote $lotes)
    {

        $this->lote = $lotes;

        // Default values
        $this->params['titulo'] = 'Lotes';
        $this->params['main_route'] = 'admin.lote';
    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastro de Lotes';
        $this->params['arvore'][0] = [
            'url' => 'admin/lote ',
            'titulo' => 'Cadastro Lotes'
        ];

        $params = $this->params;
        $data = $this->lote->where('unidade_id', Auth::user()->unidade_id)->get();

        return view('admin.lote.index', compact('params', 'data'));
    }

    public function create(TableCode $codes)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastrar Lotes';
        $this->params['arvore'] = [
            [
                'url' => 'admin/lote',
                'titulo' => 'Cadastro de Lotes'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]
        ];

        $data = $this->lote->where('unidade_id', Auth::user()->unidade_id)->get();

        $params = $this->params;
        $preload['id'] = $codes->select(4);

        return view('admin.lote.create', compact('params', 'preload'));
    }

    public function store(LoteRequest $request)
    {
        $dataForm  = $request->all();
        $dataForm['unidade_id'] = Auth::user()->unidade_id;
        $insert = $this->lote->create($dataForm);

        if ($insert) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao fazer Inserir.']);
        }
    }

    public function show($id, TableCode $codes)
    {
        $this->params['subtitulo'] = 'Deletar Lotes';
        $this->params['arvore'] = [
            [
                'url' => 'admin/lote',
                'titulo' => 'Lotes'
            ],
            [
                'url' => '',
                'titulo' => 'Editar'
            ]
        ];
        $params = $this->params;
        $data = $this->lote->where('unidade_id', Auth::user()->unidade_id)->where('id', $id)->first();

        $preload['tipo'] = $codes->select(4);

        return view('admin.lote.show', compact('params', 'data', 'preload'));
    }

    public function edit($id, TableCode $codes)
    {
        $this->params['subtitulo'] = 'Editar Cadastro Lotes';
        $this->params['arvore'] = [
            [
                'url' => 'admin/lote',
                'titulo' => 'Lotes'
            ],
            [
                'url' => '',
                'titulo' => 'Editar'
            ]
        ];
        $params = $this->params;

        $data = $this->lote->where('unidade_id', Auth::user()->unidade_id)->where('id', $id)->first();

        $preload['tipo'] = $codes->select(4);
        return view('admin.lote.create', compact('params', 'data', 'preload'));
    }


    public function update(Request $request, $id)
    {
        $dataForm  = $request->all();

        //ajustar no veículo
        $pessoa = $this->lote->where('unidade_id', Auth::user()->unidade_id)->where('id', $id)->first();

        if ($pessoa->update($dataForm)) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {
        $data = $this->lote->where('unidade_id', Auth::user()->unidade_id)->where('id', $id)->first();

        if ($data->delete()) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao deletar.']);
        }
    }

    public function inadimplencia($id)
    {
        $this->params['subtitulo'] = 'Gerenciar Inadimplência do Lote';
        $this->params['arvore'] = [
            ['url' => 'admin/lote', 'titulo' => 'Lotes'],
            ['url' => '', 'titulo' => 'Gerenciar Inadimplência']
        ];

        $params = $this->params;
        $data = $this->lote->where('unidade_id', Auth::user()->unidade_id)->where('id', $id)->first();

        if (!$data) {
            return redirect()->route('admin.lote.index')->withErrors(['Lote não encontrado.']);
        }

        return view('admin.lote.inadimplencia', compact('params', 'data'));
    }

    public function marcarInadimplente($id)
    {
        $lote = $this->lote->where('unidade_id', Auth::user()->unidade_id)->where('id', $id)->first();

        if (!$lote) {
            return redirect()->route('admin.lote.index')->withErrors(['Lote não encontrado.']);
        }

        if (!$lote->inadimplente) {
            $lote->inadimplente = true; // Define como inadimplente
            $lote->inadimplente_por = Auth::id(); // Salva o ID do usuário que marcou
            $lote->inadimplente_em = now(); // Salva a data/hora atual
            $lote->save();

            return redirect()->route('admin.lote.index')->with('success', 'Lote marcado como inadimplente.');
        }

        return redirect()->back()->withErrors(['Este lote já está inadimplente.']);
    }


    public function regularizar($id)
    {
        $lote = $this->lote->where('unidade_id', Auth::user()->unidade_id)->where('id', $id)->first();

        if (!$lote) {
            return redirect()->route('admin.lote.index')->withErrors(['Lote não encontrado.']);
        }

        if ($lote->inadimplente) {
            $lote->inadimplente = false; // Define como regular
            $lote->regularizado_por = Auth::id(); // Salva o ID do usuário que regularizou
            $lote->regularizado_em = now(); // Salva a data/hora atual
            $lote->save();

            return redirect()->route('admin.lote.index')->with('success', 'Lote regularizado com sucesso.');
        }

        return redirect()->back()->withErrors(['Este lote já está regularizado.']);
    }
}
