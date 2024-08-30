<!-- resources/views/controle_acessos/relatorio.blade.php -->

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
                        <!-- Logo do Cliente -->
                        <div>
                            <img src="{{ asset(config('adminlte.logo_img')) }}" style="height: 50px;">
                        </div>

                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.reserva.relatorio') }}" class="form-inline">
                            <div class="form-group mb-2 mr-2">
                                <label for="status" class="mr-2">Status Reserva</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Selecione um Status</option>
                                    <option value="Confirmada" {{ request('status') == 'Confirmada' ? 'selected' : '' }}>
                                        Confirmada</option>
                                    <option value="Pendente" {{ request('status') == 'Pendente' ? 'selected' : '' }}>
                                        Pendente</option>
                                    <option value="Encerrado" {{ request('status') == 'Encerrado' ? 'selected' : '' }}>
                                        Encerrado</option>
                                    <option value="">Listar todos os Status</option>
                                </select>
                            </div>


                            <button type="submit" class="btn btn-primary btn-sm-custom mb-2 mr-2">Filtrar</button>
                            <!-- Espaçamento adicionado aqui -->

                            <!-- Botão de impressão -->
                            <div>
                                <button onclick="window.print();" class="btn btn-secondary btn-sm-custom mb-2">Imprimir
                                    Relatório</button>
                            </div>
                        </form>

                        @if ($reserva->isNotEmpty())

                            <table class="table table-bordered table-striped mt-4">
                                <thead>
                                    <tr>
                                        <th>Data Reserva</th>
                                        <th>Portaria</th>
                                        <th>Casa/Apto.</th>
                                        <th>Área reservada</th>
                                        <th>Taxa limpeza</th>
                                        <th>Acessórios</th>
                                        <th>Status Reserva</th>
                                        <th>Cel. Responsável Reserva</th>
                                        <th>Dt. Entrega Chaves</th>
                                        <th>Retirado por:</th>
                                        <th>Dt. Devolução Chaves</th>
                                        <th>Devolvido por:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reserva as $acesso)
                                        @dd($acesso);<tr>
                                            <td>{{ \Carbon\Carbon::parse($acesso->data_entrada)->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td>{{ $acesso->unidade->titulo }}</td>
                                            <td>{{ $acesso->lote->descricao }}</td>
                                            <td>{{ $acesso->area }}</td>
                                            <td>{{ $acesso->limpeza }}</td>
                                            <td>{{ $acesso->acessorios }}</td>
                                            <td>{{ $acesso->status }}</td>
                                            <td>{{ formatarCelular($acesso->celular_responsavel) }}</td>
                                            <td>{{ $acesso->dt_entrega_chaves ? \Carbon\Carbon::parse($acesso->dt_entrega_chaves)->format('d/m/Y H:i:s') : '----' }}
                                            </td>
                                            <td>{{ $acesso->retirado_por ? $acesso->retirado_por : '----' }}</td>
                                            <td>{{ $acesso->dt_devolucao_chaves ? \Carbon\Carbon::parse($acesso->dt_devolucao_chaves)->format('d/m/Y H:i:s') : '----' }}
                                            </td>
                                            <td>{{ $acesso->devolvido_por ? $acesso->devolvido_por : '----' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
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
@section('plugins.Datatables', true)
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#dataTablePortaria').DataTable({
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

@php
    function formatarCelular($numero)
    {
        // Remover todos os caracteres não numéricos
        $numeroLimpo = preg_replace('/\D/', '', $numero);

        // Verificar se o número tem pelo menos 11 dígitos (considerando DDD e o número de celular)
        if (strlen($numeroLimpo) === 11) {
            // Formatando para o formato (DDD) X XXXX XXXX
            return sprintf(
                '(%s) %s %s-%s',
                substr($numeroLimpo, 0, 2), // DDD
                substr($numeroLimpo, 2, 1), // Primeiro dígito do celular
                substr($numeroLimpo, 3, 4), // Próximos 4 dígitos
                substr($numeroLimpo, 7), // Últimos 4 dígitos
            );
        }

        // Retorna o número original caso não tenha 11 dígitos
        return $numero;
    }
@endphp
@stop
