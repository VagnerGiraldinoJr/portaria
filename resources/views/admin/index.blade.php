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

            @unless(auth()->user()->hasRole('admin'))
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
        #small-calendar {
            height: 500px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Renderizar Calendário
            var calendarEl = document.getElementById('small-calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                events: @json($data['eventos'] ?? []),
            });
            calendar.render();

            // Renderizar Gráfico de Reservas
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
