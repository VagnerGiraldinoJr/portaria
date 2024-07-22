<head>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css">

</head>

<body>
    <header>
        @if (isset($params['unidade_descricao']))
            <h4>
                {{ $params['titulo'] }}
                @if (!empty($params['unidade_descricao']))
                    <i class="bi bi-arrow-right-short"></i> {{ $params['unidade_descricao'] }}
                @endif
            </h4>
        @endif

        @if (isset($params['arvore']))
            <h6>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-secondary">
                        <li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
                        @foreach ($params['arvore'] as $v)
                            @if ($v['url'] == '')
                                <li class="breadcrumb-item active" aria-current="page">{{ $v['titulo'] }}</li>
                            @else
                                <li class="breadcrumb-item" aria-current="page"><a
                                        href="{{ url($v['url']) }}">{{ $v['titulo'] }}</a></li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            </h6>
        @endif
    </header>
    <!-- Conteúdo principal da página -->
    <main>
        @yield('content')
    </main>

</body>

</html>
