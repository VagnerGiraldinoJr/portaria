<?php

namespace App\Http\Requests\Admin\Orcamento;

use App\Rules\Admin\Orcamento\ValidarItensOrcamento;
use Illuminate\Foundation\Http\FormRequest;

class OrcamentoInsertRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        //  id, cliente_id, valor, acrescimo, desconto, valor_total, forma_pagamento, situacao, data_entrega, data_hora, cadastrado_por
        return [
            'cliente_id' => 'required',
            'valor' => 'required',
            'forma_pagamento' => 'required',

            'valor_total' => 'required',
            'data_entrega' => 'required|date',

            'produto_id' => 'required|array',
            'valor_unitario' => 'required|array',
            'quantidade' => 'required|array',

            'produto_id' => new ValidarItensOrcamento($this->attributes()),
            'valor_unitario' => new ValidarItensOrcamento($this->attributes()),
            'quantidade' => new ValidarItensOrcamento($this->attributes()),
        ];
    }

    public function messages()
    {
        return [

            'cliente_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'valor.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'forma_pagamento.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'valor_total.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'data_entrega.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'data_entrega.date' =>'O campo :attribute precisa ser uma data válida!',

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
            'cliente_id' => 'Cliente',
            'valor' => 'Subtotal',
            'forma_pagamento' => 'Forma de Pagamento',

            'valor_total' => 'Valor Total',
            'data_entrega' => 'Data Entrega',

            // ARRAY
            'produto_id' => 'Produto',
            'valor_unitario' => 'Valor Unitário',
            'quantidade' => 'Quantidade'
        ];
    }
}
