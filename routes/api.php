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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/


Route::group(['namespace' => 'Api'],function(){
    // Route::get('pessoa/{bloco}/apto/{apto}', 'PessoaController@index')->name('api.pessoa.index');
    Route::get('pessoa/{rg}', 'PessoaController@index')->name('api.pessoa.index');
    Route::get('veiculo/{placa}', 'VeiculoController@index')->name('api.veiculo.index');
});