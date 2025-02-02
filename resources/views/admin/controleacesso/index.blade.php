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
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        @if ($data->isNotEmpty())
                            <table id="dataTablePortaria" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#Protocolo</th>
                                        <th>Tipo</th>
                                        <th>Apto. / Placa</th>
                                        <th>Data Entrada</th>
                                        <th>Data Saída</th>
                                        <th>Entregador/Empresa</th>
                                        <th>Retirado Por</th>
                                        <th>Operação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $item->protocolo }}</td>
                                            <td>{{ $item->desc_tipo }}</td>
                                            <td>{{ $item->tipo == 1 ? optional($item->lote)->descricao : optional($item->veiculo->first())->placa }}
                                            </td>
                                            <td>{{ $item->data_entrada ? Carbon\Carbon::parse($item->data_entrada)->format('Y-m-d H:i:s') : '---' }}
                                            </td>
                                            </td>
                                            <td>{{ $item->data_saida ? Carbon\Carbon::parse($item->data_saida)->format('d/m/Y H:i:s') : '---' }}
                                            </td>
                                            <td>{{ $item->entregador }}</td>
                                            <td>{{ $item->retirado_por }}</td>
                                            <td>
                                                @if (!$item->data_saida)
                                                    <a href="{{ route($params['main_route'] . '.exit', $item->id) }}"
                                                        class="btn btn-outline-primary btn-xs">
                                                        <span class="fas fa-check"></span> Registrar Saída
                                                    </a>
                                                    <a href="https://wa.me/{{ preg_replace('/\D/', '', optional(optional($item->pessoa)->first())->celular) }}?text=Olá!%20Você%20recebeu%20uma%20encomenda!"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="btn btn-outline-success btn-xs">
                                                        <span class="fab fa-whatsapp fa-lg"></span> Enviar Mensagem
                                                    </a>
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
                </div>
            </div>
        </div>
    </section>

@stop

@section('css')
    <link rel="stylesheet" href="/css/style.css">
@stop
@section('js')
    <script script script src="https://cdn.datatables.net/plug-ins/1.11.5/sorting/datetime.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTablePortaria').DataTable({
                "pageLength": 25,
                "order": [
                    [4, "asc"]
                ], // Ordem ascendente para a coluna "Data Saída"
                "language": {
                    "decimal": "",
                    "emptyTable": "Nenhum registro encontrado",
                    "info": "Exibindo _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Exibindo 0 registros",
                    "infoFiltered": "(filtrado de _MAX_ registros no total)",
                    "lengthMenu": "Exibir _MENU_ registros por página",
                    "loadingRecords": "Carregando...",
                    "processing": "Processando...",
                    "search": "Buscar:",
                    "zeroRecords": "Nenhum resultado encontrado",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    }
                },
                "columnDefs": [{
                        "orderable": true,
                        "targets": [0, 1, 2, 3, 4, 5, 6]
                    },
                    {
                        "orderable": false,
                        "targets": [7] // Coluna "Operação" não ordenável
                    }
                ]
            });
        });
    </script>

@stop
