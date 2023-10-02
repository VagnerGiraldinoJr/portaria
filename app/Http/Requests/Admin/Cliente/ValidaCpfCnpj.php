<?php

namespace App\Http\Requests\Admin\Cliente;

use Illuminate\Foundation\Http\FormRequest;

class ValidaCpfCnpj extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'cpf_cnpj' => 'required|cpf_cnpj',
        ];
    }

    public function messages()
    {
        return [
            'cpf_cnpj.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'cpf_cnpj.cpf_cnpj' =>':attribute Inválido, digite um número valido',
        ];
    }

    public function attributes()
    {
        return [
            'cpf_cnpj' => 'CPF / CNPJ',
        ];
    }
}
