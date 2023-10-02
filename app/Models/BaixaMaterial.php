<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaixaMaterial extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id', 'produto_id', 'quantidade', 'motivo', 'data_cadastro', 'cadastrado_por', 'deleted_at', 'created_at', 'updated_at'
    ];

    


}
