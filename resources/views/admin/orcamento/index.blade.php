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
                        <div class="col-6">
                            <h3 class="card-title font-weight-bold">{{$params['subtitulo']}}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route($params['main_route'].'.create') }}" class="btn btn-primary btn-xs"><span class="fas fa-plus"></span> Novo Cadastro</a>
                        </div>
                    </div>
                </div>

                <div class="card-header">
                    {{ Form::open(['route' => $params['main_route'].'.index' ,'method' =>'post','class' => 'form']) }}
                    <div class="row">
                        <div class="col-2">
                            {{ Form::text('numero',(isset($searchFields['numero'])? $searchFields['numero'] : ''),['class' => 'form-control', 'placeholder' => 'Número','autofocus'=>'autofocus'])}}
                        </div>
                        <div class="col-2">
                            {{ Form::text('cpf_cnpj',(isset($searchFields['cpf_cnpj'])? $searchFields['cpf_cnpj'] : ''),['class' => 'form-control', 'placeholder' => 'CPF / CNPJ'])}}
                        </div>
                        <div class="col-4">
                            {{ Form::text('nome_razaosocial',(isset($searchFields['nome_razaosocial'])? $searchFields['nome_razaosocial'] : ''),['class' => 'form-control', 'placeholder' => 'Nome / Razão Social'])}}
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
                                    <th>CPF/CNPJ</th>
                                    <th>Cliente</th>
                                    <th class="text-right">Valor Total</th>
                                    <th>Operação</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $item)
                                    <tr>
                                        <td>{{ $item['id']}}</td>
                                        <td>{{ $item['data_hora'] }}</td>
                                        <td>{{ $item['cpf_cnpj']}}</td>
                                        <td>{{ $item['nome_razaosocial'] }}</td>
                                        <td class="text-right">R$ {{ $item['valor_total'] }}</td>

                                        <td>
                                        @if($item['status'] == 1 )
                                            <a href="{{ route($params['main_route'].'.edit', $item['id']) }}" class="btn btn-info btn-xs"><span class="fas fa-edit"></span> Editar</a>
                                        @else
                                            <a href="{{ route('admin.pedido.index') }}" class="btn btn-danger btn-xs"><span class="fas fa-edit"></span>Pedido</a>
                                        @endif
                                            <a href="{{ route('admin.print.orcamento', $item['id']) }}" target="_blank" class="btn btn-dark btn-xs"><span class="fas fa-print"></span> Ver / Imprimir</a>
                                        </td>
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
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $data->links() }}
                </div>

              </div>


           </div>
       </div>
    </section>
    @include('admin.orcamento.modalorcamento')
@stop



@section('js')
    <script src="{{ asset('js/ajax.js')}}" ></script>
@stop
