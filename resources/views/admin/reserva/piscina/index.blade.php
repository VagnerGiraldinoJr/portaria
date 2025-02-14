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
                                    @if ($data && $data->isNotEmpty())
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $item->area ?? 'N/A' }}</td>
                                                @php
                                                    $dataInicio = $item->data_inicio
                                                        ? Carbon\Carbon::parse($item->data_inicio)
                                                        : null;
                                                    $diaSemanaInicio = $dataInicio
                                                        ? $dataInicio->isoFormat('dddd')
                                                        : 'N/A';
                                                @endphp
                                                <td class="{{ $diaSemanaInicio == 'sábado' ? 'text-primary' : '' }}">
                                                    {{ $dataInicio ? $dataInicio->format('d/m/Y') : 'N/A' }}
                                                    ({{ $diaSemanaInicio }})
                                                </td>
                                                <td>{{ $item->lote->descricao ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($item->limpeza == 'IsentoTaxaLimpeza')
                                                        <span class="text-blue">Limpeza será feita pelo
                                                            <b>Morador</b></span>
                                                    @else
                                                        <span class="text-gray">Limpeza será feita pelo
                                                            <b>Condomínio</b></span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="https://wa.me/55{{ $item->celular_responsavel ?? '' }}?text=Olá%20{{ optional($item->lote)->descricao ?? 'Unidade' }}.%20Sua%20Reserva%20foi%20realizada%20para%20o%20dia%20{{ $dataInicio ? $dataInicio->format('d') : '' }}%20Dominare%20Portaria%20Agradece%20Obrigado!"
                                                        target="_blank" rel="noopener noreferrer"
                                                        class="btn btn-outline-success btn-xs">
                                                        <span class="fab fa-whatsapp fa-lg" aria-hidden="true"></span>
                                                        Enviar Mensagem
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($item->status == 'Confirmada')
                                                        <i class="fas fa-calendar-check text-success"
                                                            aria-hidden="true"></i> Confirmada
                                                    @elseif ($item->status == 'Cancelada')
                                                        <i class="fas fa-ban text-danger" aria-hidden="true"></i> Cancelada
                                                    @elseif ($item->status == 'Encerrado')
                                                        <i class="fas fa-check-double text-success" aria-hidden="true"></i>
                                                        Encerrado
                                                    @else
                                                        <i class="far fa-question-circle text-warning"
                                                            aria-hidden="true"></i> Pendente
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (!empty($item->dt_entrega_chaves))
                                                        <i class="fas fa-check-double text-success" aria-hidden="true"></i>
                                                        Confirmada
                                                    @else
                                                        <form
                                                            action="{{ route('admin.reserva.piscina.showRetireForm', $item->id ?? 0) }}"
                                                            method="GET" style="display: inline;">
                                                            <button type="submit" class="btn btn-outline-secondary btn-xs">
                                                                <span class="fas fa-unlock"></span> Entrega das Chaves
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if (!empty($item->dt_devolucao_chaves))
                                                        <i class="fas fa-check-double text-success" aria-hidden="true"></i>
                                                        Devolvida
                                                    @else
                                                        <form
                                                            action="{{ route('admin.reserva.piscina.showReturnForm', $item->id ?? 0) }}"
                                                            method="GET" style="display: inline;">
                                                            <button type="submit" class="btn btn-outline-info btn-xs">
                                                                <span class="fas fa-lock"></span> Devolução Chaves
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>



                                                <td>
                                                    <button type="button" class="btn btn-primary btn-xs"
                                                        data-toggle="modal" data-target="#editModal"
                                                        data-id="{{ $item->id ?? '' }}"
                                                        data-area="{{ $item->area ?? '' }}"
                                                        data-lote_id="{{ $item->lote_id ?? '' }}"
                                                        data-data_inicio="{{ $item->data_inicio ?? '' }}"
                                                        data-limpeza="{{ $item->limpeza ?? '' }}"
                                                        data-status="{{ $item->status ?? '' }}"
                                                        data-acessorios="{{ $item->acessorios ?? '' }}"
                                                        data-celular_responsavel="{{ $item->celular_responsavel ?? '' }}">
                                                        Editar
                                                    </button>
                                                    @if ($item->status != 'Encerrado')
                                                        <form
                                                            action="{{ route('admin.reserva.piscina.destroy', $item->id ?? 0) }}"
                                                            method="POST" style="display: inline;"
                                                            onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-xs btn-flat">Excluir</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center">Nenhuma reserva encontrada.</td>
                                        </tr>
                                    @endif
                                </tbody>




                            </table>
                        @else
                            <div class="alert alert-success m-2" role="alert">
                                Nenhuma informação cadastrada.
                            </div>
                        @endif
                    </div>

                    <!-- Modal de Edição -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="editForm" action="#" method="POST">
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
                                            <label for="edit_status">Status da Reserva</label>
                                            <select name="status" id="edit_status" class="form-control">
                                                <option value="Pendente">Pendente</option>
                                                <option value="Confirmada">Confirmada</option>
                                                <option value="Cancelada">Cancelada</option>
                                                <option value="Encerrado">Encerrado</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_limpeza">Limpeza</label>
                                            <select name="limpeza" id="edit_limpeza" class="form-control">
                                                <option value="IsentoTaxaLimpeza">Limpeza será feita pelo Morador</option>
                                                <option value="TaxaLimpezaCondominio">Limpeza será feita pelo Condomínio
                                                </option>
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
                    <!-- Fim do Modal -->


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
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botão que acionou o modal

            // Verifica se o botão existe e possui os atributos necessários
            if (!button || !button.data('id')) {
                console.error('Atributos necessários não encontrados no botão.');
                return; // Sai da função se não houver os atributos necessários
            }

            var id = button.data('id'); // ID da reserva
            var area = button.data('area'); // Área da reserva
            var loteId = button.data('lote_id'); // Lote ID
            var dataInicio = button.data('data_inicio'); // Data de início
            var limpeza = button.data('limpeza'); // Informação de limpeza
            var status = button.data('status'); // Status da reserva
            var acessorios = button.data('acessorios'); // Acessórios
            var celularResponsavel = button.data('celular_responsavel'); // Celular do responsável

            var modal = $(this);

            // Preenche os campos do modal com os dados
            modal.find('#edit_id').val(id);
            modal.find('#edit_area').val(area);
            modal.find('#edit_lote_id').val(loteId);
            modal.find('#edit_data_inicio').val(dataInicio);
            modal.find('#edit_limpeza').val(limpeza);
            modal.find('#edit_status').val(status);
            modal.find('#edit_acessorios').val(acessorios);
            modal.find('#edit_celular_responsavel').val(celularResponsavel);

            // Configura dinamicamente a rota do formulário
            var form = modal.find('#editForm');
            form.attr(
                'action',
                "{{ route('admin.reserva.piscina.update', ['id' => '__ID__']) }}".replace(
                    '__ID__',
                    id
                )
            );
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
    </script>
@stop
