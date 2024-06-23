<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estoque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstoqueController extends Controller
{
    private $params = [];
    private $estoque = [];


    public function __construct(Estoque $estoques)
    {
        $this->estoque = $estoques;

        // Default values
        $this->params['titulo'] = 'Estoque';
        $this->params['main_route'] = 'admin.estoque';
    }

    public function index(Request $request)
    {
        // PARAMS DEFAULT
        $this->params['subtitulo'] = 'Inventário de Produtos';
        $this->params['arvore'][0] = [
            'url' => 'admin/estoque/inventario',
            'titulo' => 'Estoque'
        ];

        $searchFields = $request->except('_token');
        $searchFields['titulo'] = (isset($searchFields['titulo'])  && $searchFields['titulo'] !== null) ? $searchFields['titulo'] : '';

        $params = $this->params;

        $data = $this->estoque
            ->select(DB::raw('produtos.id, produtos.titulo, estoques.quantidade'))
            ->join('produtos', 'produtos.id', 'produto_id')
            ->where("produtos.titulo", "like", "%" . $searchFields['titulo'] . "%")
            ->orderby('produtos.titulo')
            ->paginate(30);

        return view('admin.estoque.index', compact('params', 'data', 'searchFields'));
    }
}
