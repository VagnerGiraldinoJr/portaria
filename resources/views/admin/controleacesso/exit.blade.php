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
                            <h3 class="card-title">{{$params['subtitulo']}}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route($params['main_route'].'.index')}}" class="btn btn-primary btn-xs"><span class="fas fa-arrow-left"></span> Voltar</a>
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

                   
                            {{ Form::open(['route' => [$params['main_route'].'.updateexit',$data->id],'method' =>'PUT']) }}

                            <div class="row">
                            <div id="div_data_saida" class="form-group col-6 col-md-6 col-lg-6">
                                {{Form::label('data_saida', 'Data Saída Unidade')}}
                                {{Form::text('data_saida',NULL,['class' => 'form-control', 'placeholder' => 'Informe o data da Saída na unidade'])}}
                            </div>
                            </div>

                            {{Form::submit('Atualizar',['class'=>'btn btn-outline-info btn-sm'])}}
                            {{ Form::close() }}
                    

                    

                </div>
                <!-- /.card-body -->
            </div>


        </div>
    </div>
</section>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="{{ asset('js/plugin/jquery-ui/jquery-ui.min.css')}}">
@stop

@section('js')
<script src="{{ asset('js/scripts.js')}}"></script>
<script src="{{ asset('js/plugin/jquery.js')}}"></script>
<script src="{{ asset('js/plugin/jquery.mask.js')}}"></script>
<script src="{{ asset('js/plugin/jquery-ui/jquery-ui.min.js')}}"></script>

<script>
    $(function() {
        $('#data_saida').datepicker({
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
                $('#data_saida').val(datetext);
            },
        });
    });

</script>
@stop