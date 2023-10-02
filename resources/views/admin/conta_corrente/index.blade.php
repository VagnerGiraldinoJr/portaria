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
                    <div class="row p-2">
                        <div class="col-12 ">
                            <h3 class="card-title font-weight-bold">{{$params['subtitulo']}}</h3>
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    {{ Form::open(['route' => $params['main_route'].'.index' ,'method' =>'post','class' => 'form']) }}
                    <div class="row">
                        <div class="col-4 d-flex align-items-center">
                            {{Form::label('data_inicio', 'Data Início',['class' => 'text-nowrap w-50'])}}
                            {{Form::date('data_inicio',(isset($searchFields["data_inicio"])? \Carbon\Carbon::parse($searchFields["data_inicio"]) : null ),['class' => 'form-control w-50','data-cliente'=>'data_inicio'])}}
                        </div>
                        <div class="col-4 d-flex align-items-center">
                            {{Form::label('data_fim', 'Até',['class' => 'text-nowrap w-50'])}}
                            {{Form::date('data_fim',(isset($searchFields["data_fim"])? \Carbon\Carbon::parse($searchFields["data_fim"]) : null ),['class' => 'form-control w-50','data-cliente'=>'data_fim'])}}
                        </div>
                        <div class="col-4 d-flex align-items-center">
                            {{ Form::submit('Buscar',['class'=>'btn btn-primary btn-xl'])}}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    @if(isset($data) && count($data))
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Data</th>
                                    <th>Descrição</th>
                                    <th class="text-right">Valor</th>
                                    <th class="text-right">Saldo</th>
                                    <th>Operação</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $saldo = (float) "0.00";
                                    @endphp
                                    @foreach ($data as $item)
                                    @switch($item['operacao'])
                                        @case(0)
                                            @php
                                                $saldo-= (float) ($item['extornado'] != 0) ? 0 : $item['valor'] ;
                                                //casting
                                                $class = "text-danger";  
                                                $sinal = "-";
                                            @endphp  
                                        @break
                                        @case(1)
                                            @php
                                                $saldo+= (float) ($item['extornado'] != 0) ? 0 : $item['valor'] ;
                                                //casting
                                                $class = "text-primary";  
                                                $sinal = "";
                                            @endphp  
                                        @break
                                        @case(88)
                                            @php
                                                $saldo= (float) ($item['extornado'] != 0) ? 0 :  $item['valor'] ;
                                                //casting
                                                $class = " text-dark font-weight-bold";  
                                                $sinal = "";
                                            @endphp
                                        @break
                                        @case(99)
                                            @php
                                                $saldo= (float) ($item['extornado'] != 0) ? 0 :  $item['valor'] ;
                                                //casting
                                                $class = "text-dark font-weight-bold";  
                                                $sinal = "";
                                            @endphp                                            
                                        @break
                                        @default

                                        @break
                                    @endswitch
                                        <tr class="{{ $class }} {{ ($item['extornado'] == 0)?: "bg-red" }}" >
                                            <td>{{ $item['id']}}</td>
                                            <td>{{ Carbon\Carbon::parse($item['data_hora'])->format('d/m/Y H:i:s')  }}</td>
                                            <td>{{ $item['desc_operacao'] }} </td>
                                            <td class="text-right">{{ $sinal }} R$ {{ number_format($item['valor'],2,',','.')   }}</td>
                                            <td class="text-right  font-weight-bold {{ ($item['extornado'] == 0)?($saldo >= 0) ? "text-primary" : "text-danger" : "text-white" }}" >R$ {{  number_format($saldo,2,',','.')  }}</td>
                                            <td >
                                                @if($item['extornado'] == 0)
                                                    @if($item['operacao']  != 88 &&  $item['operacao']  != 99)
                                                    <a href="{{ route($params['main_route'].'.show', $item->id) }}" class="btn btn-danger btn-xs"> Ver / Extornar</a>
                                                    @endif
                                                @else
                                                    <span class="text-white">
                                                        EXTORNADO
                                                    </span> 
                                                @endif                                                
                                            </td>
                                            
                                        </tr>
                                        
                                    @endforeach



                                </tbody>
                                
                        </table>
                        <div class="card-footer">
                            {{ $data->links() }}
                        </div>

                    @else
                        <div class="alert alert-success m-2" role="alert">
                            Nenhuma informação cadastrada.
                        </div>
                    @endif

                </div>
            
               

              </div>


           </div>
       </div>
    </section>
    
@stop


