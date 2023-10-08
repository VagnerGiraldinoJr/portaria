<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserInsertRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            // 'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'email.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'email.email' =>'O campo :attribute precisa ser um email válido!',

            // 'role.required' =>'O campo :attribute é de preenchimento obrigatório!',

            'email.unique' =>':attribute já cadastrada',
            'password.required' =>'O campo :attribute é de preenchimento obrigatório!',
            'password.confirmed' =>'O campo :attribute precisa ser confirmado',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha',
            // 'role' => 'Papel',
        ];
    }
}
