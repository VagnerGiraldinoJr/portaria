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
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="m-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($data))
                            {{ Form::model($data, [
                                'route' => [$params['main_route'] . '.update', $data->id],
                                'class' => 'form',
                                'method' => 'put',
                            ]) }}
                        @else
                            {{ Form::open(['route' => $params['main_route'] . '.store', 'method' => 'post']) }}
                        @endif

                        <div class="row">
                            {{-- Campo Unidade (Somente Leitura) --}}
                            <div class="form-group col-6">
                                {{ Form::label('unidade_id', 'Unidade') }}

                                {{-- Exibe o título da unidade no campo --}}
                            <input type="text" class="form-control" value="{{ $unidades[auth()->user()->unidade_id] }}">
                            </div>

                            {{-- Campo Início do Turno --}}
                            <div class="form-group col-6">
                                {{ Form::label('inicio_turno', 'Início do Turno') }}
                                {{ Form::datetimeLocal('inicio_turno', null, ['class' => 'form-control', 'placeholder' => 'Selecione a data e hora do início do turno']) }}
                            </div>

                            {{-- Campo Fim do Turno --}}
                            <div class="form-group col-6">
                                {{ Form::label('fim_turno', 'Fim do Turno') }}
                                {{ Form::datetimeLocal('fim_turno', null, ['class' => 'form-control', 'placeholder' => 'Selecione a data e hora do fim do turno']) }}
                            </div>

                            {{-- Campo Ocorrências --}}
                            <div class="form-group col-12">
                                {{ Form::label('ocorrencias', 'Ocorrências') }}
                                {{ Form::textarea('ocorrencias', null, ['class' => 'form-control', 'placeholder' => 'Descreva as ocorrências durante o turno']) }}
                            </div>

                            {{-- Botão de Salvar --}}
                            <div class="form-group col-12 text-right">
                                {{ Form::submit('Salvar', ['class' => 'btn btn-success btn-sm']) }}
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugin/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugin/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/plugin/jquery.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/plugin/moment/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugin/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function() {
            // Inicializa o DateTimePicker para os campos de data e hora
            $('.datetimepicker').datetimepicker({
                format: 'DD/MM/YYYY HH:mm',
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'fas fa-calendar-check',
                    clear: 'fas fa-trash',
                    close: 'fas fa-times'
                }
            });
        });
    </script>
@stop
