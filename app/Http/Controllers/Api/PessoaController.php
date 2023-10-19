<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PessoaController extends Controller
// {
//     public function index(Pessoa $pessoas, $bloco, $apto)
//     {
//         return $pessoas ->where('bloco','like','%'.$bloco.'%')
//                         ->where('apto','like','%'.$apto.'%')
//                         ->first();
//     }
// }
{
    public function index(Pessoa $pessoas, $rg)
    {
        return $pessoas ->where('rg','like','%'.$rg.'%')
                        ->first();
    }
}
