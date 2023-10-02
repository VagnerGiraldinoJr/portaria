<?php

namespace App\Http\Requests\Admin\ControleAcesso;

use Illuminate\Foundation\Http\FormRequest;

class ControleAcessoRequest extends FormRequest
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
        //id, tipo, pessoa_id, veiculo_id, motorista, data_entrada, data_saida, observacao, motivo, destino

        return [
            
            'tipo' => 'required',
            'pessoa_id' => 'required_if:tipo,1',
            'veiculo_id' => 'required_if:tipo,2',
            // 'motorista' => 'required',
            'data_entrada' => 'required',
            'motivo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            
            'tipo.required' => 'O :attribute é obrigatório',
            'pessoa_id.required_if' => 'O :attribute é obrigatório',
            'veiculo_id.required_if' => 'O :attribute é obrigatório',
            // 'motorista.required' => 'O :attribute é obrigatório',
            'data_entrada.required' => 'O :attribute é obrigatório',
            'motivo.required' => 'O :attribute é obrigatório',
        ];
    }

    public function attributes()
    {
        return [
            
            'tipo' => 'Tipod de Acesso',
            'pessoa_id' => 'Pessoa',
            'veiculo_id' => 'Veiculo',
            // 'motorista' => 'Motorista',
            'data_entrada' => 'Data de Entrada',
            'motivo' => 'Motivo',
            
        ];
    }
}
