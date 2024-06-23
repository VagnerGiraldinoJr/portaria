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
                                        class="fas fa-plus"></span> Nova
                                    Reserva</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        @if (isset($data) && count($data))

                            <table id="dataTablePortaria" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Área Solicitada</th>
                                        <th>Data Ínicio</th>
                                        <th>Data Saída</th>

                                        <th>Unidade Solicitante</th>
                                        <th>Tempo Reserva Hr.|Min.|Seg.</th>
                                        <th>Status Reserva</th>
                                        <th>Operação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $itens)
                                        <tr>
                                            <td>{{ $itens->area }}</td>
                                            @php
                                                $dataInicio = Carbon\Carbon::parse($itens->data_inicio);
                                                $dataFim = Carbon\Carbon::parse($itens->data_fim);
                                                $diaSemanaInicio = $dataInicio->isoFormat('dddd');
                                                $diaSemanaFim = $dataFim->isoFormat('dddd');
                                            @endphp

                                            <td class="{{ $diaSemanaInicio == 'sábado' ? 'text-primary' : '' }}">
                                                {{ $dataInicio->format('d/m/Y H:i:s') }}
                                                ({{ $diaSemanaInicio }})
                                            </td>
                                            <td class="{{ $diaSemanaFim == 'sábado' ? 'text-primary' : '' }}">
                                                {{ $dataFim->format('d/m/Y H:i:s') }}
                                                ({{ $diaSemanaFim }})
                                            </td>

                                            <td>{{ $itens->lote->descricao }} -
                                                <a href="#" {{-- "https://wa.me/{{ isset($item->pessoa[0]) ? $item->pessoa[0]->celular : '' }}?text=Portaria" --}} {{-- target="_blank" rel="noopener noreferrer" --}}
                                                    class="btn btn-outline-success btn-xs"><span
                                                        class="fab fa-whatsapp fa-lg" aria-hidden="true"></span>
                                                    Enviar Mensagem
                                                </a>
                                            </td>

                                            <td>
                                                @php
                                                    $dataInicio = Carbon\Carbon::parse($itens->data_inicio);
                                                    $dataFim = Carbon\Carbon::parse($itens->data_fim);
                                                    $tempoReserva = $dataInicio->diff($dataFim);
                                                @endphp
                                                <i class="text-success fas fa-clock"></i>
                                                {{ $tempoReserva->format('%H:%I:%S') }}
                                            </td>

                                            {{-- Status --}}
                                            <td>
                                                @if ($itens->status == 'Confirmada')
                                                    <i class="fas fa-calendar-check text-success"></i> Confirmada
                                                @elseif($itens->status == 'Cancelada')
                                                    <i class="fas fa-ban text-danger"></i> Cancelada
                                                @else
                                                    <i class="far fa-question-circle text-warning"></i> Pendente
                                                @endif
                                            </td>

                                            <td>
                                                <button class="btn btn-primary btn-xs" data-toggle="modal"
                                                    data-target="#editModal" data-id="{{ $itens->id }}"
                                                    data-area="{{ $itens->area }}" data-lote_id="{{ $itens->lote_id }}"
                                                    data-data_inicio="{{ \Carbon\Carbon::parse($itens->data_inicio)->format('Y-m-d\TH:i') }}"
                                                    data-data_fim="{{ \Carbon\Carbon::parse($itens->data_fim)->format('Y-m-d\TH:i') }}"
                                                    data-limpeza="{{ $itens->limpeza }}"
                                                    data-status="{{ $itens->status }}">
                                                    <span class="fas fa-edit"></span> Editar
                                                </button>
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


                    <!-- Modal de Edição -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="{{ route('admin.reserva.update', 'edit') }}" method="POST" id="editForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Editar Reserva</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="edit_id">
                                        <div class="form-group">
                                            <label for="edit_area">Área</label>
                                            <select name="area" id="edit_area" class="form-control" required>
                                                <option value="ACADEMIA"
                                                    {{ $itens->area === 'ACADEMIA' ? 'selected' : '' }}>ACADEMIA</option>
                                                <option value="ESPAÇO GOURMET - PRINCIPAL"
                                                    {{ $itens->area === 'ESPAÇO GOURMET - PRINCIPAL' ? 'selected' : '' }}>
                                                    ESPAÇO GOURMET - PRINCIPAL</option>
                                                <option value="SALÃO DE FESTAS"
                                                    {{ $itens->area === 'SALÃO DE FESTAS' ? 'selected' : '' }}>SALÃO DE
                                                    FESTAS</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="edit_data_inicio">Data e Hora de Início</label>
                                            <input type="datetime-local" name="data_inicio" id="edit_data_inicio"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_data_fim">Data e Hora de Término</label>
                                            <input type="datetime-local" name="data_fim" id="edit_data_fim"
                                                class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_limpeza">Limpeza</label>
                                            <select name="limpeza" id="edit_limpeza" class="form-control" required>
                                                <option value="usuario">O Morador irá limpar após o uso</option>
                                                <option value="condominio">Será limpo pelo condomínio</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_status">Status</label>
                                            <select name="status" id="edit_status" class="form-control" required>
                                                <option value="Confirmada">Confirmada</option>
                                                <option value="Cancelada">Cancelada</option>
                                                <option value="Pendente">Pendente</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-primary">Salvar mudanças</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Final Modal de Edição -->
                @endsection

                @section('css')
                    <link rel="stylesheet" href="/css/admin_custom.css">
                @section('plugins.Datatables', true)

            @stop

            @section('js')
                <script>
                    $(document).ready(function() {
                        $('#editModal').on('show.bs.modal', function(event) {
                            var button = $(event.relatedTarget);
                            var id = button.data('id');
                            var area = button.data('area');
                            var lote_id = button.data('lote_id');
                            var data_inicio = button.data('data_inicio');
                            var data_fim = button.data('data_fim');
                            var limpeza = button.data('limpeza');
                            var status = button.data('status');

                            var modal = $(this);
                            modal.find('.modal-body #edit_id').val(id);
                            modal.find('.modal-body #edit_area').val(area);
                            modal.find('.modal-body #edit_lote_id').val(lote_id);
                            modal.find('.modal-body #edit_data_inicio').val(data_inicio);
                            modal.find('.modal-body #edit_data_fim').val(data_fim);
                            modal.find('.modal-body #edit_limpeza').val(limpeza);
                            modal.find('.modal-body #edit_status').val(status);
                        });

                        $('#editForm').on('submit', function(event) {
                            var form = $(this);
                            var action = form.attr('action').replace('edit', $('#edit_id').val());
                            form.attr('action', action);
                        });
                    });
                    //    DataTable
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
