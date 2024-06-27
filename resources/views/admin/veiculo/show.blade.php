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
                    <div class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('placa', 'Placa')}}
                            {{Form::text('placa',$data['placa'],['class' => 'form-control placa', 'readonly', 'placeholder' => 'Informe a Placa'])}}
                        </div>
                        <div class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('modelo', 'Modelo')}}
                            {{Form::text('modelo',$data['modelo'],['class' => 'form-control', 'readonly', 'placeholder' => 'Modelo'])}}
                        </div>
                        <div class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('tipo', 'Tipo')}}<br>
                            {{Form::select('tipo',  $preload['tipo'],
                                ((isset($data->tipo)) ? $data->tipo : null), ['class' => 'form-control','readonly',]                               
                            )}}
                        </div>

                        <div class="form-group col-6 col-md-6 col-lg-6">
                            {{Form::label('observacao', 'Observação')}}
                            {{Form::text('observacao',$data['observacao'],['class' => 'form-control','readonly', 'placeholder' => 'Observação / Cor'])}}
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
    <link rel="stylesheet" href="/css/style.css">
@stop

@section('js')

@stop
