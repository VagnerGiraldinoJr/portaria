<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TableCode;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadeController extends Controller
{
    private $params = [];
    private $unidade = [];
    public function __construct(Unidade $unidades)
    {

        $this->unidade = $unidades;

        // Default values
        $this->params['titulo'] = 'Unidades';
        $this->params['main_route'] = 'admin.unidade';
    }

    public function index()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastro de Unidades - Filiais';
        $this->params['arvore'][0] = [
            'url' => 'admin/unidade ',
            'titulo' => 'Cadastro Unidades'
        ];

        $params = $this->params;
        $data = $this->unidade->get();
        return view('admin.unidade.index', compact('params', 'data'));
    }

    public function show($id)
    {
        $this->params['subtitulo'] = 'Deletar Usuário';
        $this->params['arvore'] = [
            [
                'url' => 'admin/unidade',
                'titulo' => 'Unidade'
            ],
            [
                'url' => '',
                'titulo' => 'Deletar'
            ]
        ];
        $params = $this->params;
        $data = $this->unidade->where('id', $id)->first();
        return view('admin.unidade.show', compact('params', 'data'));
    }

    public function create()
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Cadastrar Pessoas';
        $this->params['arvore'] = [
            [
                'url' => 'admin/pessoa',
                'titulo' => 'Cadastro de Pessoas'
            ],
            [
                'url' => '',
                'titulo' => 'Cadastrar'
            ]
        ];
        $params = $this->params;
        return view('admin.pessoa.create', compact('params'));
    }

    public function edit($id)
    {
        $this->params['subtitulo'] = 'Editar unidade';
        $this->params['arvore'] = [
            [
                'url' => 'admin/unidade',
                'titulo' => 'Unidades'
            ],
            [
                'url' => '',
                'titulo' => 'Editar'
            ]
        ];
        $params = $this->params;


        $data = $this->unidade->where('id', $id)->first();
        return view('admin.unidade.show', compact('params', 'data'));
    }

    public function update(Request $request, $id)
    {
        $dataForm  = $request->all();
        $unidade = $this->unidade->where('id')->find($id);
        if ($unidade->update($dataForm)) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao editar.']);
        }
    }

    public function destroy($id)
    {

        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Deletar Unidades - Filiais';
        $this->params['arvore'][0] = [
            'url' => 'admin/unidade ',
            'titulo' => 'Deletar Unidades'
        ];

        $params = $this->params;
        $data = $this->unidade->where('id', $id)->first();


        if ($data->delete()) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao deletar.']);
        }
    }
}
