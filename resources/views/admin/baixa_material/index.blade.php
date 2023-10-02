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
                        <div class="col-4">
                            {{ Form::text('titulo',(isset($searchFields['titulo'])? $searchFields['titulo'] : ''),['class' => 'form-control', 'placeholder' => 'Produto'])}}
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
                                <th>Produto</th>
                                <th>Qtdade</th>
                                <th>Cadastrado Por</th>
                                <th>Data</th>
                                <th>Operação</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item['id']}}</td>
                                    <td>{{ $item['desc_produto']}}</td>
                                    <td>{{ $item['quantidade']}}</td>
                                    <td>{{ $item['cadastrado_por'] }}</td>
                                    <td>{{ $item['data_cadastro'] }}</td>
                                    <td>
                                        <a href="{{ route($params['main_route'].'.show', $item['id']) }}" class="btn btn-danger btn-xs"><span class="fas fa-trash"></span> Ver / Deletar</a>
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
                <!-- /.card-body -->
                <div class="card-footer">
                    {{ $data->links() }}
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
