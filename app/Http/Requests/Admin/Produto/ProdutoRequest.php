<?php

namespace App\Http\Requests\Admin\Produto;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        //  id, titulo, tipo, unidade_medida, controla_estoque
        return [
            'titulo' => 'required|unique:produtos,titulo,'.$this->id,
            'tipo' =>  'required' ,
            'unidade_medida' =>  'required' ,
            'controla_estoque' =>  'required' ,
        ];
    }

    public function messages()
    {
        return [
            'titulo.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'titulo.unique' =>':attribute já cadastrado',

            'tipo.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'unidade_medida.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'controla_estoque.required' =>'O campo :attribute é de preenchimento obrigatório!',

        ];
    }

    public function attributes()
    {
        return [
            'titulo' => 'Título',
            'tipo' => 'Tipo',
            'unidade_medida' => 'Unidade de Medida',
            'controla_estoque' => 'Controla Estoque?',
        ];
    }

}
