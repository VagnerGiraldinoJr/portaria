<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unidade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use UserSeeder;

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
        
         // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;
         // Final do bloco da descricao

        $params = $this->params;
        $data = User::with(['unidade_id.users']);
        $data = $this->unidade
        ->where('id', Auth::user()->unidade_id)
        ->get();
        
        // dd($data);
        
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

         // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;
          // Final do bloco da descricao
        
        $params = $this->params;


        $data = $this->unidade->where('id', $id)->first();
        return view('admin.unidade.show', compact('params', 'data'));
    }

    public function update(Request $request, $id)
    {
       

        $unidade = $this->unidade->find($id);

         // Verificar se a unidade foi encontrada
    if (!$unidade) {
        return redirect()->route($this->params['main_route'] . '.index')
                         ->withErrors(['Unidade não encontrada.']);
    }
       

       
        return redirect()->route('admin.unidade.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    

    public function destroy($id)
    {

        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Deletar Unidades - Filiais';
        $this->params['arvore'][0] = [
            'url' => 'admin/unidade ',
            'titulo' => 'Deletar Unidades'
        ];

         // Obter a descrição da unidade dentro do params['unidade_descricao']
        $unidadeId = Auth::user()->unidade_id;
        $descricaoUnidade = DB::table('unidades')
            ->where('id', $unidadeId)
            ->value('titulo');
        $this->params['unidade_descricao'] = $descricaoUnidade;
           // Final do bloco da descricao
        
           $data = $this->unidade->where('id', $id)->first();
           
           $params = $this->params;

        if ($data->delete()) {
            return redirect()->route($this->params['main_route'] . '.index');
        } else {
            return redirect()->route($this->params['main_route'] . '.create')->withErrors(['Falha ao deletar.']);
        }
    }
}
