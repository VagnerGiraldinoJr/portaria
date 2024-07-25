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
                                        <th>Tipo</th>
                                        <th>Apto. / Placa</th>
                                        <th>Data Entrada</th>
                                        <th>Data Saída</th>
                                        <th>Entregador/Empresa</th>
                                        <th>Retirado Por:</th>
                                        <th>Operação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->desc_tipo }}</td>

                                            @if ($item->tipo == 1)
                                                <td>{{ $item->lote ? $item->lote->descricao : '' }}</td>
                                            @else
                                                <td>{{ isset($item->veiculo[0]) ? $item->veiculo[0]->placa : '' }}</td>
                                            @endif

                                            <td>{{ Carbon\Carbon::parse($item->data_entrada)->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td>
                                                @if ($item->data_saida != null)
                                                    {{ Carbon\Carbon::parse($item->data_saida)->format('d/m/Y H:i:s') }}
                                                @endif
                                            <td>{{ $item->entregador }}</td>
                                            <td>{{ $item->retirado_por }}</td>
                                            <td>
                                                <!-- <a href="{{ route($params['main_route'] . '.show', $item->id) }}" class="btn btn-outline-danger btn-xs"><span class="fas fa-trash"></span> Deletar</a> -->
                                                @if ($item->data_saida == null)
                                                    <a href="{{ route($params['main_route'] . '.exit', $item->id) }}"
                                                        class="btn btn-outline-primary btn-xs"><span
                                                            class="fas fa-check"></span> Marcar
                                                        Saída</a>
                                                    <a href="https://wa.me/{{ isset($item->pessoa[0]) ? $item->pessoa[0]->celular : '' }}?text=Olá!%20Você%20recebeu%20uma%20encomenda!%20Está%20disponível%20na%20portaria.%20"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="btn btn-outline-success btn-xs"><span
                                                            class="fab fa-whatsapp fa-lg" aria-hidden="true"></span>
                                                        Enviar Mensagem</a>
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
                    "last": "Ultimo",
                    "next": "Proximo",
                    "previous": "Anterior"
                },
            }
        });
    });
</script>
@stop
