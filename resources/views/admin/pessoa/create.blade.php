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
                                <a href="{{ route($params['main_route'] . '.index') }}" class="btn btn-primary btn-xs">
                                    <span class="fas fa-arrow-left"></span> Voltar</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
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
                            <!-- Nome Completo -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('nome_completo', 'Nome Completo') }}
                                {{ Form::text('nome_completo', null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Informe o nome completo',
                                ]) }}
                            </div>

                            <!-- RG/CPF -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('rg', 'RG/CPF') }}
                                {{ Form::text('rg', null, [
                                    'class' => 'form-control rg',
                                    'placeholder' => 'Informe o número do RG/CPF completo',
                                ]) }}
                            </div>

                            <!-- Celular -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('celular', 'Nº Celular') }}
                                {{ Form::text('celular', null, [
                                    'class' => 'form-control celular',
                                    'placeholder' => 'Informe o número celular',
                                ]) }}
                            </div>

                            <!-- Lote -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('lote_id', 'Lote (Unidade/Apto)') }}
                                {{ Form::select('lote_id', $preload['lote_id'], $data->lote_id ?? null, [
                                    'class' => 'form-control',
                                    'id' => 'lote_id',
                                    'placeholder' => 'Selecione o lote',
                                ]) }}
                            </div>

                            <!-- Email -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('email', 'E-mail') }}
                                {{ Form::email('email', $data->email ?? null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Digite o e-mail do morador',
                                ]) }}
                            </div>

                            <!-- Classificação -->
                            <div class="form-group col-6 col-md-6 col-lg-6">
                                {{ Form::label('tipo', 'Classificação') }}
                                {{ Form::select('tipo', $preload['tipo'], $data->tipo ?? null, [
                                    'class' => 'form-control',
                                    'placeholder' => 'Selecione a classificação',
                                ]) }}
                            </div>

                            <!-- Botões -->
                            <div class="form-group col-12 pt-2">
                                {{ Form::submit('Salvar', ['class' => 'btn btn-success btn-sm']) }}
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>

                    <!-- /.card-body -->

                    <!-- Listagem de moradores associados -->
                    <div class="card-footer">
                        <h5>Moradores Associados ao Lote</h5>
                        <div id="pessoas_do_lote" class="p-2 border">
                            <div id="morador-alert" class="alert alert-info text-center">
                                <strong>Nenhum morador associado a este lote.</strong>
                            </div>
                        </div>
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
    <script src="{{ asset('js/plugin/jquery.js') }}"></script>
    <script src="{{ asset('plugin/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>


    <script>
        // Atualiza a lista de pessoas quando o lote for selecionado
        document.getElementById('lote_id').addEventListener('change', function() {
            const loteId = this.value;

            // Faz uma requisição Ajax para buscar os moradores do lote selecionado
            fetch(`/admin/pessoa/get-pessoas-by-lote?lote_id=${loteId}`)
                .then(response => response.json())
                .then(data => {
                    const pessoasContainer = document.getElementById('pessoas_do_lote');

                    // Limpa o conteúdo atual
                    pessoasContainer.innerHTML = '';

                    if (data.length > 0) {
                        // Adiciona um alerta visual indicando que existem moradores
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-success text-center';
                        alert.innerHTML =
                            `<strong>${data.length} morador(es) encontrado(s) neste lote.</strong>`;
                        pessoasContainer.appendChild(alert);

                        // Cria uma tabela para exibir os moradores
                        const table = document.createElement('table');
                        table.classList.add('table', 'table-bordered', 'mt-2');

                        const thead = document.createElement('thead');
                        thead.innerHTML = `
                            <tr>
                                <th>Nome Completo</th>
                                <th>RG</th>
                                <th>Celular</th>
                                <th>Classificação</th>
                                <th>Ações</th>
                            </tr>
                        `;
                        table.appendChild(thead);

                        const tbody = document.createElement('tbody');
                        data.forEach(pessoa => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${pessoa.nome_completo}</td>
                                <td>${pessoa.rg}</td>
                                <td>${pessoa.celular}</td>
                                <td>${pessoa.desc_tipo || pessoa.tipo}</td>
                                <td>
                                    <form method="POST" action="/admin/pessoa/${pessoa.id}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                    </form>
                                </td>
                            `;
                            tbody.appendChild(row);
                        });

                        table.appendChild(tbody);
                        pessoasContainer.appendChild(table);
                    } else {
                        // Exibe mensagem caso não existam pessoas associadas
                        pessoasContainer.innerHTML = `
                            <div class="alert alert-info text-center">
                                <strong>Nenhum morador associado a este lote.</strong>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Erro ao buscar pessoas do lote:', error);
                });
        });
    </script>




@stop
