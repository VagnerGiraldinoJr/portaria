@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    <section class="content" >
       <div class="row">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">{{$params['subtitulo']}}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route($params['main_route'].'.index')}}" class="btn btn-primary btn-xs"><span class="fas fa-arrow-left"></span>  Voltar</a>
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

                    <div class="row">
                        <input type="hidden" id="veiculo_id" name="veiculo_id" value="">
                        <input type="hidden" id="pessoa_id" name="pessoa_id" value="">

                        <div class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('tipo', 'Tipo de acesso')}}<br>
                            {{Form::select('tipo', $preload['tipo'], ((isset($data->tipo)) ? $data->tipo : null),
                                ['class' => 'form-control' ,'disabled' => 'disabled', 'onChange' => 'selectColuna();']                               
                            )}}

                        </div>
                        <div id="div_placa" class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('placa', 'Placa')}}
                            {{Form::text('placa',((isset($data->veiculo) && sizeof($data->veiculo)) ? $data->veiculo[0]->placa : '')
                                ,['class' => 'form-control placa', 'onChange' => 'buscarPlaca()', 'readonly' => 'readonly'])}}
                        </div>

                        <div id="div_modelo" class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('modelo', 'Modelo')}}
                            {{Form::text('modelo',((isset($data->veiculo) && sizeof($data->veiculo)) ? $data->veiculo[0]->modelo : ''),['class' => 'form-control', 'readonly' => 'readonly'])}}
                        </div>


                        <div id="div_rg" class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('rg', 'RG')}}
                            {{Form::text('rg',((isset($data->pessoa) && sizeof($data->pessoa)) ? $data->pessoa[0]->rg : ''),['class' => 'form-control','onChange' => 'buscarRG()','readonly' => 'readonly'])}}
                        </div>


                        <div id="div_nome_completo" class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('nome_completo', 'Nome Completo')}}
                            {{Form::text('nome_completo',(( isset($data->pessoa) && sizeof($data->pessoa))  ? $data->pessoa[0]->nome_completo : ''),['class' => 'form-control', 'readonly' => 'readonly'])}}
                        </div>
                        {{-- Celular --}}
                        <div id="div_nome_completo" class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('celular', 'Celular')}}
                            {{Form::text('celular',(( isset($data->pessoa) && sizeof($data->pessoa))  ? $data->pessoa[0]->celular : ''),['class' => 'form-control', 'readonly' => 'readonly'])}}
                        </div>

                        <div id="div_motorista" class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('motorista', 'Motorista')}}
                            {{Form::text('motorista',(isset($data->motorista) ? $data->motorista : null),['class' => 'form-control', 'readonly' => 'readonly'])}}
                        </div>

                        <div id="div_data_entrada" class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('data_entrada', 'Data Entrada')}}
                            {{Form::text('data_entrada',(isset($data->data_entrada) ? $data->data_entrada : null),['class' => 'form-control', 'readonly' => 'readonly'])}}
                        </div>

                        <div id="motivo" class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('motivo', 'Motivo')}}
                            {{Form::text('motivo',(isset($data->motivo) ? $data->motivo : null),['class' => 'form-control', 'readonly' => 'readonly'])}}
                        </div>

                        <div id="motivo" class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('destino', 'Destino')}}
                            {{Form::text('destino',(isset($data->destino) ? $data->destino : null),['class' => 'form-control', 'readonly' => 'readonly'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-12 ">
                            {{ Form::open(['route' => [$params['main_route'].'.destroy',$data->id],'method' =>'DELETE']) }}
                            {{Form::submit('Deletar',['class'=>'btn btn-danger btn-sm'])}}
                            {{ Form::close() }}
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
              </div>


           </div>
       </div>
    </section>
@stop

@section('css')
@stop

@section('js')
<script src="{{ asset('js/scripts.js')}}"></script>
<script src="{{ asset('js/plugin/jquery.js')}}"></script>
<script src="{{ asset('js/plugin/jquery.mask.js')}}"></script>
<script src="{{ asset('js/plugin/jquery-ui/jquery-ui.min.js')}}"></script>

<script>
    $(function() {
        $('#data_entrada').datepicker({
            dateFormat: 'dd-mm-yy',
            onSelect: function(datetext) {
                var d = new Date(); // for now
                var h = d.getHours();
                h = (h < 10) ? ("0" + h) : h;

                var m = d.getMinutes();
                m = (m < 10) ? ("0" + m) : m;

                var s = d.getSeconds();
                s = (s < 10) ? ("0" + s) : s;

                datetext = datetext + " " + h + ":" + m + ":" + s;
                $('#data_entrada').val(datetext);
            },
        });
    });

    $(document).ready(function() {
        maskMercosul('.placa');
        $('#rg').mask('00000000000000');
    });



    function selectColuna() {
        var tipo = document.getElementById('tipo').value;
        if (tipo == 1) {
            document.getElementById('div_placa').style.display = "none";
            document.getElementById('div_modelo').style.display = "none";
            document.getElementById('div_motorista').style.display = "none";

            document.getElementById('div_rg').style.display = "block";
            document.getElementById('div_nome_completo').style.display = "block";

            buscarRG();

        } else {
            document.getElementById('div_rg').style.display = "none";
            document.getElementById('div_nome_completo').style.display = "none";

            document.getElementById('div_placa').style.display = "block";
            document.getElementById('div_modelo').style.display = "block";

            buscarPlaca();
        }

    };

    function resetarBotaoCadastro() {
        document.getElementById('div_botao_placa').classList.add("d-none");
        document.getElementById('div_botao_rg').classList.add("d-none");
    }

    function buscarPlaca() {
        var placa = document.getElementById('placa').value;

        if (!placa != '') return;

        var ajax = new XMLHttpRequest();

        // Seta tipo de requisição e URL com os parâmetros
        ajax.open("GET", "{{ asset('api/veiculo/')}}/" + placa, true);

        // Envia a requisição
        ajax.send();

        // Cria um evento para receber o retorno.
        ajax.onreadystatechange = function() {

            // Caso o state seja 4 e o http.status for 200, é porque a requisiçõe deu certo.
            if (ajax.readyState == 4 && ajax.status == 200) {

                var data = ajax.responseText;

                if (!data == []) {
                    resultado = JSON.parse(data);
                    document.getElementById('modelo').value = resultado.modelo;
                    document.getElementById('placa').value = resultado.placa;
                    document.getElementById('veiculo_id').value = resultado.id;
                } else {
                    document.getElementById('modelo').value = 'NÃO ENCONTRADO';
                    document.getElementById('div_botao_placa').classList.remove("d-none");
                }
            }
        }

    }

    function buscarRG() {
        var rg = document.getElementById('rg').value;

        if (!rg != '') return;

        var ajax = new XMLHttpRequest();

        // Seta tipo de requisição e URL com os parâmetros
        ajax.open("GET", "{{ asset('api/pessoa/')}}/" + rg, true);

        // Envia a requisição
        ajax.send();

        // Cria um evento para receber o retorno.
        ajax.onreadystatechange = function() {

            // Caso o state seja 4 e o http.status for 200, é porque a requisiçõe deu certo.
            if (ajax.readyState == 4 && ajax.status == 200) {

                var data = ajax.responseText;
                if (!data == []) {
                    document.getElementById('nome_completo').value = JSON.parse(data).nome_completo;
                    document.getElementById('rg').value = JSON.parse(data).rg;
                    document.getElementById('pessoa_id').value = JSON.parse(data).id;

                } else {
                    document.getElementById('nome_completo').value = 'NÃO ENCONTRADO';
                    document.getElementById('pessoa_id').value = '';
                    resetarBotaoCadastro();
                    document.getElementById('div_botao_rg').classList.remove("d-none");
                }

            }
        }

    }

    selectColuna();
</script>                    
@stop
