<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('adminlte.title'))</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    {{-- AdminLTE CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- Custom CSS --}}
    @yield('css')

    {{-- Scripts Globais --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed @yield('body-class')">
    <div class="wrapper">
        {{-- Header --}}
        @include('admin.layouts.header')

        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')

        {{-- Main Content --}}
        <div class="content-wrapper">
            <section class="content-header">
                @yield('content_header')
            </section>

            <section class="content">
                @yield('content')
            </section>
        </div>

        {{-- Footer --}}
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
                Versão {{ config('app.version') }}
            </div>
            <strong>&copy; {{ date('Y') }} {{ config('adminlte.title') }}.</strong> Todos os direitos reservados.
        </footer>
    </div>

    {{-- Scripts adicionais --}}
    @yield('js')

    {{-- Script para Modo Escuro --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleDarkMode = document.getElementById('toggle-dark-mode');
            const darkModeIcon = document.getElementById('dark-mode-icon');
            const darkModeText = document.getElementById('dark-mode-text');
            
            if (toggleDarkMode && darkModeIcon && darkModeText) {
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
            } else {
                console.error('Erro: Elementos do botão Modo Escuro não foram encontrados.');
            }
        });
    </script>
</body>

</html>
