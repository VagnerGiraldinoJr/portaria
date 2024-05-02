<?php

namespace App\Http\Requests\Admin\Lote;

use Illuminate\Foundation\Http\FormRequest;

class LoteRequest extends FormRequest
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
            
            'descricao' => 'required'

        ];
    }

    public function messages()
    {
        return [
            
            'descricao.required' => 'O :attribute é obrigatório'
          
        ];
    }

    public function attributes()
    {
        return [
            
            'descricao.required' => 'O :attribute é obrigatório'            
            
        ];
    }
}
