@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

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
                                        <th>Limpeza</th>
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
                                            {{-- Tratando com cores o resultado para melhorar a visualização do operador --}}
                                            <td>
                                                @if ($item->limpeza == 'IsentoTaxaLimpeza')
                                                    <span class="text-blue">Limpeza será feita pelo <b>Morador</b></span>
                                                @else
                                                    <span class="text-gray">Limpeza será feita pelo <b>Condomínio</b></span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="https://wa.me/55{{ $item->celular_responsavel }}?text=Olá%20{{ optional($item->lote)->descricao ?? 'Unidade' }}.%20Sua%20Reserva%20foi%20realizada%20para%20o%20dia%20{{ $dataInicio->format('d') }}%20Dominare%20Portaria%20Agradece%20Obrigado!"
                                                    target="_blank" rel="noopener noreferrer" class="btn btn-outline-success btn-xs">
                                                    <span class="fab fa-whatsapp fa-lg" aria-hidden="true"></span> Enviar Mensagem
                                                </a>
                                            </td>
                                            <td>
                                                @if ($item->status == 'Confirmada')
                                                    <i class="fas fa-calendar-check text-success" aria-hidden="true"></i> Confirmada
                                                @elseif($item->status == 'Cancelada')
                                                    <i class="fas fa-ban text-danger" aria-hidden="true"></i> Cancelada
                                                @elseif($item->status == 'Encerrado')
                                                    <i class="fas fa-check-double text-success" aria-hidden="true"></i> Encerrado
                                                @else
                                                    <i class="far fa-question-circle text-warning" aria-hidden="true"></i> Pendente
                                                @endif
                                            </td>
                                            <td>
                                                @if (!empty($item->dt_entrega_chaves))
                                                    {{-- Chaves entregues --}}
                                                @else
                                                    <form action="{{ route('admin.reserva.showRetireForm', $item->id) }}" method="GET" style="display: inline;">
                                                        <button type="submit" class="btn btn-outline-secondary btn-xs">
                                                            <span class="fas fa-unlock"></span> Entrega das Chaves
                                                        </button>
                                                    </form>
                                                @endif
                                                @if (!empty($item->dt_devolucao_chaves))
                                                    <i class="fas fa-check-double text-success" aria-hidden="true"></i> Confirmada
                                                @else
                                                    <form action="{{ route('admin.reserva.showReturnForm', $item->id) }}" method="GET" style="display: inline;">
                                                        <button type="submit" class="btn btn-outline-info btn-xs">
                                                            <span class="fas fa-lock"></span> Devolução Chaves
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editModal"
                                                    data-id="{{ $item->id }}" 
                                                    data-area="{{ $item->area }}"
                                                    data-lote_id="{{ $item->lote_id }}"
                                                    data-data_inicio="{{ $item->data_inicio }}"
                                                    data-limpeza="{{ $item->limpeza }}"
                                                    data-status="{{ $item->status }}"
                                                    data-acessorios="{{ $item->acessorios }}"
                                                    data-celular_responsavel="{{ $item->celular_responsavel }}"
                                                    {{ in_array($item->status, ['AAAA', 'ZZZZ']) ? 'disabled' : '' }}>
                                                    Editar
                                                </button>
                                
                                                @if ($item->status != 'Encerrado')
                                                    <!-- Botão para excluir a reserva -->
                                                    <form action="{{ route('admin.reserva.destroy', $item->id) }}" method="POST" style="display: inline;"
                                                        onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-xs btn-flat">Excluir</button>
                                                    </form>
                                                @endif
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

                    <!-- Modal de Edição dos QUIOSQUE-->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">

                                <form action="" method="POST" id="editForm">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="id" id="edit_id">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Editar Reserva</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="edit_area">Área</label>
                                            <select name="area" id="edit_area" class="form-control" required>
                                                <option value="QUIOSQUE 01">QUIOSQUE 01</option>
                                                <option value="QUIOSQUE 02">QUIOSQUE 02</option>
                                                <option value="QUIOSQUE 03">QUIOSQUE 03</option>
                                                <option value="SALÃO DE JOGOS">SALÃO DE JOGOS</option>
                                                <option value="SALÃO DE FESTAS">SALÃO DE FESTAS</option>
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
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/style.css">
@stop

@section('plugins.Datatables', true)

@section('js')
    <script>
        $(document).ready(function() {
            // Evento ao abrir o modal de edição
            $('#editModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botão que acionou o modal
                var id = button.data('id'); // ID da reserva
                var area = button.data('area'); // Área da reserva
                var dataInicio = button.data('data_inicio'); // Data de início
                var limpeza = button.data('limpeza'); // Informação de limpeza
                var status = button.data('status'); // Status da reserva
                var acessorios = button.data('acessorios'); // Acessórios
                var celularResponsavel = button.data('celular_responsavel'); // Celular do responsável

                var modal = $(this);
                // Preencher os campos do modal com os dados recebidos
                modal.find('#edit_id').val(id);
                modal.find('#edit_area').val(area);
                modal.find('#edit_data_inicio').val(dataInicio);
                modal.find('#edit_limpeza').val(limpeza);
                modal.find('#edit_status').val(status);
                modal.find('#edit_acessorios').val(acessorios);
                modal.find('#edit_celular_responsavel').val(celularResponsavel);

                // Atualizar a rota do formulário dinamicamente
                var form = modal.find('#editForm');
                var action = "{{ route('admin.reserva.update', ['id' => '__ID__']) }}";
                form.attr('action', action.replace('__ID__', id));
            });

            // Configurar o DataTable
            $('#dataTablePortaria').DataTable({
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
