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
                        {{ Form::open(['id' => 'form-cliente', 'route' => $params['main_route'].'.store','method' =>'post']) }}
                    @endif

                    <div class="row">



                        <div class="form-group col-12 col-md-3 col-lg-3">
                            {{Form::label('cpf_cnpj', 'CPF / CNPJ')}}
                            {{Form::text('cpf_cnpj',null,['id' =>'cpf_cnpj',  'class' => 'form-control cpf_cnpj ', 'placeholder' => 'CPF / CNPJ'])}}
                        </div>

                        <div class="form-group col-12 col-md-6 col-lg-6">
                            {{Form::label('nome_razaosocial', 'Nome / Razão Social')}}
                            {{Form::text('nome_razaosocial',null,['class' => 'form-control', 'placeholder' => 'Nome / Razão Social', 'data-cliente'=>'nome_razaosocial'])}}
                        </div>
                        <div class="form-group col-12 col-md-3 col-lg-3">
                            {{Form::label('data_entrada', 'Data da Compra')}}
                            {{Form::date('data_entrada',(isset($data->data_entrada)? \Carbon\Carbon::parse($data->data_entrada) : null ),['class' => 'form-control'])}}

                        </div>
                    </div>
                    <hr>
                    <h5>Itens da Compra</h5>
                    @if( isset($data) && isset($data->itens))

                        {{-- id, compra_id, produto_id, quantidade, valor --}}
                        <div class="row" id="itenscompra">
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
                            <div class="input-group">
                                <div  class="col-12 col-lg-7 pt-2"><label>Produto</label></div>
                                <div  class="col-4 col-lg-2 pt-2"><label>Quantidade</label></div>
                                <div  class="col-5 col-lg-2 pt-2"><label>Valor</label></div>
                                <div class="col-3 col-lg-1 pt-2"><label></label></div>
                            </div>
                        </div>

                    @else
                        @if(old('produto_id') == null)
                            {{-- id, compra_id, produto_id, quantidade, valor --}}
                            <div class="row" id="itenscompra">

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
                                <div class="input-group">
                                    <div  class="col-12 col-lg-7 pt-2"><label>Produto</label></div>
                                    <div  class="col-4 col-lg-2 pt-2"><label>Quantidade</label></div>
                                    <div  class="col-5 col-lg-2 pt-2"><label>Valor</label></div>
                                    <div class="col-3 col-lg-1 pt-2"><label></label></div>
                                </div>

                            </div>
                        @else

                            {{-- id, compra_id, produto_id, quantidade, valor --}}
                            <div class="row" id="itenscompra">
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
                                <div class="input-group">
                                    <div  class="col-12 col-lg-7 pt-2"><label>Produto</label></div>
                                    <div  class="col-4 col-lg-2 pt-2"><label>Quantidade</label></div>
                                    <div  class="col-5 col-lg-2 pt-2"><label>Valor</label></div>
                                    <div class="col-3 col-lg-1 pt-2"><label></label></div>
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
    <script src="{{ asset('js/compra.js')}}" ></script>
    <script src="{{ asset('js/ajax.js')}}" ></script>
    <script src="{{ asset('js/scripts.js')}}" ></script>
@stop
