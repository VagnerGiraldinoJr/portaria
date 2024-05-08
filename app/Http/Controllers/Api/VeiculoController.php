<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VeiculoController extends Controller
{
    private $veiculo;
    public function __construct(Veiculo $veiculos)
    {
        $this->veiculo = $veiculos;
    }

    public function index($placa)
    {
        return $this->veiculo->where('placa','like','%'.$placa.'%')->where('unidade_id',Auth::user()->unidade_id)->first();
    }
}
