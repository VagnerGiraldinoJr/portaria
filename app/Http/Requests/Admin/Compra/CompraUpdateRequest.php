<?php

namespace App\Http\Requests\Admin\Compra;
use App\Rules\Admin\Compra\ValidarItensCompra;
use Illuminate\Foundation\Http\FormRequest;

class CompraUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        //  id, cpf_cnpj, nome_razaosocial, valor, acrescimo, desconto, valor_total, data_entrada, data_hora
        //, cadastrado_por, deleted_at, created_at, updated_at
        return [
            'cpf_cnpj' => 'required|cpf_cnpj',
            'nome_razaosocial' => 'required',
            'valor' => 'required',

            'valor_total' => 'required',
            'data_entrada' => 'required|date',

            'produto_id' => 'required|array',
            'valor_unitario' => 'required|array',
            'quantidade' => 'required|array',

            'produto_id' => new ValidarItensCompra($this->attributes()),
            'valor_unitario' => new ValidarItensCompra($this->attributes()),
            'quantidade' => new ValidarItensCompra($this->attributes()),
        ];
    }

    public function messages()
    {
        return [
            'cpf_cnpj.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'cpf_cnpj.cpf_cnpj' =>':attribute Inválido, digite um número valido',
            'nome_razaosocial.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'valor.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'forma_pagamento.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'valor_total.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'data_entrada.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'data_entrada.date' =>'O campo :attribute precisa ser uma data válida!',

            'produto_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'valor_unitario.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'quantidade.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'produto_id.array' => 'O campo :attribute precisa ser preenchido ao menos 1 vez ',
            'valor_unitario.array' => 'O campo :attribute precisa ser preenchido ao menos 1 vez ',
            'quantidade.array' => 'O campo :attribute precisa ser preenchido ao menos 1 vez ',
        ];
    }

    public function attributes()
    {
        return [
            'cpf_cnpj' => 'CPF / CNPJ',
            'nome_razaosocial' => 'Nome / Razão Social',
            'data_entrada' => 'Data Entrada',
            'valor' => 'Subtotal',

            'valor_total' => 'Valor Total',

            // ARRAY
            'produto_id' => 'Produto',
            'valor_unitario' => 'Valor Unitário',
            'quantidade' => 'Quantidade'
        ];
    }
}
