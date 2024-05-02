<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'],function(){
    // Route::get('pessoa/{bloco}/apto/{apto}', 'PessoaController@index')->name('api.pessoa.index');
    Route::get('pessoa/{rg}', 'PessoaController@index')->name('api.pessoa.index');
    Route::get('veiculo/{placa}', 'VeiculoController@index')->name('api.veiculo.index');
    Route::get('lote/{id}', 'loteController@index')->name('api.lote.index');
    //Route::get('morador/{placa}', 'MoradorController@index')->name('api.morador.index');
});