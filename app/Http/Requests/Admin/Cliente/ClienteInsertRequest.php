<?php

namespace App\Http\Requests\Admin\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class ClienteInsertRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {

        // id, tipo, cpf_cnpj, data_nascimento, nome_razaosocial, cep, logradouro, bairro,
        //  numero, localidade, complemento, uf,
        //  email, telefone, celular, recado, observacoes

        return [
            'cpf_cnpj' => 'required|cpf_cnpj|unique:clientes,cpf_cnpj,'.$this->id,
            'nome_razaosocial' => 'required',
            'data_nascimento' => 'required|date',
            'cep' => 'required',
            'logradouro' => 'required',
            'bairro' => 'required',
            'numero' => 'required',
            'localidade' => 'required',
            'email' => 'required',
            'complemento' => 'required',
            'uf' => 'required',
            'telefone' => 'required',
            'celular' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cpf_cnpj.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'cpf_cnpj.cpf_cnpj' =>':attribute Inválido, digite um número valido',
            'cpf_cnpj.unique' =>':attribute já cadastrado',

            'data_nascimento.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'data_nascimento.date' =>'O campo :attribute precisa ser uma dada válida!',
            'cep.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'logradouro.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'bairro.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'numero.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'email.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'complemento.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'localidade.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'uf.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'telefone.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'celular.required' =>'O campo :attribute é de preenchimento obrigatório!',
        ];
    }

    public function attributes()
    {
        return [
            'cpf_cnpj' => 'CPF / CNPJ',
            'nome_razaosocial' => 'Nome / Razão Social',
            'data_nascimento' => 'Data Nascimento',
            'cep' => 'CEP',
            'logradouro' => 'Logradouro',
            'bairro' => 'Bairro',
            'numero' => 'Número',
            'localidade' => 'Localidade',
            'email' => 'E-mail',
            'complemento' => 'Complemento',
            'uf' => 'UF',
            'telefone' => 'Telefone',
            'celular' => 'Celular',
        ];
    }
}
