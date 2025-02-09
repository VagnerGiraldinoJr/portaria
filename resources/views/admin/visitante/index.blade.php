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
                    <!-- Card Header -->
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">{{ $params['subtitulo'] }}</h3>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route($params['main_route'] . '.create') }}" class="btn btn-primary btn-sm">
                                    <span class="fas fa-plus"></span> Novo Cadastro
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->

                    <!-- Card Body -->
                    <div class="card-body table-responsive">
                        @if (count($visitantes))
                            <table id="dataTableVisitantes" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Documento</th>
                                        <th>Placa do Veículo</th>
                                        <th>Unidade Visitada</th>
                                        <th>Hora de Entrada</th>
                                        <th>Hora de Saída</th>
                                        <th>Motivo Entrada</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($visitantes as $visitante)
                                        <tr>
                                            <!-- Nome -->
                                            <td>{{ $visitante->nome }}</td>

                                            <!-- Documento -->
                                            <td>{{ $visitante->documento }}</td>

                                            <!-- Placa do Veículo -->
                                            <td>{{ $visitante->placa_do_veiculo ?? 'N/A' }}</td>

                                            <!-- Unidade Visitada -->
                                            <td>{{ $visitante->lote->descricao ?? 'Lote não encontrado' }}</td>

                                            <!-- Hora de Entrada -->
                                            <td>{{ \Carbon\Carbon::parse($visitante->hora_de_entrada)->format('d/m/Y H:i:s') }}
                                            </td>

                                            <!-- Hora de Saída -->
                                            <td>
                                                @if ($visitante->hora_de_saida)
                                                    <span
                                                        class="badge badge-success">{{ \Carbon\Carbon::parse($visitante->hora_de_saida)->format('d/m/Y H:i:s') }}</span>
                                                @else
                                                    <span class="badge badge-warning">Ainda presente</span>
                                                @endif
                                            </td>

                                            <!-- Motivo Entrada -->
                                            <td>{{ $visitante->motivo ?? 'N/A' }}</td>

                                            <!-- Ações -->
                                            <td class="text-center">
                                                <div class="d-flex justify-content-around align-items-center">
                                                    <!-- Botão Registrar Saída (se aplicável) -->
                                                    @if (!$visitante->hora_de_saida)
                                                        <a href="{{ route('admin.visitante.exit', $visitante->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            Registrar Saída
                                                        </a>
                                                    @endif

                                                    <!-- Botão Enviar Mensagem -->
                                                    <a href="https://wa.me/{{ $visitante->celular }}" target="_blank"
                                                        class="btn btn-sm btn-success">
                                                        <i class="fab fa-whatsapp"></i> Enviar Mensagem
                                                    </a>
                                                </div>
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
        var table = $('#dataTableVisitantes').DataTable({
            "pageLength": 25,
            "language": {
                "decimal": "",
                "emptyTable": "Dados Indisponíveis na Tabela",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totais)",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ registros",
                "loadingRecords": "Carregando...",
                "processing": "Processando...",
                "search": "Busca:",
                "zeroRecords": "Nenhum registro encontrado",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Anterior"
                },
            },
            "order": [
                [5, "desc"], // Ordena pela coluna "Hora de Entrada"
            ],
        });
    });
</script>
@stop
