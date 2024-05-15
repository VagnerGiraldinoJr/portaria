<?php

namespace App\Http\Requests\Unidade;

use Illuminate\Foundation\Http\FormRequest;

class UnidadeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        return [
            
            'titulo' => 'required'         

        ];
    }

    public function messages()
    {
        return [
            
            'titulo.required' => 'O :attribute é obrigatório'
        ];
    }

    public function attributes()
    {
        return [
            
            'titulo.required' => 'O :attribute é obrigatório'    
        ];
    }
}