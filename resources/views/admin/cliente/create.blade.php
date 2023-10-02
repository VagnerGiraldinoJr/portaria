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
                                ,'id' => 'form-pedido'
                                ,'class' => 'form'
                                ,'method' => 'put'
                            ])
                        }}
                    @else
                        {{ Form::open(['route' => $params['main_route'].'.store'
                                        ,'id' => 'form-pedido'
                                        ,'method' =>'post']) }}
                    @endif
                    <div class="row">
                        {{--
                            id, tipo, cpf_cnpj, data_nascimento, nome_razaosocial,
                            cep, logradouro, complemento, bairro, localidade, uf,
                            email, telefone, celular, recado, observacoes
                            --}}
                            @dd(Auth::user()->lotacao )
                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('cpf_cnpj', 'CPF / CNPJ')}}
                            @if(isset($data))
                            {{Form::text('cpf_cnpj',null,['class' => 'form-control cpf_cnpj', 'data-class' => 'cliente', 'placeholder' => 'CPF / CNPJ'])}}
                            @else
                            {{Form::text('cpf_cnpj',null,['class' => 'form-control cpf_cnpj create ', 'data-class' => 'cliente', 'placeholder' => 'CPF / CNPJ'])}}
                            @endif
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('data_nascimento', 'Data de Nascimento')}}
                            <br>
                            {{Form::date('data_nascimento',(isset($data->data_nascimento)? \Carbon\Carbon::parse($data->data_nascimento) : null ),['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            {{Form::label('nome_razaosocial', 'Nome / Razão Social')}}
                            {{Form::text('nome_razaosocial',null,['class' => 'form-control', 'data-class' => 'cliente', 'placeholder' => 'Nome / Razão Social'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('cep', 'CEP')}}
                            {{Form::text('cep',null,['class' => 'form-control buscarcep', 'data-class' => 'cliente', 'placeholder' => '00.000-000'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('logradouro', 'Logradouro')}}
                            {{Form::text('logradouro',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('localidade', 'Cidade')}}
                            {{Form::text('localidade',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('uf', 'UF')}}
                            {{Form::text('uf',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('bairro', 'Bairro')}}
                            {{Form::text('bairro',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('numero', 'Número')}}
                            {{Form::text('numero',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('complemento', 'Complemento')}}
                            {{Form::text('complemento',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('email', 'E-mail')}}
                            {{Form::text('email',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('telefone', 'Telefone Principal')}}
                            {{Form::text('telefone',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('celular', 'Celular')}}
                            {{Form::text('celular',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('recado', 'Recado')}}
                            {{Form::text('recado',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('observacoes', 'Observações')}}
                            {{Form::text('observacoes',null,['class' => 'form-control', 'data-class' => 'cliente'])}}
                        </div>


                        <div class="form-group">
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


@section('js')
    <script src="{{ asset('plugin/jquery.mask.min.js')}}" ></script>
    <script src="{{ asset('js/scripts.js')}}" ></script>
    <script src="{{ asset('js/ajax.js')}}" ></script>
    <script src="{{ asset('js/cliente.js')}}" ></script>
@stop
