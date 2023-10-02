@extends('adminlte::page')
@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    @include('admin.cliente.modalcliente')
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
                    @endif
                    <h5>Dados do Cliente</h5>
                    <div class="row">

                        {{--
                            id, tipo, cpf_cnpj, data_nascimento, nome_razaosocial,
                            cep, logradouro, complemento, bairro, localidade, uf,
                            email, telefone, celular, recado, observacoes
                            --}}

                        <div class="form-group col-12 col-md-4 col-lg-4">
                            {{Form::label('cpf_cnpj', 'CPF / CNPJ')}}
                            {{Form::text('cpf_cnpj',null,['id' =>'cpf_cnpj',  'class' => 'form-control cpf_cnpj create',  'readonly', 'placeholder' => 'CPF / CNPJ'])}}
                        </div>
                        <div class="form-group col-12 col-md-4 col-lg-4">
                            {{Form::label('nome_razaosocial', 'Nome / Razão Social')}}
                            {{Form::text('nome_razaosocial',null,['class' => 'form-control', 'placeholder' => 'Nome / Razão Social', 'readonly','data-cliente'=>'nome_razaosocial'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('data_nascimento', 'Data de Nascimento')}}
                            <br>
                            {{Form::date('data_nascimento',(isset($data->data_nascimento)? \Carbon\Carbon::parse($data->data_nascimento) : null ),['class' => 'form-control', 'readonly','data-cliente'=>'data_nascimento'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('cep', 'CEP')}}
                            {{Form::text('cep',null,['class' => 'form-control buscarcep', 'placeholder' => '00.000-000', 'readonly','data-cliente'=>'cep'])}}
                        </div>

                        <div class="form-group col-12 col-md-8 col-lg-4">
                            {{Form::label('logradouro', 'Logradouro')}}
                            {{Form::text('logradouro',null,['class' => 'form-control', 'readonly','data-cliente'=>'logradouro'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('localidade', 'Cidade')}}
                            {{Form::text('localidade',null,['class' => 'form-control', 'readonly','data-cliente'=>'localidade'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('uf', 'UF')}}
                            {{Form::text('uf',null,['class' => 'form-control', 'readonly','data-cliente'=>'uf'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('bairro', 'Bairro')}}
                            {{Form::text('bairro',null,['class' => 'form-control', 'readonly','data-cliente'=>'bairro'])}}
                        </div>
                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('numero', 'Número')}}
                            {{Form::text('numero',null,['class' => 'form-control', 'readonly','data-cliente'=>'numero'])}}
                        </div>
                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('complemento', 'Complemento')}}
                            {{Form::text('complemento',null,['class' => 'form-control', 'readonly','data-cliente'=>'complemento'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('email', 'E-mail')}}
                            {{Form::text('email',null,['class' => 'form-control', 'readonly','data-cliente'=>'email'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('telefone', 'Telefone Principal')}}
                            {{Form::text('telefone',null,['class' => 'form-control', 'readonly','data-cliente'=>'telefone'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('celular', 'Celular')}}
                            {{Form::text('celular',null,['class' => 'form-control', 'readonly','data-cliente'=>'celular'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('recado', 'Recado')}}
                            {{Form::text('recado',null,['class' => 'form-control', 'readonly','data-cliente'=>'recado'])}}
                        </div>

                        <div class="form-group col-6 col-md-4 col-lg-2">
                            {{Form::label('observacoes', 'Observações')}}
                            {{Form::text('observacoes',null,['class' => 'form-control', 'readonly','data-cliente'=>'observacoes'])}}
                        </div>



                    </div>
                    <hr>
                    <h5>Itens do Pedido</h5>


                    {{-- id, orcamento_id, produto_id, quantidade, valor --}}
                    <div class="row" id="">
                        @foreach ($data->itens as $item)
                            @php
                                $i=0;
                            @endphp
                            <div class="input-group items">
                                    <div  class="col-6 col-md-4 col-lg-8  pt-2">
                                        {{Form::select('produto_id',
                                                $preload['produtos'],
                                                $item->produto_id,
                                                ['id'=>'produto_id','class' =>'form-control', 'disabled','placeholder' => 'Selecione o Produto','data-name'=>'produto_id'])}}

                                    </div>
                                    <div  class="col-3 col-md-4 col-lg-2 pt-2">
                                        {{Form::text('quantidade',str_replace('.',',',$item->quantidade),['class' => 'form-control float qtd','readonly', 'data-name' => 'quantidade','placeholder' => 'Qtdade'])}}
                                    </div>
                                    <div  class="col-3 col-md-4 col-lg-2 pt-2">
                                        {{Form::text('valor_unitario',str_replace('.',',',$item->valor),['class' => 'form-control money vlr_unitario', 'readonly', 'data-name' => 'valor_unitario', 'placeholder' => 'Valor R$'])}}
                                    </div>

                            </div>

                            @php
                                $i++;
                            @endphp
                        @endforeach

                    </div>
                    <hr>
                    <h5>Totais</h5>
                    <div class="row">
                        <div class="form-group col-6 col-md-3 col-lg-2">
                            {{Form::label('valor', 'Sub Total R$')}}
                            {{Form::text('valor',null,['class' => 'form-control money sub_total','readonly', 'placeholder' => '0,00'])}}
                        </div>
                        <div class="form-group col-6 col-md-3 col-lg-2">
                            {{Form::label('acrescimo', 'Acréscimo')}}
                            {{Form::text('acrescimo',null,['class' => 'form-control money acrescimo','readonly', 'placeholder' => '0,00'])}}
                        </div>
                        <div class="form-group col-6 col-md-3 col-lg-2">
                            {{Form::label('desconto', 'Desconto')}}
                            {{Form::text('desconto',null,['class' => 'form-control money desconto','readonly', 'placeholder' => '0,00'])}}
                        </div>
                        <div class="form-group col-6 col-md-3 col-lg-2">
                            {{Form::label('valor_total', 'Valor Total R$')}}
                            {{Form::text('valor_total',null,['class' => 'form-control money valor_total','readonly', 'placeholder' => '0,00'])}}
                        </div>

                        <div class="form-group col-6 col-md-3 col-lg-2">
                            {{Form::label('forma_pagamento', 'F. Pagamento')}}
                            {{Form::select('forma_pagamento',
                                            $preload['formas_pagamento'],
                                            ((isset($data['forma_pagamento'])) ? $data['forma_pagamento'] : null),
                                            ['id'=>'forma_pagamento','class' =>'form-control','disabled','placeholder' => 'Forma de Pagamento'])}}

                        </div>
                        <div class="form-group col-6 col-md-3 col-lg-2">
                            {{Form::label('data_entrega', 'Prev. Entrega')}}
                            {{Form::date('data_entrega',(isset($data->data_entrega)? \Carbon\Carbon::parse($data->data_entrega) : null ),['class' => 'form-control','readonly'])}}

                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 alert alert-warning d-flex justify-content-between" role="alert">
                            <span >Para alterar informações deste Orçamento</span>
                            <a href="{{ route('admin.orcamento.edit', $data->id) }}" class="btn btn-primary btn-xs align-self-end"> Clique Aqui</a>
                        </div>
                    </div>
                    <hr>
                    <h5>Histórico do Status</h5>

                    {{-- id, orcamento_id, inicio, fim, status, cadastrado_por --}}
                    <div class="row" id="">
                        @php
                            $i=0;
                        @endphp
                        @foreach ($data->status as $status_item)
                            @if($i == 0)
                                <div class="input-group items">
                                    <div  class="col-3 pt-2 bold">
                                        {{Form::label('inicio', 'Início')}}
                                    </div>
                                    <div  class="col-3 pt-2 bold">
                                        {{Form::label('fim', 'Fim')}}
                                    </div>
                                    <div  class="col-3 pt-2 bold">
                                        {{Form::label('status', 'Status')}}
                                    </div>
                                    <div  class="col-3 pt-2 bold">
                                        {{Form::label('cadastrado_por', 'Cadastrado por')}}
                                    </div>
                                </div>
                            @endif
                            <div class="input-group items {{ (($i % 2 ) ?:  'bg-light') }}">
                                <div  class="col-3 pt-2">
                                    {{ (isset($status_item->inicio) ? \Carbon\Carbon::parse($status_item->inicio) : '-') }}
                                </div>
                                <div  class="col-3 pt-2">
                                    {{ (isset($status_item->fim) ? \Carbon\Carbon::parse($status_item->fim) : 'Atual') }}
                                </div>
                                <div  class="col-3 pt-2">
                                    {{ $status_item->status }}
                                </div>
                                <div  class="col-3 pt-2">
                                    {{ $status_item->cadastrado_por }}
                                </div>
                            </div>
                            @php
                                $i++;
                            @endphp
                        @endforeach

                    </div>
                    <div class="row">
                        <div class="form-group col-12 pt-2">
                            {{Form::label('status', 'Alterar')}}
                            
                            {{Form::hidden('orcamento_id',$data['id']) }}
                            {{Form::select('status',
                                            $preload['status'],
                                            ((isset($data['status'])) ? $data['status'] : null),
                                            ['id'=>'status','class' =>'form-control','placeholder' => 'Status'])}}
                        </div>
                    </div>
                    <div class="form-group pt-3">
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
    <script src="{{ asset('plugin/jquery.mask.min.js')}}" ></script>
    <script src="{{ asset('js/scripts.js')}}" ></script>
@stop

