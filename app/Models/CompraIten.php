<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraIten extends Model
{
    protected $fillable = ['id', 'compra_id', 'produto_id', 'quantidade', 'valor','desc_produto'];

    protected $appends = ['desc_produto'];

    public function getDescProdutoAttribute()
    {
        $this->produto = new Produto();
        $tmp_value = $this->produto->select('titulo as desc_produto')->find($this->produto_id);
        return $tmp_value['desc_produto'];
    }

}
