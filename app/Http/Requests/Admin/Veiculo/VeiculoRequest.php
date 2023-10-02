<?php

namespace App\Http\Requests\Admin\Veiculo;

use Illuminate\Foundation\Http\FormRequest;

class VeiculoRequest extends FormRequest
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
            'placa' => 'required',
            'modelo' => 'required',
            'tipo'=>'required'
        ];
    }
    //["placa","modelo","tipo","observacao"];
    public function messages(){
        return [
            'placa.required' => 'O :attribute é obrigatório',
            'modelo.required' => 'O :attribute é obrigatório',
            'tipo.required' => 'O :attribute é obrigatório'
        ];
    }

    public function attributes()
    {
        return [
            'placa' => 'Placa',
            'modelo' => 'Modelo',
            'tipo' => 'Tipo'
        ];
    }
}
