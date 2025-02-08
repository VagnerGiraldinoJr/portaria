<?php

namespace App\Http\Requests\Admin\Pessoa;

use App\Models\Lote;
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
            'lote_id' => 'required'

        ];
    }

    public function messages()
    {
        return [

            'nome_completo.required' => 'O :attribute é obrigatório',
            'rg.required' => 'O :attribute é obrigatório',
            'lote_id.required' => 'O :attribute é obrigatório',


        ];
    }

    public function attributes()
    {
        return [

            'nome_completo.required' => 'O :attribute é obrigatório',
            'rg.required' => 'O :attribute é obrigatório',
            'lote_id.required' => 'O :attribute é obrigatório',


        ];
    }

    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }
}
