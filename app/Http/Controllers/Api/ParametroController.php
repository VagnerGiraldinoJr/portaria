<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Parametro;
use Illuminate\Http\Request;

class ParametroController extends Controller
{
    public function __construct(Parametro $parametros)
    {
        $this->parametro = $parametros;
    }
    
    public function index($titulo)
    {
        return $this->parametro->where('titulo',$titulo)->get()->first();
    }
}
