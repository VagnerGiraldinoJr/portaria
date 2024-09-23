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
                                    <span class="fas fa-plus"></span> Novo Registro
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">

                        @if (isset($data) && $data->count())
                            <h1>Passagens de Turno</h1>

                            <table>
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Porteiro</th>
                                        <th>Condomínio</th>
                                        <th>Início</th>
                                        <th>Fim</th>
                                        <th>Ocorrências</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($passagens as $passagem)
                                        <tr>
                                            <td>{{ $passagem->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $passagem->user->name }}</td>
                                            <td>{{ $passagem->unidade->nome }}</td>
                                            <td>{{ $passagem->inicio_turno }}</td>
                                            <td>{{ $passagem->fim_turno }}</td>
                                            <td>{{ $passagem->ocorrencias ?? 'Sem ocorrências' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endsection
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
