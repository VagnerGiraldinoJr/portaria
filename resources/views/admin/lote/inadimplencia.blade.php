@extends('adminlte::page')

@section('title', 'Gerenciar Inadimplência do Lote')

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title">
                                ⚙️ Gerenciar Inadimplência do Lote: <strong>{{ $data->descricao }}</strong>
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.lote.index') }}" class="btn btn-secondary btn-sm">
                                    ⬅️ Voltar para lista
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Status Atual:</strong></p>
                                    @if ($data->inadimplente)
                                        <span class="badge bg-danger">🔴 Inadimplente</span>
                                    @else
                                        <span class="badge bg-success">🟢 Regular</span>
                                    @endif
                                    <hr>
                                    <p><strong>Última Ação:</strong></p>
                                    @if ($data->inadimplente)
                                        <span>
                                            Marcado como inadimplente por
                                            <strong>{{ $data->inadimplentePor->name ?? 'N/A' }}</strong>
                                            em
                                            <strong>{{ \Carbon\Carbon::parse($data->inadimplente_em)->format('d/m/Y H:i') }}</strong>
                                        </span>
                                    @else
                                        <span>
                                            Regularizado por <strong>{{ $data->regularizadoPor->name ?? 'N/A' }}</strong>
                                            em
                                            <strong>{{ \Carbon\Carbon::parse($data->regularizado_em)->format('d/m/Y H:i') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="col-md-6 text-center align-self-center">
                                    @if ($data->inadimplente)
                                        <form action="{{ route('admin.lote.regularizar', $data->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-lg">
                                                ✅ Regularizar Lote
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.lote.marcarInadimplente', $data->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-lg">
                                                ⚠️ Marcar como Inadimplente
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer text-center">
                            <a href="{{ route('admin.lote.index') }}" class="btn btn-outline-secondary">
                                ⬅️ Voltar para lista
                            </a>
                        </div>
                        <!-- /.card-footer -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <style>
        .card-header {
            font-size: 1.2rem;
        }

        .badge {
            font-size: 1rem;
        }

        .btn-lg {
            padding: 10px 20px;
            font-size: 1.1rem;
        }

        hr {
            margin: 10px 0;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('✅ Tela de Gerenciamento de Inadimplência carregada com sucesso!');
    </script>
@stop
