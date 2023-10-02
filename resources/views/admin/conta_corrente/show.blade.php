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
                    {{ Form::open(['route' => [$params['main_route'].'.extornar',$data->id],'method' =>'POST']) }}

                    <div class="row">
                        {{--
                            valor, operacao, forma_pagamento, data_hora, cadastrado_por, referencia, pedido_id
                            , extornado
                            , motivo_extorno, fechado, fechado_por
                            --}}
                        <div class="form-group col-6 col-md-4 col-lg-3">
                            {{Form::label('data_hora', 'Data')}}
                            {{Form::date('data_hora',(isset($data->data_hora)? \Carbon\Carbon::parse($data->data_hora) : null ),['class' => 'form-control','readonly'])}}
                        </div>
                        <div class="form-group col-6 col-md-4 col-lg-3">
                            {{Form::label('valor', 'Valor')}}
                            {{Form::text('valor',$data->valor,['class' => 'form-control','readonly', 'placeholder' => 'Valor'])}}
                        </div>
                        <div class="form-group col-6 col-md-4 col-lg-3">
                            {{Form::label('operacao', 'Operação')}}
                            {{Form::select('operacao',
                                            $preload['operacao'],
                                            ((isset($data['operacao'])) ? $data['operacao'] : null),
                                            ['id'=>'operacao','class' =>'form-control','readonly','placeholder' => 'Operação'])}}
                        </div>


                        <div class="form-group col-6 col-md-4 col-lg-3">
                        {{Form::label('forma_pagamento', 'Forma de Pagamento')}}
                            {{Form::select('forma_pagamento',
                                            $preload['formas_pagamento'],
                                            ((isset($data['forma_pagamento'])) ? $data['forma_pagamento'] : null),
                                            ['id'=>'forma_pagamento','class' =>'form-control','readonly','placeholder' => 'Forma de Pagamento'])}}
                        </div>
                       

                        <div class="form-group col-6 col-md-4 col-lg-3">
                            {{Form::label('referencia', 'Referencia')}}
                            {{Form::text('referencia',$data->referencia,['class' => 'form-control','readonly'])}}
                        </div>
                        {{-- , extornado
                            , motivo_extorno,
                             --}}
                        <div class="form-group col-6 col-md-4 col-lg-3">
                            {{Form::label('extornado', 'Extornado')}}
                            {{Form::text('extornado',$data->desc_extornado,['class' => 'form-control','readonly'])}}
                        </div>
                        
                        @if ($data->extornado == 1)
                        <div class="form-group col-6 col-md-4 col-lg-3">
                            {{Form::label('motivo_extorno', 'Motivo extorno')}}
                            {{Form::text('motivo_extorno',$data->motivo_extorno,['class' => 'form-control','readonly'])}}
                        </div>
                        @else

                        <div class="form-group col-12">
                            {{Form::label('motivo_extorno', 'Motivo extorno')}}
                            {{Form::text('motivo_extorno',$data->motivo_extorno,['class' => 'form-control'])}}
                        </div>
                            
                        @endif


                       
                    </div>
                    <div class="row">
                        <div class="form-group col-6  d-flex justify-content-start">
                            <a href="{{ route($params['main_route'].'.index') }}" class="btn btn-primary btn-sm"><span class="fas fa-arrow-left"></span>  Voltar</a>
                        </div>
                        @if($data['operacao']  != 88 &&  $data['operacao']  != 99 && $data->extornado == 0)
                        @role('admin')  
                        <div class="form-group col-6  d-flex justify-content-end">
                            
                            {{Form::submit('Extornar',['class'=>'btn btn-danger btn-sm'])}}
                            
                            {{Form::hidden('extornado',1)}}
                            
                        </div>
                        @endrole
                           
                        @endif
                    </div>
                    

                </div>
                <!-- /.card-body -->
                 {{ Form::close() }}
              </div>


           </div>
       </div>
      
    </section>
@stop



@section('js')

@stop
