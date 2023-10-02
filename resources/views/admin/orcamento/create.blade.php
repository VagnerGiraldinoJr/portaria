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
                    @else
                        {{ Form::open(['id' => 'form-pedido', 'route' => $params['main_route'].'.store','method' =>'post']) }}
                    @endif
                    <h5>Dados do Cliente</h5>
                    <div class="row">

                        {{--
                            id, tipo, cpf_cnpj, data_nascimento, nome_razaosocial,
                            cep, logradouro, complemento, bairro, localidade, uf,
                            email, telefone, celular, recado, observacoes
                            --}}

                        <div class="form-group col-12 col-md-3 col-lg-3">
                            {{Form::label('cpf_cnpj', 'CPF / CNPJ')}}
                            {{Form::hidden('cliente_id',null)}}
                            @if(! isset($data))
                            {{Form::text('cpf_cnpj',null,['id' =>'cpf_cnpj',  'class' => 'form-control cpf_cnpj create orcamento', 'placeholder' => 'CPF / CNPJ'])}}
                            @else
                            {{Form::text('cpf_cnpj',null,['id' =>'cpf_cnpj',  'class' => 'form-control cpf_cnpj create orcamento', 'readonly', 'placeholder' => 'CPF / CNPJ'])}}
                            @endif
                        </div>
                        <div class="form-group col-6 col-md-6 col-lg-6 d-flex justify-content-start">
                            @if(! isset($data))
                            <div class="d-flex align-self-end">
                                <a id="btn-buscar"  class="btn btn-light btn-md ml-2"><span class="fas fa-search"></span> Buscar</a>
                            </div>
                            <div class="row d-flex align-self-end p-2">
                                <strong><span class="text-danger" id="response" ></span></strong>
                            </div>
                            @endif
                        </div>
                        @if(! isset($data))
                        <div class="form-group col-6 col-md-3 col-lg-3 d-flex justify-content-end">
                            <button id="btn-editar-pedido" type="button" class="btn btn-md btn-primary align-self-end" data-toggle="modal" data-target="#modalClientes" ><span class="fas fa-edit"></span> Cadastrar Cliente</button>
                        </div>
                        @endif

                        <div class="form-group col-12 col-md-6 col-lg-6">
                            {{Form::label('nome_razaosocial', 'Nome / Razão Social')}}
                            {{Form::text('nome_razaosocial',null,['class' => 'form-control', 'placeholder' => 'Nome / Razão Social', 'readonly','data-cliente'=>'nome_razaosocial'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-6">
                            {{Form::label('data_nascimento', 'Data de Nascimento')}}
                            <br>
                            {{Form::date('data_nascimento',(isset($data->data_nascimento) ? \Carbon\Carbon::parse($data->data_nascimento) : null ),['class' => 'form-control', 'readonly','data-cliente'=>'data_nascimento'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('cep', 'CEP')}}
                            {{Form::text('cep',null,['class' => 'form-control buscarcep', 'placeholder' => '00.000-000', 'readonly','data-cliente'=>'cep'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('logradouro', 'Logradouro')}}
                            {{Form::text('logradouro',null,['class' => 'form-control', 'readonly','data-cliente'=>'logradouro'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('localidade', 'Cidade')}}
                            {{Form::text('localidade',null,['class' => 'form-control', 'readonly','data-cliente'=>'localidade'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('uf', 'UF')}}
                            {{Form::text('uf',null,['class' => 'form-control', 'readonly','data-cliente'=>'uf'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('bairro', 'Bairro')}}
                            {{Form::text('bairro',null,['class' => 'form-control', 'readonly','data-cliente'=>'bairro'])}}
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('numero', 'Número')}}
                            {{Form::text('numero',null,['class' => 'form-control', 'readonly','data-cliente'=>'numero'])}}
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('complemento', 'Complemento')}}
                            {{Form::text('complemento',null,['class' => 'form-control', 'readonly','data-cliente'=>'complemento'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('email', 'E-mail')}}
                            {{Form::text('email',null,['class' => 'form-control', 'readonly','data-cliente'=>'email'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('telefone', 'Telefone Principal')}}
                            {{Form::text('telefone',null,['class' => 'form-control', 'readonly','data-cliente'=>'telefone'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('celular', 'Celular')}}
                            {{Form::text('celular',null,['class' => 'form-control', 'readonly','data-cliente'=>'celular'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('recado', 'Recado')}}
                            {{Form::text('recado',null,['class' => 'form-control', 'readonly','data-cliente'=>'recado'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('observacoes', 'Observações')}}
                            {{Form::text('observacoes',null,['class' => 'form-control', 'readonly','data-cliente'=>'observacoes'])}}
                        </div>



                    </div>
                    <hr>
                    <h5>Itens do Pedido</h5>
                    {{-- id, cliente_id, valor, acrescimo, desconto, valor_total, forma_pagamento, situacao, data_entrega, data_hora, cadastrado_por --}}
                    @if( isset($data) && isset($data->itens))

                        {{-- id, orcamento_id, produto_id, quantidade, valor --}}
                        <div class="row" id="itenspedido">
                            @foreach ($data->itens as $item)
                                @php
                                    $i=0;
                                @endphp
                                <div class="input-group items">
                                        <div  class="col-12 col-lg-7  pt-2">
                                           
                                            {{Form::select('produto_id',
                                                    $preload['produtos'],
                                                    $item->produto_id,
                                                    ['id'=>'produto_id','class' =>'form-control','placeholder' => 'Selecione o Produto','data-name'=>'produto_id'])}}

                                        </div>
                                        <div  class="col-4 col-lg-2 pt-2">
                                            {{Form::text('quantidade',str_replace('.',',',$item->quantidade),['class' => 'form-control float qtd', 'data-name' => 'quantidade','placeholder' => 'Qtdade'])}}
                                        </div>
                                        <div  class="col-5 col-lg-2 pt-2">
                                            {{Form::text('valor_unitario',str_replace('.',',',$item->valor),['class' => 'form-control money vlr_unitario',  'data-name' => 'valor_unitario', 'placeholder' => 'Valor R$'])}}
                                        </div>
                                        <div class="col-3 col-lg-1 pt-2">
                                            <button type="button" class="btn btn-danger w-100 remove-btn"> - </button>
                                        </div>
                                </div>

                                @php
                                    $i++;
                                @endphp
                            @endforeach
                            <div class="input-group col-12 pt-2">
                                <button type="button" class="btn btn-primary repeater-add-btn"> + Item</button>
                            </div>
                        </div>

                    @else
                        @if(old('produto_id') == null)
                            {{-- id, orcamento_id, produto_id, quantidade, valor --}}
                            <div class="row" id="itenspedido">
                                <div class="input-group items">
                                    <div  class="col-12 col-lg-7  pt-2">
                                    {{Form::select('produto_id',
                                                $preload['produtos'],
                                                null,
                                                ['id'=>'produto_id','class' =>'form-control','placeholder' => 'Selecione o Produto','data-name'=>'produto_id'])}}

                                    </div>
                                    <div  class="col-4 col-lg-2 pt-2">
                                        {{Form::text('quantidade',null,['class' => 'form-control float qtd', 'data-name' => 'quantidade','placeholder' => 'Qtdade'])}}
                                    </div>
                                    <div  class="col-5 col-lg-2 pt-2">
                                        {{Form::text('valor_unitario',null,['class' => 'form-control money vlr_unitario',  'data-name' => 'valor_unitario', 'placeholder' => 'Valor R$'])}}
                                    </div>
                                    <div class="col-3 col-lg-1 pt-2">
                                        <button type="button" class="btn btn-danger w-100 remove-btn"> - </button>
                                    </div>
                                </div>
                                <div class="input-group col-12 pt-2">
                                    <button type="button" class="btn btn-primary repeater-add-btn"> + Item</button>
                                </div>
                            </div>
                        @else

                            {{-- id, orcamento_id, produto_id, quantidade, valor --}}
                            <div class="row" id="itenspedido">
                                @php
                                     $produto_id = old('produto_id');
                                @endphp
                                @for( $i =0; $i < count($produto_id); $i++)
                                    <div class="input-group items">
                                    <div  class="col-12 col-lg-7  pt-2">
                                        {{Form::select('produto_id['.$i.']',$preload['produtos'],
                                                    old('produto_id.'.$i),
                                                    ['id'=>'produto_id','class' =>'form-control', 'placeholder'=>'Selecione o Produto','data-name'=>'produto_id'])}}

                                        </div>
                                        <div  class="col-4 col-lg-2 pt-2">
                                            {{Form::text('quantidade['.$i.']', old('quantidade.'.$i),['class' => 'form-control float qtd', 'data-name' => 'quantidade','placeholder' => 'Qtdade'])}}
                                        </div>
                                        <div  class="col-5 col-lg-2 pt-2">
                                            {{Form::text('valor_unitario['.$i.']',old('valor_unitario.'.$i),['class' => 'form-control money vlr_unitario',  'data-name' => 'valor_unitario','placeholder' => 'Valor R$'])}}
                                        </div>
                                        <div class="col-3 col-lg-1 pt-2">
                                            <button type="button" class="btn btn-danger w-100 remove-btn"> - </button>
                                        </div>
                                    </div>
                                @endfor
                                <div class="input-group col-12 pt-2">
                                    <button type="button" class="btn btn-primary repeater-add-btn"> + Item</button>
                                </div>
                            </div>
                        @endif
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
                            {{Form::text('acrescimo',null,['class' => 'form-control acrescimo', 'placeholder' => '0,00'])}}
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('desconto', 'Desconto')}}
                            {{Form::text('desconto',null,['class' => 'form-control desconto', 'placeholder' => '0,00'])}}
                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-3">
                            {{Form::label('valor_total', 'Valor Total R$')}}
                            {{Form::text('valor_total',null,['class' => 'form-control valor_total','readonly', 'placeholder' => '0,00'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-6">
                            {{Form::label('forma_pagamento', 'Forma de Pagamento')}}
                            {{Form::select('forma_pagamento',
                                            $preload['formas_pagamento'],
                                            ((isset($data['forma_pagamento'])) ? $data['forma_pagamento'] : null),
                                            ['id'=>'forma_pagamento','class' =>'form-control','placeholder' => 'Forma de Pagamento'])}}

                        </div>
                        <div class="form-group col-12 col-md-6 col-lg-6">
                            {{Form::label('data_entrega', 'Previsão de Entrega')}}
                            {{Form::date('data_entrega',(isset($data->data_entrega)? \Carbon\Carbon::parse($data->data_entrega) : null ),['class' => 'form-control'])}}

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
    <script src="{{ asset('plugin/repeater.js')}}" ></script>
    <script src="{{ asset('js/ajax.js')}}" ></script>
    <script src="{{ asset('js/pedido.js')}}" ></script>
    <script src="{{ asset('js/clientepedido.js')}}" ></script>
    <script src="{{ asset('js/scripts.js')}}" ></script>
@stop

