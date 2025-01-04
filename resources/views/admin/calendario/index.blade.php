@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    <section class="content">
        <div id="app" class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row p-2">
                            <div class="col-6">
                                <h3 class="card-title font-weight-bold">
                                    {{ $params['subtitulo'] ?? 'Calendário de Eventos e Reservas' }}</h3>
                            </div>
                            <div class="col-6 text-right">
                                <a href="{{ route($params['main_route'] . '.create') }}" class="btn btn-primary btn-xs">
                                    <span class="fas fa-plus"></span> Novo Evento
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-header">
                        {{ Form::open(['route' => $params['main_route'] . '.index', 'method' => 'post', 'class' => 'form']) }}
                        <div class="row">
                            <div class="col-4">
                                {{ Form::text('data_inicio', isset($searchFields['data_inicio']) ? $searchFields['data_inicio'] : '', ['class' => 'form-control', 'placeholder' => 'Data de Início']) }}
                            </div>
                            <div class="col-4">
                                {{ Form::text('data_fim', isset($searchFields['data_fim']) ? $searchFields['data_fim'] : '', ['class' => 'form-control', 'placeholder' => 'Data de Fim']) }}
                            </div>
                            <div class="col-4 d-flex align-items-center">
                                {{ Form::submit('Buscar', ['class' => 'btn btn-primary btn-xl']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>

                    <!-- Calendário -->
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>

                    <div class="card-footer">
                        <small class="text-muted">📅 Gerencie as reservas diretamente no módulo de reservas.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    <style>
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }

        /* Estilização por tipo */
        .fc-event.evento {
            background-color: #3dd245ca !important;
            /* Verde */
            border-color: #3dd245ca !important;
        }

        .fc-event.reserva {
            background-color: #f2983ec2 !important;
            /* Laranja */
            border-color: #f2983ec2 !important;
        }

        .fc-event.reserva_piscina {
            background-color: #3796c9d3 !important;
            /* Azul */
            border-color: #3796c9d3 !important;
        }
    </style>
@stop

@section('js')
    <!-- FullCalendar Script -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                editable: true,
                height: 600,
                events: @json($data['eventos'] ?? []),

                // Evento ao montar na tela
                eventDidMount: function(info) {
                    let type = info.event.extendedProps.type;
                    let status = info.event.extendedProps.status;

                    // Adiciona classes de tipo de evento
                    if (type === 'evento') {
                        info.el.classList.add('evento');
                    } else if (type === 'reserva') {
                        info.el.classList.add('reserva');
                    } else if (type === 'reserva_piscina') {
                        info.el.classList.add('reserva_piscina');
                    }

                    // Adiciona indicador de status
                    let statusIndicator = document.createElement('span');
                    statusIndicator.style.marginLeft = '5px';
                    statusIndicator.style.fontSize = '12px';

                    if (status === 'Pendente') {
                        statusIndicator.innerHTML =
                            '<i class="fas fa-clock" style="color: #FFC107;" title="Pendente"></i>';
                    } else if (status === 'Confirmada') {
                        statusIndicator.innerHTML =
                            '<i class="fas fa-check-circle" style="color: #28A745;" title="Confirmada"></i>';
                    } else if (status === 'Cancelada') {
                        statusIndicator.innerHTML =
                            '<i class="fas fa-times-circle" style="color: #DC3545;" title="Cancelada"></i>';
                    }

                    // Insere o indicador no título do evento
                    let titleElement = info.el.querySelector('.fc-event-title');
                    if (titleElement) {
                        titleElement.insertAdjacentElement('beforeend', statusIndicator);
                    } else {
                        info.el.appendChild(statusIndicator);
                    }
                },

                // Evento ao clicar no evento do calendário
                eventClick: function(info) {
                    let eventId = info.event.id;
                    let title = info.event.title;
                    let start = info.event.start.toISOString().split('T')[0];
                    let end = info.event.end ? info.event.end.toISOString().split('T')[0] : '';

                    // Editar Título do Evento
                    let newTitle = prompt("Editar título do evento:", title);
                    if (newTitle !== null) {
                        fetch(`/admin/calendario/${eventId}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    title: newTitle,
                                    start: start,
                                    end: end
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    info.event.setProp('title', newTitle);
                                    alert('Evento atualizado com sucesso!');
                                } else {
                                    alert('Erro ao atualizar o evento.');
                                }
                            });
                    }

                    // Deletar Evento
                    if (confirm("Deseja deletar este evento?")) {
                        fetch(`/admin/calendario/${eventId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    info.event.remove();
                                    alert('Evento deletado com sucesso!');
                                } else {
                                    alert('Erro ao deletar o evento.');
                                }
                            });
                    }
                },

                // Evento ao arrastar e mover
                eventDrop: function(info) {
                    let eventId = info.event.id;
                    let start = info.event.start.toISOString().split('T')[0];
                    let end = info.event.end ? info.event.end.toISOString().split('T')[0] : '';

                    fetch(`/admin/calendario/${eventId}`, {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                start: start,
                                end: end
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Evento atualizado com sucesso!');
                            } else {
                                alert('Erro ao atualizar o evento.');
                            }
                        });
                }
            });

            calendar.render();
        });
    </script>
    <!-- FontAwesome para Ícones de Status -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
@stop
