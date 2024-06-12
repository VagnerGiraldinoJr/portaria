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

                {{ Form::open(['route' => 'admin.visitante.store', 'method' => 'POST']) }}
                <div class="container">
                    <br>
                    <div class="row">
                        <div class="form-group col-12 col-md-6">
                            <label for="nome">Nome:</label>
                            <input type="text" name="nome" id="nome" class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="documento">Documento:</label>
                            <input type="text" name="documento" id="documento" class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="placa_do_veiculo">Placa do Veículo:</label>
                            <input type="text" name="placa_do_veiculo" id="placa_do_veiculo" class="form-control"
                                required>
                        </div>
 
                        <div class="form-group col-12 col-md-6">
                            <label for="lote_id">Unidade Visitada:</label>
                            <select name="lote_id" id="lote_id" class="form-control">
                                <option value="" disabled selected>Selecione Unidade</option>
                                @foreach ($lotes as $lote)
                                <option value="{{ $lote->id }}">{{ $lote->descricao }}</option>
                                @endforeach     
                            </select>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="hora_de_entrada">Hora de Entrada:</label>
                            <input type="datetime-local" name="hora_de_entrada" id="hora_de_entrada"
                                class="form-control" required>
                        </div>

                        <div class="form-group col-12">
                            {{ Form::submit('Salvar', ['class' => 'btn btn-success btn-sm']) }}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</section>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="{{ asset('js/plugin/jquery.js') }}"></script>
<script src="{{ asset('plugin/jquery.mask.min.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>
@stop