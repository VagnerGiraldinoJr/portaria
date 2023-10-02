<?php

namespace App\Http\Requests\Admin\BaixaMaterial;

use Illuminate\Foundation\Http\FormRequest;

class BaixaMaterialInsertRequest extends FormRequest
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
            'produto_id' => 'required',
            'quantidade' => 'required',
            'motivo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'produto_id.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'quantidade.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'motivo.required' =>'O campo :attribute é de preenchimento obrigatório!',
        ];
    }

    public function attributes()
    {
        return [
            'produto_id' => 'Produto',
            'quantidade' => 'Quantidade',
            'motivo' => 'Motivo'
        ];
    }
}
