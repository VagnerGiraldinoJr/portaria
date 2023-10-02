<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id', 'cpf_cnpj', 'nome_razaosocial', 'cep', 'logradouro', 'bairro', 'numero', 'localidade', 'complemento', 'uf', 'email', 'telefone', 'celular'
    ];
}
