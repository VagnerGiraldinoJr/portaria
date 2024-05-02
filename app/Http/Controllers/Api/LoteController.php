<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    public function index(Lote $descricao){
        return $descricao ->where('descricao','like','%'.$descricao.'%')
                        ->first();
    }
}
