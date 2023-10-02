<?php 

use App\Models\TableCode;

if(! function_exists('getTableCodeByParent')){
    function getTableCodeByParent($pai){
        $table_codes =  new TableCode();
        $table_code = $table_codes->select($pai);
        return $table_code;
    }
}

if(! function_exists('getDescricaoById')){
    function getDescricaoById($pai,$valor){
        $table_codes =  new TableCode();
        $table_code = $table_codes->getDescricaoById($pai,$valor);
        return $table_code;
    }
}

if(! function_exists('getSelectExcept')){
    function getSelectExcept($pai,$item){
        $table_codes =  new TableCode();
        $table_code = $table_codes->selectExcept($pai,$item);
        return $table_code;
    }
}