<?php

namespace App\Http\Requests\Admin\ContaCorrente;

use Illuminate\Foundation\Http\FormRequest;

class SaidaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'valor' => 'required',
            'forma_pagamento' => 'required',
            'operacao' => 'required',
            'referencia' => 'required',
        ];
    }

    public function messages()
    {

        return [
            'valor.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'operacao.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'forma_pagamento.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'referencia.required' =>'O campo :attribute é de preenchimento obrigatório!',
        ];
    }

    public function attributes()
    {

        return [
            'valor' => 'Valor',
            'operacao' => 'Tipo Operação',

            'forma_pagamento' => 'Forma de Retirada',
            'referencia' => 'Referencia',
        ];
    }
}
