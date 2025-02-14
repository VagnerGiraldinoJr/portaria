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

                            <!-- Unidade/Apto - Alterado para um campo de busca -->
                            <div id="div_lote" class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('lote', 'Unidade/Apto.') }}
                                {{ Form::text('lote_nome', null, [
                                    'class' => 'form-control',
                                    'id' => 'lote_nome',
                                    'placeholder' => 'Digite o nome da unidade...',
                                    'autocomplete' => 'off',
                                ]) }}
                                {{ Form::hidden('lote_id', null, ['id' => 'lote_id']) }}
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
                                {{ Form::label('motivo', 'Quantidade/Volumes') }}
                                {{ Form::text('motivo', null, ['class' => 'form-control', 'placeholder' => 'Informe a Quantidade / Volumes']) }}
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
    <script src="{{ asset('js/plugin/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    <script>
        $(document).ready(function() {
            var urlBuscaLotes = "{{ route('admin.lotes.busca') }}";

            $("#lote_nome").autocomplete({
                source: function(request, response) {
                    console.log("🔍 Buscando lotes com:", request.term); // Debugging

                    $.ajax({
                        url: urlBuscaLotes,
                        dataType: "json",
                        data: {
                            q: request.term
                        },
                        success: function(data) {
                            console.log("✅ Dados recebidos:", data); // Debugging

                            if (data.error) {
                                console.error("❌ Erro na busca:", data.error);
                                return;
                            }

                            response($.map(data, function(item) {
                                return {
                                    label: item
                                    .descricao, // Exibir "APTO 101", "CASA 7", etc.
                                    value: item
                                    .descricao, // Preencher o campo de texto
                                    id: item.id // Armazena o ID do lote
                                };
                            }));
                        },
                        error: function(xhr) {
                            console.error("❌ Erro na requisição:", xhr.responseText);
                            alert(
                                "Erro ao buscar unidades. Verifique o console para detalhes.");
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $("#lote_nome").val(ui.item.value); // Preenche com a descrição do lote
                    $("#lote_id").val(ui.item.id); // Armazena o ID do lote no campo oculto
                    buscarMoradoresLote(ui.item.id); // Chama a função para carregar moradores
                    return false;
                }
            });

            // Evento de mudança no dropdown de moradores
            $("#morador_id").change(function() {
                let moradorId = $(this).val();

                if (moradorId) {
                    $.ajax({
                        url: `/admin/controle_acessos/get-morador-detalhes?morador_id=${moradorId}`,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            console.log("👤 Dados do morador:", data); // Debugging
                            $("#rg_pessoa").val(data ? data.rg : "");
                        },
                        error: function() {
                            console.error("❌ Erro ao buscar detalhes do morador.");
                            $("#rg_pessoa").val("");
                        }
                    });
                } else {
                    $("#rg_pessoa").val("");
                }
            });
        });

        // Função para buscar moradores do lote selecionado
        function buscarMoradoresLote(loteId) {
            console.log("🏠 Buscando moradores do lote:", loteId); // Debugging

            $.ajax({
                url: `/admin/controle_acessos/get-moradores-by-lote?lote_id=${loteId}`,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log("👥 Moradores recebidos:", data); // Debugging

                    let moradorSelect = $("#morador_id");
                    moradorSelect.empty().append('<option value="">Selecione um morador</option>');

                    if (data.length > 0) {
                        $.each(data, function(index, morador) {
                            moradorSelect.append(
                                `<option value="${morador.id}">${morador.nome_completo}</option>`
                            );
                        });
                    } else {
                        moradorSelect.append('<option value="">Nenhum morador encontrado</option>');
                    }
                },
                error: function() {
                    console.error("❌ Erro ao buscar moradores do lote.");
                }
            });
        }
    </script>
@stop
