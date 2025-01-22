@extends('adminlte::page')
@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">{{ $params['subtitulo'] }}</h3>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route($params['main_route'] . '.index') }}" class="btn btn-primary btn-xs">
                                    <span class="fas fa-arrow-left"></span> Voltar
                                </a>
                            </div>
                        </div>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.reserva.store') }}" method="POST">
                        @csrf
                        <div class="mb-4"></div>
                        <div class="container-sm">
                            {{-- Início Escolha áreas comuns --}}
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group align-items-center">
                                            <label for="area" class="mb-2">Área</label>
                                            <select class="form-control" name="area" id="area" required>
                                                <option value="QUIOSQUE 01">QUIOSQUE Nrº 01</option>
                                                <option value="QUIOSQUE 02">QUIOSQUE Nrº 02</option>
                                                <option value="QUIOSQUE 03">QUIOSQUE Nrº 03</option>
                                                <option value="SALÃO DE JOGOS">SALÃO DE JOGOS</option>
                                                <option value="SALÃO DE FESTAS">SALÃO DE FESTAS</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Fim Escolha áreas comuns --}}
                            <!--Início Modal -->
                            <div class="modal fade" id="alertModal" tabindex="-1" role="dialog"
                                aria-labelledby="alertModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="alertModalLabel">Alerta de Custo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" id="alertModalBody">
                                            <!-- O conteúdo do alerta será inserido aqui via jQuery -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary"
                                                data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Final Modal -->
                            {{-- Inicio Campos Imput --}}

                            <div class="form-group row align-items-center">
                                <div class="col-12 col-md-4 mb-3">
                                    <label for="data_inicio" class="mb-2">Data Reserva</label>
                                    <input type="date" name="data_inicio" id="data_inicio" class="form-control" required>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="limpeza" class="mb-2">Limpeza</label>
                                    <select name="limpeza" id="limpeza" class="form-control" required>
                                        <option value="IsentoTaxaLimpeza">O Morador irá limpar.</option>
                                        <option value="CobrarTaxaLimpeza">Condomínio fará a limpeza.</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="lote_id" class="mb-2">Lote</label>
                                    <select name="lote_id" id="lote_id" class="form-control" required>
                                        @foreach ($lotes as $lote)
                                            <option value="{{ $lote->id }}">{{ $lote->descricao }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="status" class="mb-2">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="Pendente">Pendente</option>
                                        <option value="Confirmada">Confirmada</option>
                                        <option value="Cancelada">Cancelada</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="acessorios" class="mb-2"><i class="fas fa-plus"></i>
                                        Itens Reserva</label>
                                    <select name="acessorios" id="acessorios" class="form-control" required>
                                        <option value="Grelha">Grelha</option>
                                        <option value="N/A">N/A</option>
                                        <option value="Talheres">Talheres</option>
                                    </select>
                                </div>

                                <div class="col-12 col-md-4 mb-3">
                                    <label for="celular_responsavel" class="mb-2">
                                        <i class="fas fa-mobile-alt"></i> Celular Responsável Reserva
                                    </label>
                                    <input type="text" name="celular_responsavel" id="celular_responsavel"
                                        class="form-control" placeholder="(DDD) 9 9999-9999" required>
                                </div>
                            </div>

                            {{-- Fim Campos Imput --}}

                            <button type="submit" class="btn btn-success mt-3 mb-3">Criar Reserva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop
@section('css')
    <link rel="stylesheet" href="/css/style.css">
@stop
@section('js')
    <script>
        $(document).ready(function() {
            $('#celular_responsavel').mask('(00) 0 0000-0000');
        });
    </script>
    <script src="{{ asset('js/plugin/jquery.js') }}"></script>
    <script src="{{ asset('plugin/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
@stop
