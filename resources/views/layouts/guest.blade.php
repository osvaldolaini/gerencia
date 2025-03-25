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
    <meta name="keywords" content="api,aeronaves,aeroportos,aplicativos">
    <meta name="description" content="SISTEMA.AERO Ferramenta destinada auxiliar na gestão de aeroclubes">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <x-favicons></x-favicons>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="relative h-screen overflow-hidden antialiased text-black bg-black bg-cover">
    <div class="font-sans antialiased ">
        {{ $slot }}
    </div>

    @livewireScripts

    <script src="{{ asset('js/vanilla-masker.min.js') }}"></script>
    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(() => console.log('Service Worker registrado'))
                .catch((error) => console.log('Erro ao registrar Service Worker', error));
        }
    </script>
</body>

</html>
