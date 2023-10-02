<?php

namespace App\Rules\Admin\ContaCorrente;

use App\Models\Orcamento;
use Illuminate\Contracts\Validation\Rule;

class ValidarEntrada implements Rule
{
    public function __construct($attributes)
    {
        $this->errors = '';
        $this->attribute = $attributes;
    }

    public function passes($attribute, $value)
    {

        if($this->attribute['tipo_referencia'] == 1){
            $orcamento = new Orcamento();

            $data = $orcamento->find($value);
            if ($data == null) {
                $this->errors='O Pedido não está cadastrado no sistema!';
                return false;
            }
            return true;
        }else{
            return true;
        }
    }

    public function message()
    {
        return $this->errors;
    }
}
