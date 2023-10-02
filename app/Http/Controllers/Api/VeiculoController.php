<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    public function index(Veiculo $veiculo, $placa)
    {
        return $veiculo->where('placa','like','%'.$placa.'%')->first();
    }
}
