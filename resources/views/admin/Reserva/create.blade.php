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
                                <label for="area">Escolha a Área</label>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="area" id="area1"
                                                value="ACADEMIA" required>
                                            <label class="form-check-label" for="area1">
                                                ACADEMIA
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="area" id="area2"
                                                value="ESPAÇO GOURMET - PRINCIPAL" required>
                                            <label class="form-check-label" for="area2">
                                                ESPAÇO GOURMET - PRINCIPAL
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="area" id="area3"
                                                value="SALÃO DE FESTAS" required>
                                            <label class="form-check-label" for="area3">
                                                SALÃO DE FESTAS
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


                            <div class="form-group row align-items-center">
                                <div class="col-12 col-md-4">
                                    <label for="data_inicio">Data e Hora de Início</label>
                                    <input type="datetime-local" name="data_inicio" id="data_inicio" class="form-control"
                                        required>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="data_fim">Data e Hora de Término</label>
                                    <input type="datetime-local" name="data_fim" id="data_fim" class="form-control"
                                        required>
                                </div>
                                <div class="col-12 col-md-4">
                                    <label for="limpeza">Limpeza</label>
                                    <select name="limpeza" id="limpeza" class="form-control" required>
                                        <option value="IsentoTaxaLimpesa">O Morador irá limpar após o uso</option>
                                        <option value="CobrarTaxaLimpesa">Será limpo pelo condomínio</option>
                                    </select>
                                </div>
                              
                            <th>
                                <div class="col-12 col-md-4">
                                    <label for="lote_id">Unidade/Apto.</label>
                                    {{ Form::select('lote_id', $preload['lote_id'], isset($data->lote_id) ? $data->lote_id : null, [
                                        'class' => 'form-control',
                                    ]) }}
                                </div>
                                {{-- Status Reserva --}}
                                <div class="col-12 col-md-4">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="Pendente">Pendente</option>
                                        <option value="Confirmada">Confirmada</option>
                                        <option value="Cancelada">Cancelada</option>
                                    </select>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">Criar Reserva</button>
                            <div class="mb-4"></div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </section>
@stop


@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('.form-check-input').on('change', function() {
                let areaId = $(this).attr('id');
                let message = '';

                switch (areaId) {
                    case 'area1':
                        message = 'Para ACADEMIA tem um custo de R$ 100';
                        break;
                    case 'area2':
                        message = 'Para ESPAÇO GOURMET - PRINCIPAL tem um custo de R$ 100';
                        break;
                    case 'area3':
                        message = 'Para SALÃO DE FESTAS tem um custo de R$ 100';
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
