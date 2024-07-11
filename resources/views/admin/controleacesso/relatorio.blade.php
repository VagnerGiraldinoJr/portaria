<!-- resources/views/controle_acessos/relatorio.blade.php -->

@extends('adminlte::page')

@section('title', 'Relatório de Controle de Acessos')

@section('content_header')
    <h1>Relatório de Controle de Acessos</h1>
@stop

@section('content')
    <form method="GET" action="{{ route('admin.controleacesso.index') }}">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="unidade_id">Unidade</label>
                    <input type="text" name="unidade_id" id="unidade_id" class="form-control"
                        value="{{ request('unidade_id') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <input type="text" name="tipo" id="tipo" class="form-control" value="{{ request('tipo') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="data_entrada">Data de Entrada</label>
                    <input type="date" name="data_entrada" id="data_entrada" class="form-control"
                        value="{{ request('data_entrada') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="data_saida">Data de Saída</label>
                    <input type="date" name="data_saida" id="data_saida" class="form-control"
                        value="{{ request('data_saida') }}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Unidade</th>
                <th>Tipo</th>
                <th>Data de Entrada</th>
                <th>Data de Saída</th>
                <th>Motorista</th>
                <th>Motivo</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($controleAcessos as $acesso)
                <tr>
                    <td>{{ $acesso->id }}</td>
                    <td>{{ $acesso->unidade_id }}</td>
                    <td>{{ $acesso->tipo }}</td>
                    <td>{{ \Carbon\Carbon::parse($acesso->data_entrada)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ \Carbon\Carbon::parse($acesso->data_saida)->format('d/m/Y H:i:s') }}</td>
                    <td>{{ $acesso->motorista }}</td>
                    <td>{{ $acesso->motivo }}</td>
                    <td>{{ $acesso->observacao }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
