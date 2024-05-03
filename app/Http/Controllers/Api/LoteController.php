<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    private $lote; 

    public function __construct(Lote $lotes)
    {

        $this->lote = $lotes;
    }
    
    public function index($id){
        return $this->lote->find($id);
    }
}
