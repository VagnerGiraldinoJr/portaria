<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    //use SoftDeletes;
    protected $fillable = ['titulo', 'tipo', 'unidade_medida', 'controla_estoque','deleted_at'];

}
