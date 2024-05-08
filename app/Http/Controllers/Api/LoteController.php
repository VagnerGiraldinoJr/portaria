<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use Illuminate\Support\Facades\Auth;

class LoteController extends Controller
{
    
    private $pessoa;
    public function __construct(Pessoa $pessoas)
    {
        $this->pessoa = $pessoas;
    }

    public function index($id)
    {
        return $this->pessoa->join('lotes', 'lotes.id', '=', 'pessoas.lote_id')
                                ->where('lotes.unidade_id', Auth::user()->unidade_id)
                                ->where('lotes.id',$id)->first();

    }
}
