<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TableCode extends Model
{
    protected $fillable = ['id', 'pai', 'item', 'valor', 'descricao'];

    public function select($pai, $flag = NULL){
        if($flag){
            return $this->where('pai',$pai)->where('flag',$flag)->where('item','<>',0)->orderBy('descricao')->get()->pluck('descricao','valor');
        }else{
            return $this->where('pai',$pai)->where('item','<>',0)->orderBy('descricao')->get()->pluck('descricao','valor');
        }
        
    }

    public function selectByValor($pai, $flag = NULL){
        if($flag){
            return $this->where('pai',$pai)->where('flag',$flag)->where('item','<>',0)->orderBy('valor')->get()->pluck('descricao','valor');
        }else{
            return $this->where('pai',$pai)->where('item','<>',0)->orderBy('valor')->get()->pluck('descricao','valor');
        }
        
    }

    public function selectExcept($pai,$item){
        return $this->where('pai',$pai)->where('item','<>',0)->where('item','<>',$item)->orderBy('descricao')->get()->pluck('descricao','valor');
    }

    public function getDescricaoById($pai,$valor){
        $tmp = $this->where('pai',$pai)->where('item','<>',0)->where('valor',$valor)->select('descricao')->first()->toArray();
        return  is_array($tmp) ? $tmp["descricao"] : '';
    }
}
