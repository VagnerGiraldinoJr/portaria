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
                                <a href="{{ route($params['main_route'] . '.create') }}" class="btn btn-primary btn-xs">
                                    <span class="fas fa-plus"></span> Novo Cadastro
                                </a>
                                {{-- Botão Geral para listar todos os inadimplentes (Opcional) --}}
                                <a href="{{ route('admin.lote.index') }}" class="btn btn-warning btn-xs">
                                    ⚙️ Ver Inadimplentes
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body table-responsive">
                        @if (isset($data) && count($data))
                            <table id="dataTablePortaria" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Unidade de Cadastro</th>
                                        <th>Descrição Casa/Lote</th>
                                        <th>Status</th>
                                        <th>Data Criação</th>
                                        <th>Operação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $lote)
                                        <tr>
                                            <td>{{ $lote->id }}</td>
                                            <td>{{ $lote->unidade->nome ?? 'N/A' }}</td>
                                            <td>{{ $lote->descricao }}</td>
                                            <td>
                                                @if ($lote->inadimplente)
                                                    <span class="badge bg-danger">Inadimplente</span>
                                                @else
                                                    <span class="badge bg-success">Regular</span>
                                                @endif
                                            </td>
                                            <td>{{ $lote->created_at->format('d/m/Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.lote.inadimplencia', $lote->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    ⚙️ Gerenciar Inadimplência
                                                </a>
                                                <a href="{{ route($params['main_route'] . '.edit', $lote->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    ✏️ Editar
                                                </a>
                                                <form action="{{ route($params['main_route'] . '.destroy', $lote->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">🗑️ Deletar</button>
                                                </form>
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
@stop

@section('plugins.Datatables', true)

@section('js')
    <script>
        $(document).ready(function() {
            var table = $('#dataTablePortaria').DataTable({
                "pageLength": 25,
                "language": {
                    "decimal": "",
                    "emptyTable": "Dados Indisponíveis na Tabela",
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
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                }
            });
        });
    </script>
@stop
