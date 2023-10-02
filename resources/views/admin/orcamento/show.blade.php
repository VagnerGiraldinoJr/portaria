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
                            id, tipo, cpf_cnpj, data_nascimento, nome_razaosocial,
                            cep, logradouro, complemento, bairro, localidade, uf,
                            email, telefone, celular, recado, observacoes
                            --}}

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('cpf_cnpj', 'CPF / CNPJ')}}
                            @if(isset($data))
                            {{Form::text('cpf_cnpj',$data->cpf_cnpj,['class' => 'form-control', 'readonly', 'placeholder' => 'CPF / CNPJ'])}}
                            @else
                            {{Form::text('cpf_cnpj',$data->cpf_cnpj,['class' => 'form-control create', 'readonly','placeholder' => 'CPF / CNPJ'])}}
                            @endif
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('data_nascimento', 'Data de Nascimento')}}
                            <br>
                            {{Form::date('data_nascimento',(isset($data->data_nascimento)? \Carbon\Carbon::parse($data->data_nascimento) : null ),['class' => 'form-control','readonly'])}}
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-12">
                            {{Form::label('nome_razaosocial', 'Nome / Razão Social')}}
                            {{Form::text('nome_razaosocial',$data->nome_razaosocial,['class' => 'form-control','readonly', 'placeholder' => 'Nome / Razão Social'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('cep', 'CEP')}}
                            {{Form::text('cep',$data->cep,['class' => 'form-control buscarcep','readonly', 'placeholder' => '00.000-000'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('logradouro', 'Logradouro')}}
                            {{Form::text('logradouro',$data->logradouro,['class' => 'form-control','readonly'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('localidade', 'Cidade')}}
                            {{Form::text('localidade',$data->localidade,['class' => 'form-control','readonly'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('uf', 'UF')}}
                            {{Form::text('uf',$data->uf,['class' => 'form-control','readonly'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('bairro', 'Bairro')}}
                            {{Form::text('bairro',$data->bairro,['class' => 'form-control','readonly'])}}
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('numero', 'Número')}}
                            {{Form::text('numero',$data->numero,['class' => 'form-control','readonly'])}}
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('complemento', 'Complemento')}}
                            {{Form::text('complemento',$data->complemento,['class' => 'form-control','readonly'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('email', 'E-mail')}}
                            {{Form::text('email',$data->email,['class' => 'form-control','readonly'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('telefone', 'Telefone Principal')}}
                            {{Form::text('telefone',$data->telefone,['class' => 'form-control','readonly'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('celular', 'Celular')}}
                            {{Form::text('celular',$data->celular,['class' => 'form-control','readonly'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('recado', 'Recado')}}
                            {{Form::text('recado',$data->recado,['class' => 'form-control','readonly'])}}
                        </div>

                        <div class="form-group col-12 col-md-12 col-lg-6">
                            {{Form::label('observacoes', 'Observações')}}
                            {{Form::text('observacoes',$data->observacoes,['class' => 'form-control','readonly'])}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-md-12 col-lg-6 d-flex justify-content-start">
                            <a href="{{ route($params['main_route'].'.index') }}" class="btn btn-primary btn-sm"><span class="fas fa-arrow-left"></span>  Voltar</a>
                        </div>
                        <div class="form-group col-12 col-md-12 col-lg-6 d-flex justify-content-end">
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



@section('js')

@stop
