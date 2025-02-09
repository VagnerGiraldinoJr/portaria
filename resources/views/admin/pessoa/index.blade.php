@extends('adminlte::page')
@section('title', config('admin.title'))
@section('content_header')
    @include('admin.layouts.header')
@stop
@section('content')
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
                                <a href="{{ route($params['main_route'] . '.create') }}" class="btn btn-primary btn-xs"><span
                                        class="fas fa-plus"></span> Novo Cadastro</a>
                            </div>
                            
                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        @if (isset($data) && count($data))
                            <table id="dataTablePortaria" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>RG</th>
                                        <th>Nr Celular</th>
                                        <th>Nome Completo</th>
                                        <th>E-mail</th>
                                        <th>Tipo</th>
                                        <th>Unidade</th>
                                        <th>Operações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->rg }}</td>
                                            <td>{{ $item->celular }}</td>
                                            <td>{{ $item->nome_completo }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->desc_tipo }}</td>
                                            <td>{{ $item->lote->descricao }}</td>

                                            <td>
                                                <a href="{{ route($params['main_route'] . '.edit', $item->id) }}"
                                                    class="btn btn-primary btn-xs"><span class="fas fa-edit"></span>
                                                    Editar</a>                                               
                                                    @role('admin')
                                                    <a href="{{ route($params['main_route'] . '.show', $item->id) }}"
                                                        class="btn btn-danger btn-xs">
                                                        <span class="fas fa-trash"></span> Deletar
                                                    </a>
                                                @endrole
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-success m-2" role="alert">
                                Nenhuma informação cadastrada.
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
@section('plugins.Datatables', true)
@stop
@section('js')
<script>
    $(document).ready(function() {
        var table = $('#dataTablePortaria').DataTable({
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
