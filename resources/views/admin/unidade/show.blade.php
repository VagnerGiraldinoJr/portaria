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

                    <div class="row">

                        <!-- Campos -->
                        <div class="form-group mx-sm-3 mb-2">
                            {{Form::label('id', 'ID')}}
                            {{Form::text('id',$data->id,['class' => 'form-control', 'readonly', 'placeholder' => 'Informe o nome completo'])}}
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            {{Form::label('titulo', 'Descrição')}}
                            {{Form::text('titulo',$data->titulo,['class' => 'form-control','readonly', 'placeholder' => 'Informe o número de titulo'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mx-sm-3 mb-4">
                            {{ Form::open(['route' => [$params['main_route'].'.destroy',$data->id],'method' =>'DELETE']) }}
                            {{Form::submit('Deletar',['class'=>'btn btn-danger btn-sm'])}}
                            {{ Form::close() }}
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