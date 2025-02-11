<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="{{ asset('assets/img/logo.png') }}" type="image/x-icon" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            <div class="flex min-h-screen items-center justify-center bg-purple-300">
                <div class="absolute left-16 top-5 z-0 hidden h-60 w-60 rotate-45 transform rounded-xl bg-purple-200 sm:block"></div>
                <div class="absolute bottom-6 right-10 hidden h-48 w-48 rotate-12 transform rounded-xl bg-purple-200 sm:block"></div>
                @yield('content')
                <div class="absolute right-12 top-0 hidden h-40 w-40 rounded-full bg-purple-200 sm:block"></div>
                <div class="absolute bottom-20 left-10 hidden h-40 w-20 rotate-45 transform rounded-full bg-purple-200 sm:block"></div>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
