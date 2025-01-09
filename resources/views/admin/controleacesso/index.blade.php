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
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        <table id="dataTablePortaria" class="table table-hover" role="table">
                            <thead>
                                <tr>
                                    <th>#Protocolo</th>
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
                                <!-- Os dados serão carregados via AJAX -->
                            </tbody>
                        </table>
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

@section('js')
<script>
    $(document).ready(function() {
    $('#dataTablePortaria').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('admin.controleacesso.fetch') }}", // Rota para carregar os dados
        "columns": [
            { "data": "protocolo" },
            { "data": "desc_tipo" },
            {
                "data": null,
                "render": function(data, type, row) {
                    if (row.tipo === 1) {
                        return row.lote ? row.lote.descricao : '';
                    } else {
                        return row.veiculo && row.veiculo[0] ? row.veiculo[0].placa : '';
                    }
                }
            },
            { "data": "data_entrada" },
            { "data": "data_saida" },
            { "data": "entregador" },
            { "data": "retirado_por" },
            {
                "data": null,
                "render": function(data, type, row) {
                    let buttons = '';
                    if (row.data_saida === null) {
                        buttons += `<a href="/admin/controleacesso/exit/${row.id}" class="btn btn-outline-primary btn-xs">
                                        <span class="fas fa-check"></span> Marcar Saída</a>`;
                    }
                    return buttons;
                }
            }
        ],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
        }
    });
});
</script>
@stop
