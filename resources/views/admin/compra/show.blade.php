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
                    {{ Form::open(['route' => [$params['main_route'].'.destroy',$data->id],'method' =>'DELETE']) }}
                    <div class="row">



                        <div class="form-group col-12 col-md-3 col-lg-3">
                            {{Form::label('cpf_cnpj', 'CPF / CNPJ')}}
                            {{Form::text('cpf_cnpj',$data->cpf_cnpj,['id' =>'cpf_cnpj',  'class' => 'form-control cpf_cnpj ','readonly', 'placeholder' => 'CPF / CNPJ'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-6">
                            {{Form::label('nome_razaosocial', 'Nome / Razão Social')}}
                            {{Form::text('nome_razaosocial',$data->nome_razaosocial,['class' => 'form-control', 'placeholder' => 'Nome / Razão Social','readonly', 'data-cliente'=>'nome_razaosocial'])}}
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            {{Form::label('data_entrada', 'Data da Compra')}}
                            {{Form::date('data_entrada',(isset($data->data_entrada)? \Carbon\Carbon::parse($data->data_entrada) : null ),['class' => 'form-control','readonly'])}}

                        </div>
                    </div>
                    <hr>
                    <h5>Itens da Compra</h5>
                    @if( isset($data) && isset($data->itens))

                        {{-- id, compra_id, produto_id, quantidade, valor --}}
                        <div class="row" >
                            @foreach ($data->itens as $item)
                                @php
                                    $i=0;
                                @endphp
                                <div class="input-group items">
                                        <div  class="col-12 col-lg-8  pt-2">
                                            {{Form::select('produto_id',
                                                    $preload['produtos'],
                                                    $item->produto_id,
                                                    ['id'=>'produto_id','class' =>'form-control','placeholder' => 'Selecione o Produto','data-name'=>'produto_id' ,'disabled'])}}

                                        </div>
                                        <div  class="col-4 col-lg-2 pt-2">
                                            {{Form::text('quantidade',str_replace('.',',',$item->quantidade),['class' => 'form-control float qtd' ,'readonly',  'data-name' => 'quantidade','placeholder' => 'Qtdade'])}}
                                        </div>
                                        <div  class="col-5 col-lg-2 pt-2">
                                            {{Form::text('valor_unitario',str_replace('.',',',$item->valor),['class' => 'form-control money vlr_unitario' ,'readonly' ,  'data-name' => 'valor_unitario', 'placeholder' => 'Valor R$'])}}
                                        </div>
                                </div>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </div>

                    @endif

                    <hr>
                    <h5>Totais</h5>

                    <div class="row">
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('valor', 'Sub Total R$')}}
                            {{Form::text('valor',null,['class' => 'form-control sub_total','readonly', 'placeholder' => '0,00'])}}
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('acrescimo', 'Acréscimo')}}
                            {{Form::text('acrescimo',null,['class' => 'form-control acrescimo','readonly', 'placeholder' => '0,00'])}}
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('desconto', 'Desconto')}}
                            {{Form::text('desconto',null,['class' => 'form-control desconto','readonly', 'placeholder' => '0,00'])}}
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('valor_total', 'Valor Total R$')}}
                            {{Form::text('valor_total',null,['class' => 'form-control valor_total','readonly', 'placeholder' => '0,00'])}}
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-6 d-flex justify-content-start">
                            <a href="{{ route($params['main_route'].'.index') }}" class="btn btn-primary btn-sm"><span class="fas fa-arrow-left"></span>  Voltar</a>
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-6 d-flex justify-content-end">

                            {{Form::submit('Deletar',['class'=>'btn btn-danger btn-sm'])}}

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




@section('js')
    <script src="{{ asset('plugin/jquery.mask.min.js')}}" ></script>
    <script src="{{ asset('plugin/repeater.js')}}" ></script>
    <script src="{{ asset('js/compra.js')}}" ></script>
    <script src="{{ asset('js/ajax.js')}}" ></script>
    <script src="{{ asset('js/scripts.js')}}" ></script>
@stop
