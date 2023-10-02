<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class Estoque extends Model
{
    protected $fillable = ['id', 'produto_id', 'quantidade', 'created_at', 'updated_at'];


    public function atualizarEstoque($produto_id, $quantidade,$operacao){
        $produto = new Produto();
        $data = $produto->select('controla_estoque')->find($produto_id)->toArray();
        if($data['controla_estoque'] == 1){
            if($operacao == 0 || $operacao == 1){
                $estoque = $this->where('produto_id', $produto_id)->first();



                if($estoque){
                    $estoque = $estoque->only(['id','quantidade']);
                    if($operacao == 1){
                        $estoque['quantidade'] =  ($estoque['quantidade'] + $quantidade);
                    }else{
                        $estoque['quantidade'] =  ($estoque['quantidade'] - $quantidade);
                    }
                    if(!$this->find($estoque['id'])->update($estoque)){
                        return false;
                    }
                    return true;
                }else{
                    if($operacao == 1){
                        $estoque=[];
                        $estoque['produto_id'] = $produto_id;
                        $estoque['quantidade'] = $quantidade ;
                        if(! $this->create($estoque)){
                            return false;
                        }
                        return true;
                    }else{
                        $estoque=[];
                        $estoque['produto_id'] = $produto_id;
                        $estoque['quantidade'] = -$quantidade ;
                        if(! $this->create($estoque)){
                            return false;
                        }
                        return true;
                    }
                    return true;
                }

            }
            return false;
        }
        return true;
    }

}
