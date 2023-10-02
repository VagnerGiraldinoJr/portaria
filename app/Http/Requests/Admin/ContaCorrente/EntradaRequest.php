<?php

namespace App\Http\Requests\Admin\ContaCorrente;

use App\Rules\Admin\ContaCorrente\ValidarEntrada;
use Illuminate\Foundation\Http\FormRequest;

class EntradaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        //  id, valor, tipo, forma_pagamento, data_hora, cadastrado_por, referencia, pedido_id, deleted_at, created_at, updated_at
        return [
            'valor' => 'required',
            'operacao' => 'required',
            'forma_pagamento' => 'required',
            'referencia' => 'exclude_if:tipo_referencia,1|required',
            'pedido_id' => 'exclude_if:tipo_referencia,2|required' ,
            'pedido_id' => new ValidarEntrada(request()),
        ];
    }

    public function messages()
    {

        return [
            'valor.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'operacao.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'forma_pagamento.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'data_hora.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'cadastrado_por.date' =>'O campo :attribute precisa ser uma data válida!',
            'referencia.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'pedido_id.required' =>'O campo :attribute não é inválido!'
        ];
    }

    public function attributes()
    {

        return [
            'valor' => 'Valor',
            'operacao' => 'Tipo Operação',

            'forma_pagamento' => 'Forma de Pagamento',
            'data_hora' => 'Data de Entrada',

            'cadastrado_por' => 'Cadastrado Por',
            'referencia' => 'Referencia',
            'pedido_id' => 'Nº Pedido'
        ];
    }
}
