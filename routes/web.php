<?php

use App\Http\Controllers\Admin\ClienteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::group(['prefix' => 'admin','middleware' => ['auth','acl'],'namespace' => 'Admin'],function(){
        Route::get('/', 'IndexController@index')->name('admin');
        Route::get('/home', 'IndexController@index')->name('home');

        //Cliente
        Route::any('cliente', [ClienteController::class, 'index'])->name('admin.cliente.index');
        Route::get('cliente/create', 'ClienteController@create')->name('admin.cliente.create');
        Route::post('cliente/store', 'ClienteController@store')->name('admin.cliente.store');
        Route::get('cliente/edit/{id}', 'ClienteController@edit')->name('admin.cliente.edit');
        Route::get('cliente/show/{id}', 'ClienteController@show')->name('admin.cliente.show');
        Route::put('cliente/update/{id}', 'ClienteController@update')->name('admin.cliente.update');

        //Routes AJAX
        Route::get('cliente/buscar', 'ClienteController@getClienteCpfCnpj')->name('admin.cliente.buscar');

        //Orcamento
        Route::any('orcamento', 'OrcamentoController@index')->name('admin.orcamento.index');
        Route::get('orcamento/create', 'OrcamentoController@create')->name('admin.orcamento.create');
        Route::post('orcamento/store', 'OrcamentoController@store')->name('admin.orcamento.store');
        Route::get('orcamento/edit/{id}', 'OrcamentoController@edit')->name('admin.orcamento.edit');
    //  Route::get('orcamento/show/{id}', 'OrcamentoController@show')->name('admin.orcamento.show');
        Route::put('orcamento/update/{id}', 'OrcamentoController@update')->name('admin.orcamento.update');
        Route::delete('orcamento/destroy/{id}', 'OrcamentoController@destroy')->name('admin.orcamento.destroy');

        Route::get('orcamento/buscar', 'OrcamentoController@getOrcamentoById')->name('admin.orcamento.buscar');
        Route::get('orcamento/print/{id}', 'OrcamentoController@print')->name('admin.print.orcamento');


        //Pedido
        Route::any('pedido', 'PedidoController@index')->name('admin.pedido.index');
        Route::get('pedido/create', 'PedidoController@create')->name('admin.pedido.create');
        Route::post('pedido/store', 'PedidoController@store')->name('admin.pedido.store');
        Route::get('pedido/edit/{id}', 'PedidoController@edit')->name('admin.pedido.edit');
        Route::get('pedido/show/{id}', 'PedidoController@show')->name('admin.pedido.show');
        Route::put('pedido/update/{id}', 'PedidoController@update')->name('admin.pedido.update');
        Route::delete('pedido/destroy/{id}', 'PedidoController@destroy')->name('admin.pedido.destroy');


        //Produto
        Route::get('produto', 'ProdutoController@index')->name('admin.produto.index');
        Route::get('produto/create', 'ProdutoController@create')->name('admin.produto.create');
        Route::post('produto/store', 'ProdutoController@store')->name('admin.produto.store');
        Route::get('produto/edit/{id}', 'ProdutoController@edit')->name('admin.produto.edit');
        Route::get('produto/show/{id}', 'ProdutoController@show')->name('admin.produto.show');
        Route::put('produto/update/{id}', 'ProdutoController@update')->name('admin.produto.update');
        Route::delete('produto/destroy/{id}', 'ProdutoController@destroy')->name('admin.produto.destroy');

       // User
        Route::get('user', ['uses'=> 'UserController@index'])->name('admin.user.index');
        Route::get('user/create', ['uses'=> 'UserController@create'])->name('admin.user.create');
        Route::post('user/store', ['uses'=> 'UserController@store'])->name('admin.user.store');
        Route::get('user/edit/{id}', ['uses'=> 'UserController@edit'])->name('admin.user.edit');
        Route::get('user/show/{id}', ['uses'=> 'UserController@show'])->name('admin.user.show');
        Route::put('user/update/{id}', ['uses'=> 'UserController@update'])->name('admin.user.update');
        Route::delete('user/destroy/{id}', ['uses'=> 'UserController@destroy'])->name('admin.user.destroy');

        //Veiculos
        Route::get('veiculo', 'VeiculoController@index')->name('admin.veiculo.index');
        Route::get('veiculo/create', 'VeiculoController@create')->name('admin.veiculo.create');
        Route::post('veiculo/store', 'VeiculoController@store')->name('admin.veiculo.store');
        Route::get('veiculo/edit/{id}', 'VeiculoController@edit')->name('admin.veiculo.edit');
        Route::get('veiculo/show/{id}', 'VeiculoController@show')->name('admin.veiculo.show');
        Route::put('veiculo/update/{id}', 'VeiculoController@update')->name('admin.veiculo.update');
        Route::delete('veiculo/destroy/{id}', 'VeiculoController@destroy')->name('admin.veiculo.destroy');

        //Pessoas
        Route::get('pessoa', 'PessoaController@index')->name('admin.pessoa.index');
        Route::get('pessoa/create', 'PessoaController@create')->name('admin.pessoa.create');
        Route::post('pessoa/store', 'PessoaController@store')->name('admin.pessoa.store');
        Route::get('pessoa/edit/{id}', 'PessoaController@edit')->name('admin.pessoa.edit');
        Route::get('pessoa/show/{id}', 'PessoaController@show')->name('admin.pessoa.show');
        Route::put('pessoa/update/{id}', 'PessoaController@update')->name('admin.pessoa.update');
        Route::delete('pessoa/destroy/{id}', 'PessoaController@destroy')->name('admin.pessoa.destroy');

        //ControleAcesso
        Route::get('controleacesso', 'ControleAcessoController@index')->name('admin.controleacesso.index');
        Route::get('controleacesso/create', 'ControleAcessoController@create')->name('admin.controleacesso.create');
        Route::post('controleacesso/store', 'ControleAcessoController@store')->name('admin.controleacesso.store');
        Route::get('controleacesso/edit/{id}', 'ControleAcessoController@edit')->name('admin.controleacesso.edit');
        Route::get('controleacesso/show/{id}', 'ControleAcessoController@show')->name('admin.controleacesso.show');
        Route::put('controleacesso/update/{id}', 'ControleAcessoController@update')->name('admin.controleacesso.update');
        Route::delete('controleacesso/destroy/{id}', 'ControleAcessoController@destroy')->name('admin.controleacesso.destroy');

        //ControleAcesso_extra
        Route::get('controleacesso/exit/{id}', 'ControleAcessoController@exit')->name('admin.controleacesso.exit');
        Route::put('controleacesso/exit/{id}', 'ControleAcessoController@updateexit')->name('admin.controleacesso.updateexit');
        
        //Compras
        Route::any('compra', 'CompraController@index')->name('admin.compra.index');
        Route::get('compra/create', 'CompraController@create')->name('admin.compra.create');
        Route::post('compra/store', 'CompraController@store')->name('admin.compra.store');
        Route::get('compra/edit/{id}', 'CompraController@edit')->name('admin.compra.edit');
        Route::get('compra/show/{id}', 'CompraController@show')->name('admin.compra.show');
        Route::put('compra/update/{id}', 'CompraController@update')->name('admin.compra.update');
        Route::delete('compra/destroy/{id}', 'CompraController@destroy')->name('admin.compra.destroy');

        //Baixa Material
        Route::any('baixa_material', ['uses'=>'BaixaMaterialController@index'])->name('admin.baixa_material.index');
        Route::get('baixa_material/create', ['uses'=>'BaixaMaterialController@create'])->name('admin.baixa_material.create');
        Route::post('baixa_material/store', ['uses'=>'BaixaMaterialController@store'])->name('admin.baixa_material.store');
        Route::get('baixa_material/show/{id}', ['uses' =>'BaixaMaterialController@show'])->name('admin.baixa_material.show');
        Route::delete('baixa_material/destroy/{id}', ['uses'=>'BaixaMaterialController@destroy', 'is' => 'admin'])->name('admin.baixa_material.destroy');

        //Estoque
        Route::any('estoque/inventario', 'EstoqueController@index')->name('admin.estoque.inventario');

        //Conta Corrente
        Route::any('contacorrente', 'ContaCorrenteController@index')->name('admin.conta_corrente.index');
        Route::get('contacorrente/show/{id}', 'ContaCorrenteController@show')->name('admin.conta_corrente.show');
        Route::post('contacorrente/extornar/{id}', ['ContaCorrenteController@extornar','is' => 'admin'])->name('admin.conta_corrente.extornar');

        //ContaCorrente - Entradas
        Route::get('entradas', 'ContaCorrenteController@entradas')->name('admin.conta_corrente.entradas');
        Route::get('entradas/buscarpedido/{id}', 'ContaCorrenteController@getPedido')->name('admin.entradas.buscarpedido');
        Route::post('entradas/registrar','ContaCorrenteController@registrarEntrada')->name('admin.entradas.registrar');

        //ContaCorrente - Saidas
        Route::get('saidas', 'ContaCorrenteController@saidas')->name('admin.conta_corrente.saidas');
        Route::post('saidas/registrar','ContaCorrenteController@registrarSaida')->name('admin.saidas.registrar');

        //Caixa
        Route::any('caixa', 'CaixaController@index')->name('admin.caixa');
        Route::post('caixa/abrir', 'CaixaController@abrir')->name('admin.caixa.abrir');
        Route::put('caixa/fechar', 'CaixaController@fechar')->name('admin.caixa.fechar');
    });

Auth::routes();
