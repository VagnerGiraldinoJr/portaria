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
                        <h3 class="card-title font-weight-bold">{{ $params['subtitulo'] ?? 'Cadastrar Evento' }}</h3>
                        <div class="text-right">
                            <a href="{{ route($params['main_route'].'.index') }}" class="btn btn-secondary btn-xs">
                                <span class="fas fa-arrow-left"></span> Voltar
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ Form::open(['route' => $params['main_route'].'.store', 'method' => 'post', 'class' => 'form']) }}
                        <div class="row">
                            <div class="col-md-6">
                                {{ Form::label('title', 'Título do Evento') }}
                                {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Digite o título do evento', 'required']) }}
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('start', 'Data de Início') }}
                                {{ Form::date('start', null, ['class' => 'form-control', 'required']) }}
                            </div>
                            <div class="col-md-3">
                                {{ Form::label('end', 'Data de Término') }}
                                {{ Form::date('end', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                {{ Form::label('description', 'Descrição') }}
                                {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'Adicione uma descrição para o evento']) }}
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12 text-right">
                                {{ Form::submit('Salvar Evento', ['class' => 'btn btn-success']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <style>
        .card {
            margin-top: 20px;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Tela de cadastro de evento carregada.');
    </script>
@stop
