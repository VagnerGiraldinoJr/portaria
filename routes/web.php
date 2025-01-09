<?php

use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\PassagemTurnoController;
use App\Http\Controllers\Admin\ControleAcessoController;
use App\Http\Controllers\Admin\ReservaController;
use App\Http\Controllers\Admin\ReservaPiscinaController;
use App\Http\Controllers\Admin\CalendarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'acl'], 'namespace' => 'Admin'], function () {
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
    //Route::get('orcamento/show/{id}', 'OrcamentoController@show')->name('admin.orcamento.show');
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
    Route::get('user', ['uses' => 'UserController@index'])->name('admin.user.index');
    Route::get('user/create', ['uses' => 'UserController@create'])->name('admin.user.create');
    Route::post('user/store', ['uses' => 'UserController@store'])->name('admin.user.store');
    Route::get('user/edit/{id}', ['uses' => 'UserController@edit'])->name('admin.user.edit');
    Route::get('user/show/{id}', ['uses' => 'UserController@show'])->name('admin.user.show');
    Route::put('user/update/{id}', ['uses' => 'UserController@update'])->name('admin.user.update');
    Route::delete('user/destroy/{id}', ['uses' => 'UserController@destroy'])->name('admin.user.destroy');

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

    // Contatos
    Route::get('contato', 'ContatoController@index')->name('admin.contato.index');
    Route::get('contato/create', 'ContatoController@create')->name('admin.contato.create');
    Route::post('contato/store/{pessoa_id}', 'ContatoController@store')->name('admin.contato.store');
    Route::get('contato/edit/{id}', 'ContatoController@edit')->name('admin.contato.edit');
    Route::get('contato/show/{id}', 'ContatoController@show')->name('admin.contato.show');
    Route::put('contato/update/{id}', 'ContatoController@update')->name('admin.contato.update');
    Route::delete('contato/destroy/{id}', 'ContatoController@destroy')->name('admin.contato.destroy');

    //Unidades de acesso - Filiais
    Route::get('unidade', 'UnidadeController@index')->name('admin.unidade.index');
    Route::get('unidade/create', 'UnidadeController@create')->name('admin.unidade.create');
    Route::post('unidade/store', 'UnidadeController@store')->name('admin.unidade.store');
    Route::get('unidade/edit/{id}', 'UnidadeController@edit')->name('admin.unidade.edit');
    Route::get('unidade/show/{id}', 'UnidadeController@show')->name('admin.unidade.show');
    Route::put('unidade/update/{id}', 'UnidadeController@update')->name('admin.unidade.update');
    Route::delete('unidade/destroy/{id}', 'UnidadeController@destroy')->name('admin.unidade.destroy');

    //Lotes
    Route::get('lote', 'LoteController@index')->name('admin.lote.index');
    Route::get('lote/create', 'LoteController@create')->name('admin.lote.create');
    Route::post('lote/store', 'LoteController@store')->name('admin.lote.store');
    Route::get('lote/edit/{id}', 'LoteController@edit')->name('admin.lote.edit');
    Route::get('lote/show/{id}', 'LoteController@show')->name('admin.lote.show');
    Route::put('lote/update/{id}', 'LoteController@update')->name('admin.lote.update');
    Route::delete('lote/destroy/{id}', 'LoteController@destroy')->name('admin.lote.destroy');

    //ControleAcesso
    //Route::get('controleacesso', 'ControleAcessoController@index')->name('admin.controleacesso.index');
    Route::get('controleacesso', [ControleAcessoController::class, 'index'])->name('admin.controleacesso.index');

    Route::get('controleacesso/create', 'ControleAcessoController@create')->name('admin.controleacesso.create');
    Route::post('controleacesso/store', 'ControleAcessoController@store')->name('admin.controleacesso.store');
    Route::get('controleacesso/edit/{id}', 'ControleAcessoController@edit')->name('admin.controleacesso.edit');
    Route::get('controleacesso/relatorio', 'ControleAcessoController@relatorio')->name('admin.controleacesso.relatorio');
    Route::get('controleacesso/fetch','ControleAcessoController@fetchData')->name('admin.controleacesso.fetch');
    
    // Route::get('controleacesso/relatorio', 'ControleAcessoController@relatorio')->name('admin.controleacesso.relatorio');

    // Route::get('controleacesso/buscar/{id}', 'ControleAcessoController@EncomendasNaoEntregues')->name('admin.controleacesso.buscar');
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
    Route::any('baixa_material', ['uses' => 'BaixaMaterialController@index'])->name('admin.baixa_material.index');
    Route::get('baixa_material/create', ['uses' => 'BaixaMaterialController@create'])->name('admin.baixa_material.create');
    Route::post('baixa_material/store', ['uses' => 'BaixaMaterialController@store'])->name('admin.baixa_material.store');
    Route::get('baixa_material/show/{id}', ['uses' => 'BaixaMaterialController@show'])->name('admin.baixa_material.show');
    Route::delete('baixa_material/destroy/{id}', ['uses' => 'BaixaMaterialController@destroy', 'is' => 'admin'])->name('admin.baixa_material.destroy');

    //Estoque
    Route::any('estoque/inventario', 'EstoqueController@index')->name('admin.estoque.inventario');

    //Conta Corrente
    Route::any('contacorrente', 'ContaCorrenteController@index')->name('admin.conta_corrente.index');
    Route::get('contacorrente/show/{id}', 'ContaCorrenteController@show')->name('admin.conta_corrente.show');
    Route::post('contacorrente/extornar/{id}', ['ContaCorrenteController@extornar', 'is' => 'admin'])->name('admin.conta_corrente.extornar');

    //ContaCorrente - Entradas
    Route::get('entradas', 'ContaCorrenteController@entradas')->name('admin.conta_corrente.entradas');
    Route::get('entradas/buscarpedido/{id}', 'ContaCorrenteController@getPedido')->name('admin.entradas.buscarpedido');
    Route::post('entradas/registrar', 'ContaCorrenteController@registrarEntrada')->name('admin.entradas.registrar');

    //ContaCorrente - Saidas
    Route::get('saidas', 'ContaCorrenteController@saidas')->name('admin.conta_corrente.saidas');
    Route::post('saidas/registrar', 'ContaCorrenteController@registrarSaida')->name('admin.saidas.registrar');

    //Caixa
    Route::any('caixa', 'CaixaController@index')->name('admin.caixa');
    Route::post('caixa/abrir', 'CaixaController@abrir')->name('admin.caixa.abrir');
    Route::put('caixa/fechar', 'CaixaController@fechar')->name('admin.caixa.fechar');

    //Controles Visitantes
    Route::get('visitante', 'VisitanteController@index')->name('admin.visitante.index');
    Route::get('visitante/create', 'VisitanteController@create')->name('admin.visitante.create');
    Route::post('visitante/store', 'VisitanteController@store')->name('admin.visitante.store');
    Route::get('visitante/edit/{id}', 'VisitanteController@edit')->name('admin.visitante.edit');
    Route::get('visitante/show/{id}', 'VisitanteController@show')->name('admin.visitante.show');
    Route::put('visitante/update/{id}', 'VisitanteController@update')->name('admin.visitante.update');
    Route::delete('visitante/destroy/{id}', 'VisitanteController@destroy')->name('admin.visitante.destroy');
    Route::get('visitante/exit/{id}', 'VisitanteController@exit')->name('admin.visitante.exit');
    Route::put('visitante/exit/{id}', 'VisitanteController@updateexit')->name('admin.visitante.updateexit');

    //Controle de Reservas no Condominio
    Route::get('reserva', [ReservaController::class, 'index'])->name('admin.reserva.index');
    Route::get('reserva/create', [ReservaController::class, 'create'])->name('admin.reserva.create');
    Route::post('reserva/store', [ReservaController::class, 'store'])->name('admin.reserva.store');
    Route::get('reserva/edit/{id}', [ReservaController::class, 'edit'])->name('admin.reserva.edit');
    Route::get('reserva/show/{id}', [ReservaController::class, 'show'])->name('admin.reserva.show');
    Route::get('reserva/exit/{id}', [ReservaController::class, 'exit'])->name('admin.reserva.exit');
    Route::put('reserva/exit/{id}', [ReservaController::class, 'updateExit'])->name('admin.reserva.updateExit');
    Route::put('reserva/update/{id}', [ReservaController::class, 'update'])->name('admin.reserva.update');
    Route::get('reserva/relatorio', 'ReservaController@relatorio')->name('admin.reserva.relatorio');
    //Route::delete('reserva/{id}', [ReservaController::class, 'destroy'])->name('admin.reserva.destroy');
    Route::delete('reserva/destroy/{id}', 'ReservaController@destroy')->name('admin.reserva.destroy');

    // Controle de Reservas da Piscina
    Route::get('reserva/piscina', [ReservaPiscinaController::class, 'index'])->name('admin.reserva.piscina.index');
    Route::get('reserva/piscina/create', [ReservaPiscinaController::class, 'create'])->name('admin.reserva.piscina.create');
    Route::post('reserva/piscina/store', [ReservaPiscinaController::class, 'store'])->name('admin.reserva.piscina.store');
    // Route::delete('reserva/piscina/{id}', [ReservaController::class, 'destroy'])->name('admin.reserva.piscina.destroy');
    Route::delete('reserva/piscina/destroy/{id}', 'ReservaPiscinaController@destroy')->name('admin.reserva.piscina.destroy');

    //Rota para retirar as chaves na portaria
    Route::put('reserva/retire/{id}', [ReservaController::class, 'retire'])->name('admin.reserva.retire');
    Route::get('reserva/retire/{id}', [ReservaController::class, 'showRetireForm'])->name('admin.reserva.showRetireForm');

    //Rota para devolver as chaves na portaria
    Route::put('reserva/return/{id}', [ReservaController::class, 'return'])->name('admin.reserva.return');
    Route::get('reserva/return/{id}', [ReservaController::class, 'showReturnForm'])->name('admin.reserva.showReturnForm');
    Route::get('reserva/update/{id}', [ReservaController::class, 'updateReturn'])->name('admin.reserva.updateReturn');

    //Controle de passagem de turno nos Condominios

    Route::get('passagem_turno', 'PassagemTurnoController@index')->name('admin.passagem_turno.index');
    Route::get('passagem_turno/create', 'PassagemTurnoController@create')->name('admin.passagem_turno.create');
    Route::post('passagem_turno/store', 'PassagemTurnoController@store')->name('admin.passagem_turno.store');



    // Gerenciamento do Calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('admin.calendario.index');
    Route::get('/calendario/create', [CalendarioController::class, 'create'])->name('admin.calendario.create');
    Route::post('/calendario', [CalendarioController::class, 'store'])->name('admin.calendario.store');
    Route::get('/calendario/{id}', [CalendarioController::class, 'show'])->name('admin.calendario.show');
    Route::get('/calendario/{id}/edit', [CalendarioController::class, 'edit'])->name('admin.calendario.edit');
    Route::put('/calendario/{id}', [CalendarioController::class, 'update'])->name('admin.calendario.update');
    Route::delete('/calendario/{id}', [CalendarioController::class, 'destroy'])->name('admin.calendario.destroy');


    // Gerenciamento de inadimplência de lotes
    Route::get('lote/{id}/inadimplencia', 'LoteController@inadimplencia')->name('admin.lote.inadimplencia');
    Route::post('lote/{id}/marcar-inadimplente', 'LoteController@marcarInadimplente')->name('admin.lote.marcarInadimplente');
    Route::post('lote/{id}/regularizar', 'LoteController@regularizar')->name('admin.lote.regularizar');
});

Auth::routes();
