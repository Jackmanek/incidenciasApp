<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="//unpkg.com/alpinejs" defer></script>
        <livewire:styles />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div class="relative flex justify-around sm:items-center h-20 bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div>
                <h1 class="mb-4 text-2xl font-extrabold text-gray-900 dark:text-white md:text-2xl lg:text-3xl">Gestor <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">Web</span> de Incidencias</h1>
            </div>
            @if (Route::has('login'))
                <div class="flex justify-end sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full uppercase ">
                            {{ Auth::user()->name }}</button>
                        </a>

                        <div class="border-gray-200">
                            <div class="px-4">
                                <div class="font-medium text-base text-gray-800 uppercase"></div>
                            </div>
                            <div class="space-y-1">

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        <button class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full uppercase ">Salir</button>
                                    </a>
                                </form>
                            </div>
                        </div>
                        <div class="felx content-end px-4">
                            <h6 class="bg-blue-100 text-blue-800 text-xl font-semibold me-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ms-2">{{ Auth::user()->role }}</h6>
                        </div>

                    @else
                        <a href="/" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar sesion</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrar</a>
                        @endif
                    @endauth
                </div>

            @endif
        </div>

        <main  class="w-full">
            @yield('content')
        </main>
        @livewireScripts
    </body>
</html>
