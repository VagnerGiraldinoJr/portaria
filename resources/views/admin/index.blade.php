@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    <section id="app" class="content">
        <div class="row">
            {{-- Seção dos Cards Informativos --}}
            @role('admin')
                @foreach (range(1, 4) as $index)
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info shadow-sm">
                            <div class="inner">
                                <p>CARD {{ $index }}</p>
                                <h3>{{ '#' }}</h3>
                            </div>
                            <div class="icon">
                                <i class="fa fa-key"></i>
                            </div>
                            <a href="{{ route($params['main_route'] . '.reserva.index') }}" class="small-box-footer">
                                Ver Mais <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endrole

            @unless (auth()->user()->hasRole('admin'))
                {{-- Card Entregas Realizadas --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger shadow-sm">
                        <div class="inner">
                            <h3>{{ $data['EncomendasEntregues'] }}</h3>
                            <p>Entregas Realizadas</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-gift"></i>
                        </div>
                        <a href="{{ route($params['main_route'] . '.controleacesso.index') }}" class="small-box-footer">
                            Ver Mais <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Card Entregas Pendentes --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning shadow-sm">
                        <div class="inner">
                            <h3>{{ $data['EncomendasNaoEntregues'] }}</h3>
                            <p>Entregas Pendentes</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <a href="{{ route($params['main_route'] . '.controleacesso.index') }}" class="small-box-footer">
                            Ver Mais <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Card Total de Moradores --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary shadow-sm">
                        <div class="inner">
                            <h3>{{ $totalPessoas }}</h3>
                            <p>Total de Moradores</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="{{ route($params['main_route'] . '.pessoa.index') }}" class="small-box-footer">
                            Ver Mais <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Card Visitantes --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary shadow-sm">
                        <div class="inner">
                            <h3>{{ $data['QuantidadesVisitantes'] }} / {{ $data['QuantidadesCadVisitantes'] }}</h3>
                            <p>Visitantes no Condomínio</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard"></i>
                        </div>
                        <a href="{{ route($params['main_route'] . '.visitante.index') }}" class="small-box-footer">
                            Ver Mais <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            @endunless
        </div>

        {{-- Calendário Resumido --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title"><i class="fas fa-calendar-alt"></i> Calendário de Eventos</h3>
                    </div>
                    <div class="card-body">
                        <div id="small-calendar"></div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.calendario.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Ver Calendário Completo
                        </a>
                    </div>
                </div>
            </div>
        </div>


        {{-- Gráfico de Reservas --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">📊 Gráfico de Reservas por Mês</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>


        {{-- To-Do List --}}
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-tasks"></i> Lista de Tarefas</h3>
                    </div>
                    <div class="card-body">
                        <ul id="todo-list" class="list-group">
                            <li class="list-group-item">✅ Verificar entregas pendentes</li>
                            <li class="list-group-item">📅 Atualizar calendário com novos eventos</li>
                            <li class="list-group-item">🔑 Revisar controle de acesso</li>
                            <li class="list-group-item">📊 Analisar relatório de reservas</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center mt-4">
        &copy; {{ date('Y') }} GIT CONSULTORIA INOVAÇÕES EM SOLUÇÕES DE TI LTDA - Todos os direitos reservados
    </footer>
@stop

@section('css')
    <style>
        /* Altura ajustada para o Calendário Resumido */
        #small-calendar {
            height: 600px;
            /* Ajuste a altura conforme necessário */
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }

        /* Cores para Tipos de Eventos */
        .fc-event.evento {
            background-color: #3dd245ca !important;
            /* Verde para Eventos */
            border-color: #3dd245ca !important;

        }

        .fc-event.reserva {
            background-color: #f2983ec2 !important;
            /* Laranja para Reservas */
            border-color: #f2983ec2 !important;
        }

        .fc-event.reserva_piscina {
            background-color: #3796c9d3 !important;
            /* Azul para Reservas Piscina */
            border-color: #3796c9d3 !important;
        }

        /* Indicadores de Status */
        .fc-event .fc-event-title i {
            margin-left: 5px;
            font-size: 10px;
            vertical-align: middle;
        }

        .fc-event .fc-event-title i.fas.fa-clock {
            color: #FFC107;
            /* Amarelo - Pendente */
        }

        .fc-event .fc-event-title i.fas.fa-check-circle {
            color: #28A745;
            /* Verde - Confirmada */
        }

        .fc-event .fc-event-title i.fas.fa-times-circle {
            color: #DC3545;
            /* Vermelho - Cancelada */
        }
    </style>
@stop


@section('js')
    <!-- FullCalendar Script -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <!-- Chart.js UMD -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 🗓️ Inicialização do Calendário Resumido
            var smallCalendarEl = document.getElementById('small-calendar');
            var smallCalendar = new FullCalendar.Calendar(smallCalendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                editable: false,
                height: 600,
                events: @json($data['eventos'] ?? []),

                eventDidMount: function(info) {
                    let type = info.event.extendedProps.type;
                    let status = info.event.extendedProps.status;

                    if (type === 'evento') {
                        info.el.classList.add('evento');
                    } else if (type === 'reserva') {
                        info.el.classList.add('reserva');
                    } else if (type === 'reserva_piscina') {
                        info.el.classList.add('reserva_piscina');
                    }

                    let statusIndicator = document.createElement('span');
                    statusIndicator.style.marginLeft = '5px';
                    statusIndicator.style.fontSize = '10px';

                    if (status === 'Pendente') {
                        statusIndicator.innerHTML =
                            '<i class="fas fa-clock" title="Pendente"></i>';
                    } else if (status === 'Confirmada') {
                        statusIndicator.innerHTML =
                            '<i class="fas fa-check-circle" title="Confirmada"></i>';
                    } else if (status === 'Cancelada') {
                        statusIndicator.innerHTML =
                            '<i class="fas fa-times-circle" title="Cancelada"></i>';
                    }

                    let titleElement = info.el.querySelector('.fc-event-title');
                    if (titleElement) {
                        titleElement.insertAdjacentElement('beforeend', statusIndicator);
                    } else {
                        info.el.appendChild(statusIndicator);
                    }
                }
            });

            smallCalendar.render();

            // 📊 Gráfico de Reservas
            var ctxLine = document.getElementById('lineChart').getContext('2d');
            var lineChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: @json($data['QuantidadesControleAcessoPorMes']->pluck('mes')),
                    datasets: [{
                        label: 'Reservas',
                        data: @json($data['QuantidadesControleAcessoPorMes']->pluck('total_reservas')),
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@stop
