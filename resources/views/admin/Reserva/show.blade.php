@section('content')
    <h1>Detalhes do Visitante</h1>
    <p><strong>Nome:</strong> {{ $visitante->nome }}</p>
    <p><strong>Documento:</strong> {{ $visitante->documento }}</p>
    <p><strong>Placa do Veículo:</strong> {{ $visitante->placa_do_veiculo }}</p>
    <p><strong>Motivo:</strong> {{ $visitante->motivo }}</p>
    <p><strong>Hora de Entrada:</strong> {{ $visitante->hora_de_entrada }}</p>
    <p><strong>Hora de Saída:</strong> {{ $visitante->hora_de_saida }}</p>
    <a href="{{ route('admin.visitante.index') }}">Voltar</a>
@endsection