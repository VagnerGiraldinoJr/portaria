<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Cliente extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'id', 'cpf_cnpj', 'data_nascimento', 'nome_razaosocial', 'cep', 'logradouro', 'bairro', 'numero', 'localidade', 'complemento', 'uf', 'email', 'telefone', 'celular', 'recado', 'observacoes'
    ];



    public function getClienteCpfCnpj($cpf_cnpj){
        return $this->whereRaw("REPLACE(REPLACE(REPLACE(cpf_cnpj,'.',''),'-',''),'/','') = '".$cpf_cnpj."'")->first();
    }
}
