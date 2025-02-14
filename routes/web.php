<?php

use App\Http\Controllers\Admin\ControleAcessoController;
use App\Http\Controllers\Admin\ReservaController;
use App\Http\Controllers\Admin\ReservaPiscinaController;
use App\Http\Controllers\Admin\CalendarioController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\LoteController;
use App\Http\Controllers\Admin\PassagemTurnoController;
use App\Http\Controllers\Admin\PessoaController;
use App\Http\Controllers\Admin\UnidadeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VeiculoController;
use App\Http\Controllers\Admin\VisitanteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// 🔹 Closure por redirect automático
Route::redirect('/', '/admin');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'acl']], function () {
    Route::get('/', [IndexController::class, 'index'])->name('admin');
    Route::get('/home', [IndexController::class, 'index'])->name('home');

    // User
    Route::get('user', [UserController::class, 'index'])->name('admin.user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::get('user/show/{id}', [UserController::class, 'show'])->name('admin.user.show');
    Route::put('user/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('user/destroy/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    //Veiculos
    Route::get('veiculo', [VeiculoController::class, 'index'])->name('admin.veiculo.index');
    Route::get('veiculo/create', [VeiculoController::class, 'create'])->name('admin.veiculo.create');
    Route::post('veiculo/store', [VeiculoController::class, 'store'])->name('admin.veiculo.store');
    Route::get('veiculo/edit/{id}', [VeiculoController::class, 'edit'])->name('admin.veiculo.edit');
    Route::get('veiculo/show/{id}', [VeiculoController::class, 'show'])->name('admin.veiculo.show');
    Route::put('veiculo/update/{id}', [VeiculoController::class, 'update'])->name('admin.veiculo.update');
    Route::delete('veiculo/destroy/{id}', [VeiculoController::class, 'destroy'])->name('admin.veiculo.destroy');

    //Pessoas
    Route::get('pessoa', [PessoaController::class, 'index'])->name('admin.pessoa.index');
    Route::get('pessoa/create', [PessoaController::class, 'create'])->name('admin.pessoa.create');
    Route::post('pessoa/store', [PessoaController::class, 'store'])->name('admin.pessoa.store');
    Route::get('pessoa/edit/{id}', [PessoaController::class, 'edit'])->name('admin.pessoa.edit');
    Route::get('pessoa/show/{id}', [PessoaController::class, 'show'])->name('admin.pessoa.show');
    Route::put('pessoa/update/{id}', [PessoaController::class, 'update'])->name('admin.pessoa.update');
    Route::delete('pessoa/destroy/{id}', [PessoaController::class, 'destroy'])->name('admin.pessoa.destroy');
    Route::delete('pessoa/{id}', [PessoaController::class, 'destroy'])->name('admin.pessoa.destroy');
    Route::get('pessoa/get-pessoas-by-lote', [PessoaController::class, 'getPessoasByLote'])->name('admin.pessoa.getPessoasByLote');
    Route::get('pessoa/relatorio', [PessoaController::class, 'relatorio'])->name('admin.pessoa.relatorio');

    //Unidades de acesso - Filiais
    Route::get('unidade', [UnidadeController::class, 'index'])->name('admin.unidade.index');
    Route::get('unidade/create', [UnidadeController::class, 'create'])->name('admin.unidade.create');
    Route::post('unidade/store', [UnidadeController::class, 'store'])->name('admin.unidade.store');
    Route::get('unidade/edit/{id}', [UnidadeController::class, 'edit'])->name('admin.unidade.edit');
    Route::get('unidade/show/{id}', [UnidadeController::class, 'show'])->name('admin.unidade.show');
    Route::put('unidade/update/{id}', [UnidadeController::class, 'update'])->name('admin.unidade.update');
    Route::delete('unidade/destroy/{id}', [UnidadeController::class, 'destroy'])->name('admin.unidade.destroy');

    //Lotes
    Route::get('lote', [LoteController::class, 'index'])->name('admin.lote.index');
    Route::get('lote/create', [LoteController::class, 'create'])->name('admin.lote.create');
    Route::post('lote/store', [LoteController::class, 'store'])->name('admin.lote.store');
    Route::get('lote/edit/{id}', [LoteController::class, 'edit'])->name('admin.lote.edit');
    Route::get('lote/show/{id}', [LoteController::class, 'show'])->name('admin.lote.show');
    Route::put('lote/update/{id}', [LoteController::class, 'update'])->name('admin.lote.update');
    Route::delete('lote/destroy/{id}', [LoteController::class, 'destroy'])->name('admin.lote.destroy');


    //ControleAcesso
    Route::get('controleacesso', [ControleAcessoController::class, 'index'])->name('admin.controleacesso.index');
    Route::get('controleacesso/create', [ControleAcessoController::class, 'create'])->name('admin.controleacesso.create');
    Route::post('controleacesso/store', [ControleAcessoController::class, 'store'])->name('admin.controleacesso.store');
    Route::get('controleacesso/edit/{id}', [ControleAcessoController::class, 'edit'])->name('admin.controleacesso.edit');
    Route::get('controleacesso/show/{id}', [ControleAcessoController::class, 'show'])->name('admin.controleacesso.show');
    Route::put('controleacesso/update/{id}', [ControleAcessoController::class, 'update'])->name('admin.controleacesso.update');
    Route::delete('controleacesso/destroy/{id}', [ControleAcessoController::class, 'destroy'])->name('admin.controleacesso.destroy');
    Route::get('controle_acessos/get-moradores-by-lote', [ControleAcessoController::class, 'getMoradoresByLote'])->name('controle_acessos.getMoradoresByLote');
    Route::get('controle_acessos/get-morador-detalhes', [ControleAcessoController::class, 'getMoradorDetalhes'])->name('controle_acessos.getMoradorDetalhes');
    Route::get('controleacesso/registrar-saida/{id}', [ControleAcessoController::class, 'registrarSaida'])->name('controleacesso.registrarSaida');
    Route::get('controleacesso/sair/{id}', [ControleAcessoController::class, 'sair'])->name('admin.controleacesso.sair');
    Route::put('controleacesso/sair/{id}', [ControleAcessoController::class, 'updatesair'])->name('admin.controleacesso.updatesair');

    //Controles Visitantes
    Route::get('visitante', [VisitanteController::class, 'index'])->name('admin.visitante.index');
    Route::get('visitante/create', [VisitanteController::class, 'create'])->name('admin.visitante.create');
    Route::post('visitante/store', [VisitanteController::class, 'store'])->name('admin.visitante.store');
    Route::get('visitante/edit/{id}', [VisitanteController::class, 'edit'])->name('admin.visitante.edit');
    Route::get('visitante/show/{id}', [VisitanteController::class, 'show'])->name('admin.visitante.show');
    Route::put('visitante/update/{id}', [VisitanteController::class, 'update'])->name('admin.visitante.update');
    Route::delete('visitante/destroy/{id}', [VisitanteController::class, 'destroy'])->name('admin.visitante.destroy');
    Route::get('visitante/exit/{id}', [VisitanteController::class, 'exit'])->name('admin.visitante.exit');
    Route::put('visitante/exit/{id}', [VisitanteController::class, 'updateexit'])->name('admin.visitante.updateexit');

    //Controle de Reservas
    Route::get('reserva', [ReservaController::class, 'index'])->name('admin.reserva.index');
    Route::get('reserva/create', [ReservaController::class, 'create'])->name('admin.reserva.create');
    Route::post('reserva/store', [ReservaController::class, 'store'])->name('admin.reserva.store');
    Route::get('reserva/edit/{id}', [ReservaController::class, 'edit'])->name('admin.reserva.edit');
    Route::get('reserva/show/{id}', [ReservaController::class, 'show'])->name('admin.reserva.show');
    Route::put('reserva/update/{id}', [ReservaController::class, 'update'])->name('admin.reserva.update');
    Route::delete('reserva/destroy/{id}', [ReservaController::class, 'destroy'])->name('admin.reserva.destroy');
    Route::get('relatorio', [ReservaController::class, 'relatorio'])->name('relatorio');

    //Rota para retirar as chaves na portaria
    Route::put('reserva/retire/{id}', [ReservaController::class, 'retire'])->name('admin.reserva.retire');
    Route::get('reserva/retire/{id}', [ReservaController::class, 'showRetireForm'])->name('admin.reserva.showRetireForm');

    //Rota para devolver as chaves na portaria
    Route::put('reserva/return/{id}', [ReservaController::class, 'return'])->name('admin.reserva.return');
    Route::get('reserva/return/{id}', [ReservaController::class, 'showReturnForm'])->name('admin.reserva.showReturnForm');
    Route::get('reserva/return/update/{id}', [ReservaController::class, 'updateReturn'])->name('admin.reserva.updateReturn');

    // Controle de Reservas da Piscina
    Route::get('reserva/piscina', [ReservaPiscinaController::class, 'index'])->name('admin.reserva.piscina.index');
    Route::get('reserva/piscina/create', [ReservaPiscinaController::class, 'create'])->name('admin.reserva.piscina.create');
    Route::post('reserva/piscina/store', [ReservaPiscinaController::class, 'store'])->name('admin.reserva.piscina.store');
    Route::put('reserva/piscina/update/{id}', [ReservaPiscinaController::class, 'update'])->name('admin.reserva.piscina.update');
    Route::delete('reserva/piscina/destroy/{id}', [ReservaPiscinaController::class, 'destroy'])->name('admin.reserva.piscina.destroy');

    // Rota para retirar as chaves da piscina na portaria
    Route::get('reserva/piscina/retire/{id}', [ReservaPiscinaController::class, 'showRetireForm'])->name('admin.reserva.piscina.showRetireForm');
    Route::put('reserva/piscina/retire/{id}', [ReservaPiscinaController::class, 'retire'])->name('admin.reserva.piscina.retire');

    // Rota para devolver as chaves da piscina na portaria
    Route::put('reserva/piscina/return/{id}', [ReservaPiscinaController::class, 'return'])->name('admin.reserva.piscina.return');
    Route::get('reserva/piscina/return/{id}', [ReservaPiscinaController::class, 'showReturnForm'])->name('admin.reserva.piscina.showReturnForm');

    //Controle de passagem de turno nos Condominios

    Route::get('passagem_turno', [PassagemTurnoController::class, 'index'])->name('admin.passagem_turno.index');
    Route::get('passagem_turno/create', [PassagemTurnoController::class, 'create'])->name('admin.passagem_turno.create');
    Route::post('passagem_turno/store', [PassagemTurnoController::class, 'store'])->name('admin.passagem_turno.store');

    // Gerenciamento do Calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('admin.calendario.index');
    Route::get('/calendario/create', [CalendarioController::class, 'create'])->name('admin.calendario.create');
    Route::post('/calendario', [CalendarioController::class, 'store'])->name('admin.calendario.store');
    Route::get('/calendario/{id}', [CalendarioController::class, 'show'])->name('admin.calendario.show');
    Route::get('/calendario/{id}/edit', [CalendarioController::class, 'edit'])->name('admin.calendario.edit');
    Route::put('/calendario/{id}', [CalendarioController::class, 'update'])->name('admin.calendario.update');
    Route::delete('/calendario/{id}', [CalendarioController::class, 'destroy'])->name('admin.calendario.destroy');

    // Gerenciamento de inadimplência de lotes

    Route::get('lote/{id}/inadimplencia', [LoteController::class, 'inadimplencia'])->name('admin.lote.inadimplencia');
    Route::post('lote/{id}/marcar-inadimplente', [LoteController::class, 'marcarInadimplente'])->name('admin.lote.marcarInadimplente');
    Route::post('lote/{id}/regularizar', [LoteController::class, 'regularizar'])->name('admin.lote.regularizar');

    Route::get('/admin/lotes/busca', [LoteController::class, 'buscarLotes'])->name('admin.lotes.busca');
});

Auth::routes();
