<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrcamentoSituacao extends Model
{
    protected $fillable = ['id', 'orcamento_id', 'inicio', 'fim', 'status','cadastrado_por'];

}
