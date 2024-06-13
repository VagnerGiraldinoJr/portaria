@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
@include('admin.layouts.header')
@stop

@section('content')
<section id="app" class="content">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body ">

                    <div class="row">
                        @role('admin')
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">

                                    <h3>{{$data['admin']}}</h3>

                                    <p>Administradores</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-lock"></i>
                                </div>
                                <a href="{{ route($params['main_route'].'.user.index')}}" class="small-box-footer">Ver
                                    Mais <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        @endrole
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>{{$data['EncomendasEntregues']}}</h3>
                                    <p>Entregas Realizadas</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <a href="{{ route($params['main_route'].'.controleacesso.index')}}"
                                    class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right">
                                </i>
                            </a>
                            </div>
                        </div>
                        <!-- ./col -->

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{$data['EncomendasNaoEntregues']}}</h3>

                                    <p>Qtd. Pendentes Portaria</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <a href="{{ route($params['main_route'].'.controleacesso.index')}}" class="small-box-footer">Ver
                                    Mais <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>{{ $totalPessoas }}</h3>
                                    
                                    <p>Total de Moradores</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-tag"></i>
                                </div>
                                <a href="{{ route($params['main_route'].'.pessoa.index')}}"
                                    class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3>{{$data['QuantidadesVisitantes']}}</h3>

                                    <p>Visitantes no Condomínio</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-clipboard"></i>
                                </div>
                                <a href="{{ route($params['main_route'].'.visitante.index')}}"
                                    class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">                           
    <!-- ./col -->
    </div>
    </div>
    </div>
    </div>
    </div>

</section>

@stop