<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contato;
use Illuminate\Http\Request;

class ContatoController extends Controller
{
    public function create()
    {
        return view('contatos.create');
    }

    public function store(Request $request)
    {
        // Validação dos campos do formulário (exemplo)
        $request->validate([
            'nome' => 'required',
            'telefone' => 'required',
            // ... outros campos de validação ...
        ]);

        // Crie um novo contato
        $contato = new Contato();
        $contato->nome = $request->input('nome');
        $contato->telefone = $request->input('telefone');
        // ... outros campos ...

        // Obtenha o ID da pessoa dinamicamente (por exemplo, a partir dos parâmetros da URL)
        $pessoaId = $request->input('pessoa_id'); // Substitua pelo campo correto

        // Salve o contato relacionado à pessoa
        $contato->lote_id = $pessoaId;
        $contato->save();

        // Redirecione para alguma página (por exemplo, a página de detalhes da pessoa)
        return redirect()->route('pessoas.show', ['id' => $pessoaId]);
    }
}
