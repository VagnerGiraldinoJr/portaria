<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Título dinâmico --}}
    <title>@yield('title', config('app.name', 'Laravel'))</title>

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

    {{-- CSS Principal --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Estilo para Modo Escuro --}}
    <style>
        body.dark-mode {
            background-color: #343a40;
            color: #ffffff;
        }

        body.dark-mode .navbar {
            background-color: #2c3034;
            color: #ffffff;
        }

        body.dark-mode .card {
            background-color: #495057;
            color: #ffffff;
        }

        body.dark-mode a {
            color: #ffc107;
        }
    </style>
</head>

<body class="@yield('body-class')">
    <div id="app">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- Left Side --}}
                    <ul class="navbar-nav mr-auto"></ul>

                    {{-- Right Side --}}
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a href="#" id="toggle-dark-mode" class="nav-link">
                                <i id="dark-mode-icon" class="fas fa-moon"></i>
                                <span id="dark-mode-text">Modo Escuro</span>
                            </a>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{-- Conteúdo Principal --}}
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    {{-- Scripts --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleDarkMode = document.getElementById('toggle-dark-mode');
            const darkModeIcon = document.getElementById('dark-mode-icon');
            const darkModeText = document.getElementById('dark-mode-text');
            const isDarkMode = localStorage.getItem('dark-mode') === 'true';

            // Aplica o tema salvo
            if (isDarkMode) {
                document.body.classList.add('dark-mode');
                darkModeIcon.classList.remove('fa-moon');
                darkModeIcon.classList.add('fa-sun');
                darkModeText.innerText = 'Modo Claro';
            }

            // Alterna o tema
            toggleDarkMode.addEventListener('click', function (e) {
                e.preventDefault();
                document.body.classList.toggle('dark-mode');
                const isDark = document.body.classList.contains('dark-mode');
                localStorage.setItem('dark-mode', isDark);

                if (isDark) {
                    darkModeIcon.classList.remove('fa-moon');
                    darkModeIcon.classList.add('fa-sun');
                    darkModeText.innerText = 'Modo Claro';
                } else {
                    darkModeIcon.classList.remove('fa-sun');
                    darkModeIcon.classList.add('fa-moon');
                    darkModeText.innerText = 'Modo Escuro';
                }
            });
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateMemoryBadge() {
            fetch("{{ url('/admin/memory-usage') }}")
                .then(response => response.json())
                .then(data => {
                    const badge = document.querySelector('#memory-badge-menu .badge');

                    if (badge) {
                        badge.innerText = `${data.percent}%`;

                        if (data.percent < 50) {
                            badge.className = "badge badge-success";
                        } else if (data.percent < 80) {
                            badge.className = "badge badge-warning";
                        } else {
                            badge.className = "badge badge-danger";
                        }
                    }
                })
                .catch(error => console.error('Erro ao buscar uso de memória:', error));
        }

        updateMemoryBadge();
        setInterval(updateMemoryBadge, 5000);
    });
</script>

</body>

</html>
