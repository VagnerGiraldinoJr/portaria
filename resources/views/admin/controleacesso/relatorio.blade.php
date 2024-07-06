<!-- resources/views/admin/controleacesso/relatorio.blade.php -->

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
                            <form method="GET" action="{{ route('controleacesso.relatorio') }}" class="d-inline">
                                <!-- Manter os filtros ao exportar -->
                                <input type="hidden" name="unidade_id" value="{{ request('unidade_id') }}">
                                <input type="hidden" name="tipo" value="{{ request('tipo') }}">
                                <input type="hidden" name="data_entrada" value="{{ request('data_entrada') }}">
                                <input type="hidden" name="data_saida" value="{{ request('data_saida') }}">
                            
                            </form>
                            <form method="GET" action="{{ route('controleacesso.relatorio') }}" class="d-inline">
                                <!-- Manter os filtros ao exportar -->
                                <input type="hidden" name="unidade_id" value="{{ request('unidade_id') }}">
                                <input type="hidden" name="tipo" value="{{ request('tipo') }}">
                                <input type="hidden" name="data_entrada" value="{{ request('data_entrada') }}">
                                <input type="hidden" name="data_saida" value="{{ request('data_saida') }}">
                                {{-- <button type="submit" name="export_pdf" class="btn btn-danger btn-xs">
                                    <span class="fas fa-file-pdf"></span> Exportar PDF
                                </button> --}}
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Filtros para o Relatório -->
                    <form method="GET" action="{{ route('controleacesso.relatorio') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="unidade_id">Unidade</label>
                                    <input type="text" name="unidade_id" id="unidade_id" class="form-control" value="{{ request('unidade_id') }}">
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
                                    <input type="date" name="data_entrada" id="data_entrada" class="form-control" value="{{ request('data_entrada') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="data_saida">Data de Saída</label>
                                    <input type="date" name="data_saida" id="data_saida" class="form-control" value="{{ request('data_saida') }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </form>

                    <!-- Tabela de Resultados do Relatório -->
                    @if(isset($controleAcessos) && count($controleAcessos))
                    <table class="table table-bordered table-striped mt-4">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Unidade</th>
                                <th>Tipo</th>
                                <th>Data de Entrada</th>
                                <th>Data de Saída</th>
                                
                                <th>Motivo</th>
                                <th>Observação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($controleAcessos as $acesso)
                                <tr>
                                    <td>{{ $acesso->id }}</td>
                                    <td>{{ $acesso->unidade_id }}</td>
                                    <td>{{ $acesso->tipo }}</td>
                                    <td>{{ $acesso->data_entrada }}</td>
                                    <td>{{ $acesso->data_saida }}</td>
                                    
                                    <td>{{ $acesso->motivo }}</td>
                                    <td>{{ $acesso->observacao }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="alert alert-success m-2" role="alert">
                        Nenhuma informação encontrada.
                    </div>
                    @endif
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
</section>

@stop

@section('css')
<link rel="stylesheet" href="/css/style.css">
@stop

@section('plugins.Datatables', true)

@section('js')
<script>
$(document).ready(function() {
    $('#dataTablePortaria').DataTable({
        "pageLength": 25,
        "language": {
            "decimal": "",
            "emptyTable": "Dados Indisponiveis na Tabela",
            "info": "Mostrando _START_ de _END_ do _TOTAL_ linhas",
            "infoEmpty": "Mostrando 0 linhas",
            "infoFiltered": "(filtrando _MAX_ total de linhas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrando _MENU_ linhas",
            "loadingRecords": "Carregando...",
            "processing": "Processando...",
            "search": "Busca:",
            "zeroRecords": "Nenhum resultado encontrado",
            "paginate": {
                "first": "Primeiro",
                "last": "Ultimo",
                "next": "Proximo",
                "previous": "Anterior"
            },
        }
    });
});
</script>
@stop
