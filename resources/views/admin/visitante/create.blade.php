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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ $params['subtitulo'] }}</h3>
                        <a href="{{ route($params['main_route'] . '.index') }}" class="btn btn-primary btn-sm ml-auto">
                            <span class="fas fa-arrow-left"></span> Voltar
                        </a>
                    </div>

                    <div class="card-body">
                        <!-- Exibir erros -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="m-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Formulário -->
                        {{ Form::open(['route' => 'admin.visitante.store', 'method' => 'POST']) }}
                        <div class="row">
                            <!-- Nome -->
                            <div class="form-group col-12 col-md-6">
                                {{ Form::label('nome', 'Nome') }}
                                {{ Form::text('nome', old('nome'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Digite o nome do visitante',
                                    'required',
                                ]) }}
                            </div>

                            <!-- Documento -->
                            <div class="form-group col-12 col-md-6">
                                {{ Form::label('documento', 'Documento') }}
                                {{ Form::text('documento', old('documento'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Digite o documento (RG ou CPF)',
                                    'required',
                                ]) }}
                            </div>

                            <!-- Placa do Veículo -->
                            <div class="form-group col-12 col-md-6">
                                {{ Form::label('placa_do_veiculo', 'Placa do Veículo') }}
                                {{ Form::text('placa_do_veiculo', old('placa_do_veiculo'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Digite a placa do veículo',
                                ]) }}
                            </div>

                            <!-- Unidade Visitada -->
                            <div class="form-group col-12 col-md-6">
                                <label for="lote_id">Bloco/Apartamento</label>
                                <select name="lote_id" id="lote_id" class="form-control">
                                    <option value="">Selecione o Bloco/Apartamento</option>
                                    @php $renderedOptions = []; @endphp
                                    @foreach ($lotes as $id => $descricao)
                                        @if (!in_array($descricao, $renderedOptions))
                                            <option value="{{ $id }}"
                                                @if (strtoupper($descricao) === 'SERVIÇOS GERAIS') class="highlight-option" @endif>
                                                {{ strtoupper($descricao) }}
                                            </option>
                                            @php $renderedOptions[] = $descricao; @endphp
                                        @endif
                                    @endforeach
                                </select>
                            </div>


                            <!-- Hora de Entrada -->
                            <div class="form-group col-12 col-md-6">
                                {{ Form::label('hora_de_entrada', 'Hora de Entrada') }}
                                {{ Form::datetimeLocal('hora_de_entrada', \Carbon\Carbon::now()->format('Y-m-d\TH:i'), [
                                    'class' => 'form-control datetime-input',
                                    'required',
                                ]) }}
                            </div>

                            <!-- Celular -->
                            <div class="form-group col-12 col-md-6">
                                {{ Form::label('celular', 'Número de Celular') }}
                                {{ Form::text('celular', old('celular'), [
                                    'class' => 'form-control celular',
                                    'placeholder' => 'Informe o número de celular com DDD (ex: (42) 9 96190016)',
                                ]) }}
                            </div>

                            <!-- Motivo da Entrada -->
                            <div class="form-group col-12">
                                {{ Form::label('motivo', 'Motivo da Entrada') }}

                                <!-- Botões Predefinidos -->
                                <div class="mb-2 motive-buttons d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-info btn-sm motive-option"
                                        data-value="ENTREGADORES_COMIDA" aria-label="Entregadores de comida">
                                        Entregadores em Geral
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-sm motive-option"
                                        data-value="UBER" aria-label="Motoristas Uber">
                                        Uber
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-sm motive-option"
                                        data-value="VISITANTES" aria-label="Visitantes">
                                        Visitantes
                                    </button>
                                    <button type="button" class="btn btn-outline-dark btn-sm motive-option"
                                        data-value="SERVICOS_GERAIS" aria-label="Serviços gerais em áreas comuns">
                                        Serviços Gerais em Áreas Comuns
                                    </button>
                                </div>

                                <!-- Campo de Entrada Manual -->
                                {{ Form::text('motivo', old('motivo'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'Digite ou selecione o motivo da entrada',
                                    'required',
                                ]) }}
                            </div>
                            <!-- Botão de Salvar -->
                            <div class="form-group col-12 text-right">
                                {{ Form::submit('Salvar', ['class' => 'btn btn-success']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const motiveButtons = document.querySelectorAll('.motive-option');
            const motiveInput = document.querySelector('input[name="motivo"]');

            motiveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove a classe "ativo" de todos os botões
                    motiveButtons.forEach(btn => btn.classList.remove('btn-selected'));

                    // Adiciona a classe "ativo" ao botão clicado
                    this.classList.add('btn-selected');

                    // Atualiza o valor do campo de entrada com o valor do botão clicado
                    motiveInput.value = this.getAttribute('data-value');
                });
            });
        });
    </script>
    <script src="{{ asset('js/plugin/jquery.js') }}"></script>
    <script src="{{ asset('plugin/jquery.mask.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Aplicar máscara ao campo de celular no formato "42 996190016"
            $('.celular').mask('00 000000000', {
                onKeyPress: function(cep, e, field, options) {
                    // Opcional: Adicione lógica para validar DDD ou outros requisitos aqui
                }
            });
        });
    </script>
@stop
