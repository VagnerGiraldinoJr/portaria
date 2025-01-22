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
           'lote_id' => 'required|exists:lotes,id',
            'veiculo_id' => 'required_if:tipo,2',
            'motorista' => 'required_if:tipo,2',
            'motivo' => 'required_if:tipo,1',
            'retirado_por' => '|string|max:191',
            
        ];
    }

    public function messages()
    {
        return [
            
            'tipo.required' => 'O :attribute é obrigatório',
            'lote_id.required_if' => 'O :attribute é obrigatório',
            'veiculo_id.required_if' => 'O :attribute é obrigatório',
            'motorista.required_if' => 'O :attribute é obrigatório',
            'motivo.required_if' => 'O :attribute é obrigatório',
        ];
    }

    public function attributes()
    {
        return [
            
            'tipo' => 'Tipo de Acesso',
            'lote_id' => 'Lote / Apto',
            'veiculo_id' => 'Veiculo',
            'motorista' => 'Motorista',
            'motivo' => 'Motivo', 
                    
        ];
    }
}
