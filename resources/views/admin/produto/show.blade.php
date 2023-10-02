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
                        {{--
                            id, titulo, tipo, unidade_medida, controla_estoque
                            --}}

                            <div class="form-group col-12 col-md-12 col-lg-12">
                                {{Form::label('titulo', 'Título')}}
                                {{Form::text('titulo', $data->titulo,['class' => 'form-control', 'placeholder' => 'Título','readonly'])}}
                            </div>

                            <div class="form-group col-12 col-md-12 col-lg-6">
                                {{Form::label('tipo', 'Tipo')}}
                                {{Form::select('tipo',
                                    $preload['tipo'],
                                    ((isset($data->tipo)) ? $data->tipo : null),
                                    ['id'=>'tipo','class' =>'form-control','placeholder' => 'Selecione','disabled'])}}
                            </div>
                            <div class="form-group col-12 col-md-12 col-lg-6">
                                {{Form::label('unidade_medida', 'Unidade de Medida')}}
                                {{Form::select('unidade_medida',
                                    $preload['unidade_medida'],
                                    ((isset($data->unidade_medida)) ? $data->unidade_medida : null),
                                    ['id'=>'unidade_medida','class' =>'form-control','placeholder' => 'Selecione', 'disabled'])}}
                            </div>
                            <div class="form-group col-12 col-md-12 col-lg-6">
                                {{Form::label('controla_estoque', 'Controla Estoque?')}}
                                {{Form::select('controla_estoque',
                                    $preload['controla_estoque'],
                                    ((isset($data->controla_estoque)) ? $data->controla_estoque : null),
                                    ['id'=>'controla_estoque','class' =>'form-control','placeholder' => 'Selecione','disabled'])}}
                            </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-6 d-flex justify-content-start">
                            <a href="{{ route($params['main_route'].'.index') }}" class="btn btn-primary btn-sm"><span class="fas fa-arrow-left"></span>  Voltar</a>
                        </div>
                        {{-- <div class="form-group col-12 col-md-12 col-lg-6 d-flex justify-content-end">
                            {{ Form::open(['route' => [$params['main_route'].'.destroy',$data->id],'method' =>'DELETE']) }}
                            {{Form::submit('Deletar',['class'=>'btn btn-danger btn-sm'])}}
                            {{ Form::close() }}
                        </div> --}}

                    </div>

                </div>
                <!-- /.card-body -->
              </div>


           </div>
       </div>
    </section>
@stop



@section('js')

@stop
