<?php

namespace App\Rules\Admin\Compra;

use Illuminate\Contracts\Validation\Rule;

class ValidarItensCompra implements Rule
{
    public function __construct($attributes = NULL)
    {
        $this->errors = null;

        $this->descAttribute = $attributes;
    }

    public function passes($attribute, $value)
    {
        if(is_array($value)){
            foreach ($value as $k => $v) {
                    if($v == '')
                        $this->errors[]='O '.$this->descAttribute[$attribute].' do item '.($k+1).' precisa ser preenchido';
            }
            if($this->errors == null)
                return true;
            else
                return false;
        }else{
            $this->errors[]='Erro, formulário não foi gerado corretamente.';
            return false;
        }

        $this->errors[]='Erro!';
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->errors;
    }
}
