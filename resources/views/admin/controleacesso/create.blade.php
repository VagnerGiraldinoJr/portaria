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

                            {{-- id, tipo, lote_id, veiculo_id, motorista, motivo, observacao, data_entrada, data_saida, created_at, updated_at --}}

                            <input type="hidden" id="veiculo_id" name="veiculo_id" value="">
                            <input type="hidden" id="lote_id" name="lote_id" value="">

                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('tipo', 'Tipo de Acesso') }}<br>
                                {{ Form::select('tipo', $preload['tipo'], isset($data->tipo) ? $data->tipo : null, [
                                    'class' => 'form-control',
                                    'onChange' => 'selectColuna();',
                                ]) }}
                            </div>

                            <div id="div_placa" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('placa', 'Placa') }}
                                {{ Form::text('placa', isset($data->veiculo) && sizeof($data->veiculo) ? $data->veiculo[0]->placa : '', [
                                    'class' => 'form-control placa',
                                    'onChange' => 'buscarPlaca()',
                                    'placeholder' => 'Informe a Placa',
                                ]) }}
                            </div>

                            <!-- {{-- UNIDADE --}} -->
                            <div id="div_lote" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('lote', 'Unidade/Apto.') }}
                                <br>
                                {{ Form::select('lote', $preload['unidade'], isset($data->lote_id) ? $data->lote_id : null, [
                                    'class' => 'form-control',
                                    'onChange' => 'buscarLote()',
                                ]) }}
                            </div>

                            <!-- {{-- MODELO --}} -->
                            <div id="div_modelo_veiculo" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('modelo_veiculo', 'Modelo') }}
                                {{ Form::text('modelo_veiculo', null, ['class' => 'form-control', 'readonly', 'placeholder' => 'Informe o Modelo']) }}
                            </div>

                            <!-- {{-- MODELO --}} -->
                            <div id="div_observacao_veiculo" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('observacao_veiculo', 'Observação / Cor') }}
                                {{ Form::text('observacao_veiculo', null, ['class' => 'form-control', 'readonly', 'placeholder' => 'Observação / Cor']) }}
                            </div>

                            <!-- {{-- MOTORISTA --}} -->
                            <div id="div_motorista" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('motorista', 'Motorista') }}
                                {{ Form::text('motorista', isset($data->motorista) ? $data->motorista : null, ['class' => 'form-control', 'placeholder' => 'Informe o Motorista']) }}
                            </div>

                            <div id="div_nome_pessoa" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('nome_pessoa', 'Nome Completo') }}
                                {{ Form::text('nome_pessoa', null, ['class' => 'form-control', 'placeholder' => 'Nome Completo', 'readonly' => 'readonly']) }}
                            </div>

                            <div id="div_rg_pessoa" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('rg_pessoa', 'Documento') }}
                                {{ Form::text('rg_pessoa', null, ['class' => 'form-control', 'placeholder' => 'Documento', 'readonly' => 'readonly']) }}
                            </div>

                            <!-- {{-- ENTREGADOR --}} -->
                            <div id="div_entregador" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('entregador', 'Nome do Entregador ou Empresa') }}
                                {{ Form::text('entregador', null, ['class' => 'form-control', 'placeholder' => 'Informe o nome entregador ou empresa']) }}
                            </div>
                            <!-- {{-- MOTIVO --}} -->
                            <div id="div_motivo" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('motivo', 'Motivo') }}
                                {{ Form::text('motivo', null, ['class' => 'form-control', 'placeholder' => 'Informe o Motivo']) }}
                            </div>
                            <!-- {{-- OBSERVACAO --}} -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('observacao', 'Observação') }}
                                {{ Form::text('observacao', isset($data->observacao) ? $data->observacao : null, ['class' => 'form-control', 'placeholder' => 'Observação']) }}
                            </div>

                            <div id="div_botao_placa" class="d-none form-group col-12 col-md-12 col-lg-12">
                                <a href="{{ route('admin.veiculo.create') }}"
                                    class="btn btn-primary btn-lg d-flex align-self-end">
                                    <span class="p-1 fas fa-plus"> Cadastrar novo Veículo</span>
                                </a>
                            </div>
                            <div id="div_botao_rg" class="d-none form-group col-6 col-md-6 col-lg-6">
                                <a href="{{ route('admin.lote.create') }}"
                                    class="btn btn-primary btn-lg d-flex align-self-end">
                                    <span class="p-1 fas fa-plus"> Cadastrar Lote / Apto</span>
                                </a>
                            </div>
                            {{-- -BOTAO SALVAR- --}}
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
    <!-- <link rel="stylesheet" href="/css/style.css"> -->
    <link rel="stylesheet" href="{{ asset('js/plugin/jquery-ui/jquery-ui.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/plugin/jquery.js') }}"></script>
    <script src="{{ asset('js/plugin/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script>
        function selectColuna() {
            var tipo = document.getElementById('tipo').value;
            if (tipo == 1) {
                document.getElementById('div_placa').style.display = "none";
                document.getElementById('div_modelo_veiculo').style.display = "none";
                document.getElementById('div_observacao_veiculo').style.display = "none";
                document.getElementById('div_motorista').style.display = "none";

                document.getElementById('div_lote').style.display = "block";
                document.getElementById('div_nome_pessoa').style.display = "block";
                document.getElementById('div_rg_pessoa').style.display = "block";
                document.getElementById('entregador').style.display = "block";
                document.getElementById('div_motivo').style.display = "block";
                buscarLote();

            } else {
                document.getElementById('div_placa').style.display = "block";
                document.getElementById('div_modelo_veiculo').style.display = "block";
                document.getElementById('div_observacao_veiculo').style.display = "block";
                document.getElementById('div_motorista').style.display = "block";

                document.getElementById('div_lote').style.display = "none";
                document.getElementById('div_nome_pessoa').style.display = "none";
                document.getElementById('div_rg_pessoa').style.display = "none";
                document.getElementById('entregador').style.display = "none";
                document.getElementById('div_motivo').style.display = "none";
            }
        };

        function buscarPlaca() {
            var placa = document.getElementById('placa').value;

            if (!placa != '') return;

            var ajax = new XMLHttpRequest();
            // Seta tipo de requisição e URL com os parâmetros
            ajax.open("GET", "{{ asset('api/veiculo/') }}/" + placa, true);
            // Envia a requisição
            ajax.send();
            // Cria um evento para receber o retorno.
            ajax.onreadystatechange = function() {
                // Caso o state seja 4 e o http.status for 200, é porque a requisiçõe deu certo.
                if (ajax.readyState == 4 && ajax.status == 200) {
                    var data = ajax.responseText;
                    if (!data == []) {
                        resultado = JSON.parse(data);
                        document.getElementById('placa').value = resultado.placa;
                        document.getElementById('modelo_veiculo').value = resultado.modelo;
                        document.getElementById('observacao_veiculo').value = resultado.observacao;
                        document.getElementById('veiculo_id').value = resultado.id;
                    } else {
                        document.getElementById('modelo').value = 'NÃO ENCONTRADO';
                        document.getElementById('observacao_veiculo').value = '';
                        document.getElementById('div_botao_placa').classList.remove("d-none");
                        document.getElementById('veiculo_id').value = '';
                    }
                } else {
                    document.getElementById('modelo').value = '';
                    document.getElementById('observacao_veiculo').value = '';
                    document.getElementById('veiculo_id').value = '';
                }
            }
        }

        function buscarLote() {
            var lote = document.getElementById('lote').value;

            if (!lote != '') return;

            var ajax = new XMLHttpRequest();
            // Seta tipo de requisição e URL com os parâmetros
            ajax.open("GET", "{{ asset('api/lote/') }}/" + lote, true);
            // Envia a requisição
            ajax.send();
            // Cria um evento para receber o retorno.
            ajax.onreadystatechange = function() {
                // Caso o state seja 4 e o http.status for 200, é porque a requisiçõe deu certo.
                if (ajax.readyState == 4 && ajax.status == 200) {
                    var data = ajax.responseText;
                    if (!data == []) {
                        resultado = JSON.parse(data);
                        document.getElementById('nome_pessoa').value = resultado.nome_completo;
                        document.getElementById('rg_pessoa').value = resultado.rg;
                        document.getElementById('lote_id').value = resultado.lote_id;
                    } else {
                        document.getElementById('nome_pessoa').value = 'NÃO ENCONTRADO';
                        document.getElementById('rg_pessoa').value = '';
                        document.getElementById('div_botao_rg').classList.remove("d-none");
                        document.getElementById('lote_id').value = '';
                    }
                } else {
                    document.getElementById('nome_pessoa').value = '';
                    document.getElementById('rg_pessoa').value = '';
                    document.getElementById('lote_id').value = '';
                }
            }
        }

        selectColuna();
    </script>
@stop
