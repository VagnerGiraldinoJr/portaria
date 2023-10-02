<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CompraIten;

class Compra extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id', 'cpf_cnpj', 'nome_razaosocial', 'valor', 'acrescimo', 'desconto','valor_total', 'data_entrada', 'data_hora', 'cadastrado_por', 'deleted_at', 'created_at', 'updated_at'
    ];


    public function itens(){
        return $this->hasMany('App\Models\CompraIten');
    }

    public function getCompra($id){
        return  $this->with('itens')->find($id);
    }

}
