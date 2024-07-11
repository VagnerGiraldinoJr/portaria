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
                                <label for="area" class="mb-2">Escolha a Área</label>
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="area" id="area1"
                                                value="QUIOSQUE 01" required>
                                            <label class="form-check-label" for="area1">
                                                QUIOSQUE 01
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="area" id="area2"
                                                value="QUIOSQUE 02" required>
                                            <label class="form-check-label" for="area2">
                                                QUIOSQUE 02
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="area" id="area3"
                                                value="QUIOSQUE 03" required>
                                            <label class="form-check-label" for="area3">
                                                QUIOSQUE 03
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="area" id="area4"
                                                value="SALÃO DE FESTAS" required>
                                            <label class="form-check-label" for="area4">
                                                SALÃO DE FESTAS
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="area" id="area5"
                                                value="PISCINA - MANHÃ" required>
                                            <label class="form-check-label" for="area5">
                                                PISCINA - MANHÃ
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="area" id="area6"
                                                value="PISCINA - TARDE" required>
                                            <label class="form-check-label" for="area6">
                                                PISCINA - TARDE
                                            </label>
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
                                        <option value="IsentoTaxaLimpeza">O Morador irá limpar após o uso do local.</option>
                                        <option value="CobrarTaxaLimpeza">Será limpo pelo condomínio.</option>
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

        $(document).ready(function() {
            $('.form-check-input').on('change', function() {
                let areaId = $(this).attr('id');
                let message = '';
                switch (areaId) {
                    case 'area1':
                        message = 'QUIOSQUE 01 tem custo que será vínculado a unidade no próx. fechamento.';
                        break;
                    case 'area2':
                        message = 'QUIOSQUE 02 tem custo que será vínculado a unidade no próx. fechamento.';
                        break;
                    case 'area3':
                        message = 'QUIOSQUE 03 tem custo que será vínculado a unidade no próx. fechamento.';
                        break;
                    case 'area4':
                        message =
                            'SALÃO DE FESTA tem custo que será vínculado a unidade no próx. fechamento.';
                        break;
                    case 'area5':
                        message =
                            'PISCINA - MANHÃ tem custo que será vínculado a unidade no próx. fechamento.';
                        break;
                    case 'area6:
                        message =
                            'PISCINA - TARDE tem custo que será vínculado a unidade no próx. fechamento.';
                        break;
                }
                $('#alertModalBody').text(message);
                $('#alertModal').modal('show');
            });
        });
    </script>
    <script src="{{ asset('js/plugin/jquery.js') }}"></script>
    <script src="{{ asset('plugin/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
@stop
