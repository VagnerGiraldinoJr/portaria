<header class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
    {{-- Título e Unidade --}}
    <div>
        @if (isset($params['unidade_descricao']))
            <h4 class="mb-0">
                {{ $params['titulo'] }}
                @if (!empty($params['unidade_descricao']))
                    <i class="bi bi-arrow-right-short"></i> {{ $params['unidade_descricao'] }}
                @endif
            </h4>
        @endif
    </div>

    {{-- Breadcrumb --}}
    <div>
        @if (isset($params['arvore']))
            <h6>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-secondary mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                        @foreach ($params['arvore'] as $v)
                            @if ($v['url'] == '')
                                <li class="breadcrumb-item active" aria-current="page">{{ $v['titulo'] }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ url($v['url']) }}">{{ $v['titulo'] }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </h6>
        @endif
    </div>

    
</header>
