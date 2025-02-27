<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <x-favicons></x-favicons>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="relative h-screen overflow-hidden antialiased text-gray-100 bg-black bg-cover"
    style="background-image: url({{ url('storage/logos/error-background-20-color.png') }});">

    <section class="h-screen text-gray-100 sm:px-0 lg:px-36 sm:my-12 lg:my-0">
        <div
            class="container flex flex-col justify-center p-6 mx-auto sm:py-12 lg:py-24 lg:flex-row lg:justify-between">
            <div class="flex flex-col justify-center p-6 text-center rounded-sm lg:max-w-md xl:max-w-lg lg:text-left">
                <h1 class="text-5xl font-bold leading-none sm:text-6xl">
                    @yield('message')
                </h1>
                <p class="mt-6 mb-8 font-extrabold text-blue-600 sm:mb-12 text-8xl animate-bounce">
                    @yield('code')
                </p>
                <a href="{{ route('dashboard') }}"
                    class="px-8 py-3 text-lg font-semibold text-white bg-black border border-white rounded-md">
                    Voltar
                </a>
            </div>
            <div
                class="items-center justify-center hidden p-6 mt-8 sm:flex lg:mt-0 h-72 sm:h-80 lg:h-96 xl:h-112 2xl:h-128 ">
                <img src="{{ url('storage/logos/logo-sistema-aero-2.png') }}" alt=""
                    class="object-contain h-72 sm:h-80 lg:h-96 xl:h-112 2xl:h-128">
            </div>
        </div>
    </section>
</body>

</html>
