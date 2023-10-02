<?php

namespace App\Http\Requests\Admin\ContaCorrente;

use Illuminate\Foundation\Http\FormRequest;

class ExtornoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'motivo_extorno' => 'required',
        ];
    }

    public function messages()
    {

        return [
            'motivo_extorno.required' =>'O campo :attribute é de preenchimento obrigatório!',
        ];
    }

    public function attributes()
    {

        return [
            'motivo_extorno' => 'Motivo',
        ];
    }
}
