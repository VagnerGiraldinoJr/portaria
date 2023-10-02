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
                
                <div class="card-body p-0 ">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0 ">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(isset($caixa) && $caixa)
                        <div class="alert alert-success d-flex align-items-center justify-content-between m-2" role="alert">
                           
                            <span>Caixa Aberto <strong>Saldo Atual: R$ {{ $saldo}}</strong></span>
                            <span>
                                {{ Form::open(['route' => [$params['main_route'].'.fechar'],'method' =>'put']) }}
                                {{Form::submit('Fechar Caixa',['class'=>'btn btn-primary btn-md'])}}
                                {{ Form::close() }}
                            </span>
                        </div>
                        <div class="alert alert-light d-flex align-items-center justify-content-between m-2" role="alert">
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('admin.conta_corrente.saidas') }}" class="btn btn-danger btn-md text-decoration-none "><i class="fas fa-sign-out-alt "></i> Lançar Saidas</a>
                            </div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.conta_corrente.entradas') }}" class="btn btn-primary btn-md text-decoration-none "><i class="fas fa-sign-in-alt "></i> Lançar Entradas</a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger  d-flex align-items-center justify-content-between m-2" role="alert">
                            <span>Caixa Fechado</span>
                            <span>
                                {{ Form::open(['route' => [$params['main_route'].'.abrir'],'method' =>'POST']) }}
                                {{Form::submit('Abrir Caixa',['class'=>'btn btn-primary btn-md'])}}
                                {{ Form::close() }}
                            </span> 
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <p class="w-100 p-2 text-center">Últimos Caixas Abertos / Fechados </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                    
                        @if($data != null && $data->count())
                            <table class="table table-hover">
                                <thead>
                                    {{-- id, data_abertura, data_fechamento, aberto_por, fechado_por, created_at, updated_at --}}
                                <tr>
                                    <th>Data Abertura</th>
                                    <th>Aberto Por</th>
                                    <th>Valor</th>
                                    <th>Data Fechamento</th>
                                    <th>Fechado Por</th>
                                    <th>Valor</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item['data_abertura']}}</td>
                                        <td>{{ $item['aberto_por']}}</td>
                                        <td>R$ {{ $item['valor_abertura']}}</td>
                                        <td>{{ $item['data_fechamento'] }}</td>
                                        <td>{{ $item['fechado_por'] }}</td>
                                        <td>R$ {{ $item['valor_fechamento']}}</td>
                                    </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        
                        @else
                            <div class="alert alert-success m-2" role="alert">
                                Nenhuma informação cadastrada.
                            </div>
                        @endif
                        </div>
                    </div>

                    
                </div>
             
                
              </div>


           </div>
       </div>
    </section>
@stop

@section('css')
    
    

@stop

@section('js')
 
@stop
