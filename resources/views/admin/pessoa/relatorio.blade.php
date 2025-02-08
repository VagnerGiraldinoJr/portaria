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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!-- Texto do relatório -->
                        <h3 class="font-weight-bold"> 🚀 Relatório - Moradores</h3>
                        <!-- Botões de ação -->
                        <div class="ml-auto">
                            <button onclick="window.print();" class="btn btn-primary btn-sm-custom">Imprimir</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Texto para impressão -->
                        <div class="print-header d-none">
                            <h3 class="text-center font-weight-bold"> Relatório - Moradores</h3>
                        </div>

                        @if (!empty($pessoas))
                            <!-- Tabela de dados do relatório -->
                            <table id="relatorio-tabela" class="table table-bordered table-striped mt-4">
                                <thead>
                                    <tr>
                                        <th>LOTE</th>
                                        <th>NOME COMPLETO</th>
                                        <th>RG</th>
                                        <th>CELULAR</th>
                                        <th>TIPO REGISTRO</th>
                                        <th>CONDOMÍNIO</th>
                                        <th>DESCRIÇÃO LOTE</th>
                                        <th>INADIMPLENTE</th>
                                        <th>REFERÊNCIA MÊS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pessoas as $pessoa)
                                        <tr>
                                            <!-- Exibe os dados de cada pessoa -->
                                            <td>{{ $pessoa->lote->descricao ?? '' }}</td>
                                            <td>{{ $pessoa->nome_completo ?? '' }}</td>
                                            <td>{{ $pessoa->rg ?? '' }}</td>
                                            <td>{{ $pessoa->celular ?? '' }}</td>
                                            <td>{{ $pessoa->tipo_registro ?? '' }}</td>
                                            <td>{{ $pessoa->condominio ?? '' }}</td>
                                            <td>{{ $pessoa->lote->descricao ?? '' }}</td>
                                            <td>
                                                <!-- Exibe badge de status de inadimplência -->
                                                @if (($pessoa->lote->inadimplente ?? 0) == 1)
                                                    <span class="badge bg-danger">Inadimplente</span>
                                                @else
                                                    <span class="badge bg-success">Regular</span>
                                                @endif
                                            </td>
                                            <td>{{ $pessoa->referencia_mes ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <!-- Mensagem caso não haja registros -->
                            <p class="mt-4">Por favor, utilize os filtros acima para buscar os registros.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/style.css">
    <style>
        @media print {

            .dataTables_length,
            /* Dropdown "Mostrando X linhas" */
            .dataTables_filter,
            /* Campo de busca */
            .dataTables_info,
            /* Informação de paginação */
            .dataTables_paginate,
            /* Controles de paginação */
            .card-header {
                /* Botões "Voltar" e "Imprimir" */
                display: none !important;
            }

            .print-header {
                display: block !important;
            }

            /* Expande a tabela para ocupar toda a largura na impressão */
            .card-body {
                margin-top: 20px;
            }
        }

        .print-header {
            display: none;
        }
    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Inicializa a tabela com DataTables
            var table = $('#relatorio-tabela').DataTable({
                "pageLength": 25,
                "language": {
                    "decimal": "",
                    "emptyTable": "Dados Indisponíveis na Tabela",
                    "info": "Mostrando _START_ de _END_ do _TOTAL_ linhas",
                    "infoEmpty": "Mostrando 0 linhas",
                    "infoFiltered": "(filtrando _MAX_ total de linhas)",
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
