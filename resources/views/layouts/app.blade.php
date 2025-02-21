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

<body class="{{ auth()->user()->dark ? 'dark' : '' }} font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @livewire('admin.page.nav-bar')

        @livewire('message-alert')

        <!-- Page Content -->
        <main>
            <div class="drawer lg:drawer-open">
                <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content">
                    <!-- Page content here -->
                    <div class="m-3 bg-white sm:m-4 sm:p-5 rounded-2xl dark:bg-gray-700">
                        {{ $slot }}
                    </div>
                </div>
                <div class="drawer-side">
                    <label for="my-drawer-3" class="drawer-overlay"></label>
                    @if (auth()->user()->panel == 'user')
                        @livewire('user.side-bar')
                    @else
                        @livewire('admin.page.side-bar')
                    @endif
                </div>
            </div>
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script> --}}
    <script src="{{ asset('js/vanilla-masker.min.js') }}"></script>
    @yield('scripts')
    @yield('push')
</body>

</html>
