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
                                <a href="{{ route($params['main_route'] . '.index') }}" class="btn btn-primary btn-xs"><span
                                        class="fas fa-arrow-left"></span> Voltar</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body ">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="m-0 ">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (isset($data))
                            {{ Form::model($data, [
                                'route' => [$params['main_route'] . '.update', $data->id],
                                'class' => 'form',
                                'method' => 'put',
                            ]) }}
                        @else
                            {{ Form::open(['route' => $params['main_route'] . '.store', 'method' => 'post']) }}
                        @endif
                        <div class="row">
                            <!-- Tipo de Acesso -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('tipo', 'Tipo de Acesso') }}<br>
                                {{ Form::select('tipo', $preload['tipo'], isset($data->tipo) ? $data->tipo : null, [
                                    'class' => 'form-control',
                                    'onChange' => 'selectColuna();',
                                ]) }}
                            </div>

                            <!-- Unidade/Apto -->
                            <div id="div_lote" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('lote', 'Unidade/Apto.') }}
                                {{ Form::select('lote_id', $preload['unidade'], isset($data->lote_id) ? $data->lote_id : null, [
                                    'class' => 'form-control',
                                    'id' => 'lote',
                                    'onChange' => 'buscarMoradoresLote();',
                                ]) }}
                            </div>

                            <!-- Campo para Selecionar o Morador -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                <label for="morador_id">Destinatário</label>
                                <select name="morador_id" id="morador_id" class="form-control">
                                    <option value="">Selecione um morador</option>
                                </select>
                            </div>

                            <!-- Documento do Morador -->
                            <div id="div_rg_pessoa" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('rg_pessoa', 'Documento') }}
                                {{ Form::text('rg_pessoa', null, ['class' => 'form-control', 'placeholder' => 'Documento', 'readonly' => 'readonly']) }}
                            </div>

                            <!-- Nome do Entregador -->
                            <div id="div_entregador" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('entregador', 'Nome do Entregador ou Empresa') }}
                                {{ Form::text('entregador', null, ['class' => 'form-control', 'placeholder' => 'Informe o nome entregador ou empresa']) }}
                            </div>

                            <!-- Motivo -->
                            <div id="div_motivo" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('motivo', 'Motivo') }}
                                {{ Form::text('motivo', null, ['class' => 'form-control', 'placeholder' => 'Informe o Motivo']) }}
                            </div>

                            <!-- Observação -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('observacao', 'Observação') }}
                                {{ Form::text('observacao', isset($data->observacao) ? $data->observacao : null, ['class' => 'form-control', 'placeholder' => 'Observação']) }}
                            </div>

                            <!-- Botão Salvar -->
                            <div class="form-group col-6 col-md-6 col-lg-8 pt-2">
                                {{ Form::submit('Salvar', ['class' => 'btn btn-success btn-sm']) }}
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('js/plugin/jquery-ui/jquery-ui.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/plugin/jquery.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        // Atualiza a lista de moradores quando o lote for selecionado
        function buscarMoradoresLote() {
            const loteId = document.getElementById('lote').value;

            // Faz uma requisição Ajax para buscar os moradores do lote selecionado
            fetch(`/admin/controle_acessos/get-moradores-by-lote?lote_id=${loteId}`)
                .then(response => response.json())
                .then(data => {
                    const moradorSelect = document.getElementById('morador_id');

                    // Limpa as opções atuais
                    moradorSelect.innerHTML = '<option value="">Selecione um morador</option>';

                    if (data.length > 0) {
                        // Preenche o dropdown com os moradores
                        data.forEach(morador => {
                            const option = document.createElement('option');
                            option.value = morador.id;
                            option.textContent = morador.nome_completo;
                            moradorSelect.appendChild(option);
                        });
                    } else {
                        // Caso não tenha moradores, exibe uma mensagem no dropdown
                        const option = document.createElement('option');
                        option.value = '';
                        option.textContent = 'Nenhum morador encontrado';
                        moradorSelect.appendChild(option);
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar moradores do lote:', error);
                });
        }

        document.getElementById('morador_id').addEventListener('change', function() {
            const moradorId = this.value;

            if (moradorId) {
                // Faz uma requisição Ajax para buscar os dados do morador selecionado
                fetch(`/admin/controle_acessos/get-morador-detalhes?morador_id=${moradorId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            // Atualiza o campo de documento com os dados do morador
                            document.getElementById('rg_pessoa').value = data.rg;
                        } else {
                            // Caso não encontre dados, limpa o campo
                            document.getElementById('rg_pessoa').value = '';
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar detalhes do morador:', error);
                        document.getElementById('rg_pessoa').value = '';
                    });
            } else {
                // Limpa o campo caso nenhum morador seja selecionado
                document.getElementById('rg_pessoa').value = '';
            }
        });
    </script>
@stop
