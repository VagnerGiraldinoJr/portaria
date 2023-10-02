<?php

namespace App\Http\Requests\Admin\Pessoa;

use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            
            'nome_completo' => 'required',
            'rg' => 'required',
            

        ];
    }

    public function messages()
    {
        return [
            
            'nome_completo.required' => 'O :attribute é obrigatório',
            'rg.required' => 'O :attribute é obrigatório',
            
          
        ];
    }

    public function attributes()
    {
        return [
            
            'nome_completo.required' => 'O :attribute é obrigatório',
            'rg.required' => 'O :attribute é obrigatório',
            
            
        ];
    }
}
