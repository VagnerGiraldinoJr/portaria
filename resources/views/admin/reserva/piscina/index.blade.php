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
                                    <span class="fas fa-plus"></span> Nova Reserva
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive">
                        @if (isset($data) && $data->count())
                            <table id="dataTablePortaria" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Área Solicitada</th>
                                        <th>Data Reserva</th>
                                        <th>Unidade Solicitante</th>
                                        <th>Contato Resp. Reserva</th>
                                        <th>Status Reserva</th>
                                        <th>Status Chaves</th>
                                        <th>Operação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                        @if ($item)
                                            <tr>
                                                <td>{{ $item->area }}</td>
                                                @php
                                                    $dataInicio = Carbon\Carbon::parse($item->data_inicio);
                                                    $diaSemanaInicio = $dataInicio->isoFormat('dddd');
                                                @endphp
                                                <td class="{{ $diaSemanaInicio == 'sábado' ? 'text-primary' : '' }}">
                                                    {{ $dataInicio->format('d/m/Y') }} ({{ $diaSemanaInicio }})
                                                </td>
                                                <td>{{ $item->lote->descricao }}</td>
                                                <td>
                                                    <a href="https://wa.me/55{{ $item->celular_responsavel }}?text=Olá%20{{ optional($item->lote)->descricao ?? 'Unidade' }}.%20Sua%20Reserva%20foi%20realizada%20para%20o%20dia%20{{ $dataInicio->format('d') }}%20Dominare%20Portaria%20Agradece%20Obrigado!"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="btn btn-outline-success btn-xs">
                                                        <span class="fab fa-whatsapp fa-lg" aria-hidden="true"></span> Enviar
                                                        Mensagem
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($item->status == 'Confirmada')
                                                        <i class="fas fa-calendar-check text-success" aria-hidden="true"></i>
                                                        Confirmada
                                                    @elseif($item->status == 'Cancelada')
                                                        <i class="fas fa-ban text-danger" aria-hidden="true"></i> Cancelada
                                                    @elseif($item->status == 'Encerrado')
                                                        <i class="fas fa-check-double text-success" aria-hidden="true"></i>
                                                        Encerrado
                                                    @else
                                                        <i class="far fa-question-circle text-warning" aria-hidden="true"></i>
                                                        Pendente
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (!empty($item->dt_entrega_chaves))
                                                        {{-- Chaves entregues --}}
                                                    @else
                                                        <form action="{{ route('admin.reserva.showRetireForm', $item->id) }}"
                                                            method="GET" style="display: inline;">
                                                            <button type="submit" class="btn btn-outline-secondary btn-xs">
                                                                <span class="fas fa-unlock"></span> Entrega das Chaves
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if (!empty($item->dt_devolucao_chaves))
                                                        <i class="fas fa-check-double text-success" aria-hidden="true"></i>
                                                        Confirmada
                                                    @else
                                                        <form action="{{ route('admin.reserva.showReturnForm', $item->id) }}"
                                                            method="GET" style="display: inline;">
                                                            <button type="submit" class="btn btn-outline-info btn-xs">
                                                                <span class="fas fa-lock"></span> Devolução Chaves
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-xs" data-toggle="modal"
                                                        data-target="#editModal" data-id="{{ $item->unidade_id }}"
                                                        data-area="{{ $item->area }}" data-lote_id="{{ $item->lote_id }}"
                                                        data-data_inicio="{{ $item->data_inicio }}"
                                                        data-limpeza="{{ $item->limpeza }}" data-status="{{ $item->status }}"
                                                        data-acessorios="{{ $item->acessorios }}"
                                                        data-celular_responsavel="{{ $item->celular_responsavel }}"
                                                        {{ in_array($item->status, ['AAAA', 'ZZZZ']) ? 'disabled' : '' }}>
                                                        Editar
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
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
                                                <option value="PISCINA - MANHÃ">PISCINA - MANHÃ</option>
                                                <option value="PISCINA - TARDE">PISCINA - TARDE</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_data_inicio">Data Reserva</label>
                                            <input type="date" name="data_inicio" id="edit_data_inicio"
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
                                        <div class="form-group">
                                            <label for="edit_acessorios">Itens Reserva</label>
                                            <select name="acessorios" id="edit_acessorios" class="form-control" required>
                                                <option value="Grelha">Grelha</option>
                                                <option value="N/A">N/A</option>
                                                <option value="Talheres">Talheres</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_celular_responsavel">Celular Responsável Reserva</label>
                                            <input type="text" id="edit_celular_responsavel"
                                                name="celular_responsavel" class="form-control" required>
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
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var area = button.data('area');
                var lote_id = button.data('lote_id');
                var data_inicio = button.data('data_inicio');
                var limpeza = button.data('limpeza');
                var status = button.data('status');
                var acessorios = button.data('acessorios');
                var celular_responsavel = button.data('celular_responsavel');

                var modal = $(this);
                modal.find('.modal-body #edit_id').val(id);
                modal.find('.modal-body #edit_area').val(area);
                modal.find('.modal-body #edit_lote_id').val(lote_id);
                modal.find('.modal-body #edit_data_inicio').val(data_inicio);
                modal.find('.modal-body #edit_limpeza').val(limpeza);
                modal.find('.modal-body #edit_status').val(status);
                modal.find('.modal-body #edit_acessorios').val(acessorios);
                modal.find('.modal-body #edit_celular_responsavel').val(celular_responsavel);
            });

            $('#editForm').on('submit', function(event) {
                var form = $(this);
                var action = form.attr('action').replace('edit', $('#edit_id').val());
                form.attr('action', action);
            });
        });

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
