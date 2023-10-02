<?php

namespace App\Http\Requests\Admin\Pedido;

use Illuminate\Foundation\Http\FormRequest;

class PedidoUpdateRequest extends FormRequest

{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        //  id, orcamento_id, inicio, fim, status, cadastrado_por, created_at, updated_at
        return [
            'orcamento_id' => 'required',
            'status' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'orcamento_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'status.required' =>'O campo :attribute é de preenchimento obrigatório!'
        ];
    }

    public function attributes()
    {
        return [
            'orcamento_id' => 'Orçamento',
            'status' => 'Status'
        ];
    }
}
