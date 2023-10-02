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
                    <div class="form-group">
                        {{Form::label('name', 'Nome')}}
                        {{Form::text('name',null,['class' => 'form-control', 'placeholder' => 'Nome'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('email', 'E-mail')}}
                        {{Form::text('email',null,['class' => 'form-control', 'placeholder' => 'E-mail'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('role', 'Papel')}}
                        {{Form::select('role',
                                $preload['roles'],
                                ((isset($data->role)) ? $data->role : null),
                                ['id'=>'role','class' =>'form-control', 'placeholder' => 'Selecione'])}}
                    </div>
                    {{-- OCULTA SE FOR EDITAR --}}
                    @if( ! isset($data))

                    <div class="form-group">
                        {{Form::label('password', 'Senha')}}
                        {{Form::password('password',['class' => 'form-control', 'placeholder' => 'Senha'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('password_confirmation', 'Confirmar Senha')}}
                        {{Form::password('password_confirmation',['class' => 'form-control', 'placeholder' => 'Confirmar Senha', 'type' =>'password'])}}
                    </div>

                    @endif
                    {{-- ATÉ AQUI OCULTA SE FOR EDITAR --}}

                    <div class="form-group">
                        {{Form::submit('Salvar',['class'=>'btn btn-success btn-sm'])}}
                    </div>
                    {{ Form::close() }}
                </div>
                <!-- /.card-body -->
              </div>


           </div>
       </div>
    </section>
@stop



@section('js')

@stop
