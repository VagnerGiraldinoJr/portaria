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
                                        class="fas fa-plus"></span> Novo
                                    Cadastro</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        @if (isset($data) && count($data))

                            <table id="dataTablePortaria" class="table table-hover">

                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Documento</th>
                                        <th>Placa do Veículo</th>
                                        <th>Unidade Visitada</th>
                                        <th>Hora de Entrada</th>
                                        <th>Hora de Saída</th>
                                        <th>Motivo Entrada ?</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitantes as $visitante)
                                        <tr>
                                            <td>{{ $visitante->nome }}</td>
                                            <td>{{ $visitante->documento }}</td>
                                            <td>{{ $visitante->placa_do_veiculo }}</td>
                                            <td>{{ $visitante->lote ? $visitante->lote->descricao : 'Sem lote associado' }}
                                            </td>
                                            {{-- <td>{{ $visitante->lote->descricao }}</td> --}}

                                            <td>{{ $visitante->hora_de_entrada->format('d/m/Y H:i:s') }}</td>
                                            <td>{{ $visitante->hora_de_saida ? $visitante->hora_de_saida->format('d/m/Y H:i:s') : '-' }}
                                            </td>


                                            <td>{{ $visitante->motivo }}</td>
                                            <td>

                                                @if ($visitante->hora_de_saida == null)
                                                    <a href="{{ route($params['main_route'] . '.exit', $visitante->id) }}"
                                                        class="btn btn-outline-primary btn-xs"><span
                                                            class="fas fa-check"></span> Marcar
                                                        Saída</a>
                                                @endif

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
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
            },
            "order": [
                [7, "desc"],
                [7, "desc"]
            ],
            "columnDefs": [{
                "orderable": true,
                "targets": [7]
            }],
        });
    });
</script>
@stop
