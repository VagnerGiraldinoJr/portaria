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
                            <a href="{{ route($params['main_route'].'.index')}}" class="btn btn-primary btn-xs">
                                <span class="fas fa-arrow-left"></span> Voltar</a>
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
                    @if( isset($data))
                    {{
                            Form::model($data,[
                                'route' => [$params['main_route'].'.update',$data->id]
                                ,'class' => 'form'
                                ,'method' => 'put'
                            ])
                        }}
                    @else
                    {{ Form::open(['route' => $params['main_route'].'.store','method' =>'post']) }}
                    @endif
                    <div class="row">

                        <div class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('rg', 'RG/CPF')}}
                            {{Form::text('rg',null,['class' => 'form-control rg', 'placeholder' => 'Informe o número do RG/CPF completo'])}}
                        </div>

                        <div class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('nome_completo', 'Nome Completo')}}
                            {{Form::text('nome_completo',null,['class' => 'form-control', 'placeholder' => 'Informe o nome completo'])}}
                        </div>
                        
                        <div class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('celular', 'Nº Celular')}}
                            {{Form::text('celular',null,['class' => 'form-control celular', 'placeholder' => 'Informe o número celular'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-12">
                            {{Form::label('tipo', 'Classificação')}}<br>
                            {{Form::select('tipo', $preload['tipo'],
                                ((isset($data->tipo)) ? $data->tipo : null), ['class' => 'form-control']                               
                            )}}
                        </div>

                        <div class="form-group col-6 col-md-6 col-lg-6 pt-2">
                            {{Form::submit('Salvar',['class'=>'btn btn-success btn-sm'])}}
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
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{ asset('plugin/jquery.mask.min.js')}}" ></script>
    <script src="{{ asset('js/scripts.js')}}" ></script>
@stop

