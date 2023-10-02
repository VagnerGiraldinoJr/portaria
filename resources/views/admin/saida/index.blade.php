@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    <section  class="content" >
       <div id="app" class="row">

           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row p-2">
                        <div class="col-12">
                            <h3 class="card-title font-weight-bold">{{$params['subtitulo']}}</h3>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(Session::has('jsAlert') )
                        <div id="alert" class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong> {{ session()->get('jsAlert') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0 ">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if($preload['caixa'])

                        {{ Form::open(['id' => 'form-entrada', 'route' => 'admin.saidas.registrar' ,'method' =>'post','class' => 'form']) }}
                        <div class="row">
                            {{--
                            id, valor, tipo, forma_pagamento, data_hora, cadastrado_por, referencia, deleted_at, created_at, updated_at --}}

                            <div class="form-group col-3 col-md-3 col-lg-3">
                                {{Form::label('valor', 'Valor')}}
                                {{Form::text('valor',null,['class' => 'form-control money',  'placeholder' => 'Valor R$'])}}
                                {{Form::hidden('operacao',0)}}
                            </div>

                            <div class="form-group col-4 col-md-3 col-lg-3">
                                {{Form::label('forma_pagamento', 'Tipo Retirada')}}
                                {{Form::select('forma_pagamento',
                                                $preload['formas_pagamento'],
                                                ((isset($data['forma_pagamento'])) ? $data['forma_pagamento'] : null),
                                                ['id'=>'forma_pagamento','class' =>'form-control','placeholder' => 'Tipo Retirada'])}}
                            </div>
                            <div class="form-group col-5 col-md-6 col-lg-6">
                                {{Form::label('descricao', 'Descrição',  ['id'=>'label_descricao'])}}
                                {{Form::text('referencia',null,['class' => 'form-control', 'maxlength' => 30, 'placeholder' => 'Referência'])}}
                            </div>
                            </div>
                            <div class="col-12 d-flex align-items-center">
                                <div id="response" class="alert alert-primary w-100 d-none" role="alert">
                                </div>
                            </div>
                            <div class="col-12 d-flex align-items-center">
                                {{ Form::submit('Registrar',['class'=>'btn btn-primary btn-xl'])}}
                            </div>
                        </div>
                    {{ Form::close() }}
                    @else
                        <div class="alert alert-danger  d-flex align-items-center justify-content-between m-2" role="alert">
                            <span>Caixa Fechado, Não é possível realizar lançamentos</span>
                            <span>
                                {{ Form::open(['route' => 'admin.caixa.abrir','method' =>'POST']) }}
                                {{ Form::submit('Abrir Caixa',['class'=>'btn btn-primary btn-md'])}}
                                {{ Form::close() }}
                            </span> 
                        </div>
                    @endif
                </div>
                <!-- /.card-body -->
                <!-- /.card-body -->

              </div>


           </div>
       </div>

    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
@stop

@section('js')
    <script src="{{ asset('plugin/jquery.mask.min.js')}}" ></script>
    <script src="{{ asset('js/saida.js')}}" ></script>
    @if(Session::has('jsAlert'))
    <script type="text/javascript" >
        $('#alert').alert(function(){
            window.setTimeout(function() {
                $("#alert").alert('dispose');
            }, 3000);
        });
    </script>
    @endif
@stop


