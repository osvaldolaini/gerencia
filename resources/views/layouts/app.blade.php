<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- PWA  -->
    <meta content='yes' name='apple-mobile-web-app-capable' />
    <meta content='yes' name='mobile-web-app-capable' />
    <meta name="theme-color" content="#ffffff" />
    <meta name="apple-mobile-web-app-status-bar" content="#ffffff">
    <link rel="apple-touch-icon" href="{{ asset('favicons/pwa-logos/icon-192x192-apple.png') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="api,colegios,aplicativos">
    <meta name="description"
        content="Sistema de Gerenciamento destinado a Centros de Instrução de Aviação Civil - CIAC.">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <x-favicons></x-favicons>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @yield('styles')
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
</head>

<body class="{{ auth()->user()->dark ? 'dark' : '' }} font-sans antialiased p-0 m-0 dark:text-white dark:bg-gray-800">
    <div class="min-h-screen p-0 m-0 bg-gray-100 dark:bg-gray-900">
        @livewire('message-alert')
        <!-- Page Content -->
        <main class="p-0 m-0 bg-gray-100 dark:bg-gray-900">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    @yield('scripts')
    @yield('push')
</body>

</html>
