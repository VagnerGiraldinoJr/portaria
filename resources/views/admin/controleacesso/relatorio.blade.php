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
                <div class="card-header">
                    <form method="GET" action="{{ route('admin.controleacesso.relatorio') }}" class="form-inline">
                        <div class="form-group mb-2 mr-2">
                            <label for="data_entrada" class="mr-2">Data de Entrada</label>
                            <input type="date" name="data_entrada" id="data_entrada" class="form-control" value="{{ request('data_entrada') }}">
                        </div>
                        <div class="form-group mb-2 mr-2">
                            <label for="data_saida" class="mr-2">Data de Saída</label>
                            <input type="date" name="data_saida" id="data_saida" class="form-control" value="{{ request('data_saida') }}">
                        </div>
                        <div class="form-group mb-2 mr-2">
                            <label for="per_page" class="mr-2">Itens por página</label>
                            <select name="per_page" id="per_page" class="form-control">
                                <option value="10"{{ request('per_page') == 10 ? ' selected' : '' }}>10</option>
                                <option value="25"{{ request('per_page') == 25 ? ' selected' : '' }}>25</option>
                                <option value="50"{{ request('per_page') == 50 ? ' selected' : '' }}>50</option>
                                <option value="100"{{ request('per_page') == 100 ? ' selected' : '' }}>100</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm-custom mb-2">Filtrar</button>
                    </form>

                    @if($controleAcessos->isNotEmpty())
                        <table id="dataTablePortaria" class="table table-bordered table-striped mt-4">
                            <thead>
                                <tr>
                                    <th>Data de Entrada</th>
                                    <th>Data de Saída</th>
                                    <th>Motivo</th>
                                    <th>Observação</th>
                                    <th>Retirado por:</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($controleAcessos as $acesso)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($acesso->data_entrada)->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($acesso->data_saida)->format('d/m/Y H:i:s') }}</td>
                                        <td>{{ $acesso->motivo }}</td>
                                        <td>{{ $acesso->observacao }}</td>
                                        <td>{{ $acesso->retirado_por }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginação -->
                        <div class="d-flex justify-content-center">
                            {{ $controleAcessos->appends(request()->except('page'))->links() }}
                        </div>
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
            "pageLength": {{ request('per_page', 10) }},
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
