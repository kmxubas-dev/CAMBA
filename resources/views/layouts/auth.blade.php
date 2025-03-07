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
    <body class="relative min-h-screen overflow-hidden font-sans text-white antialiased">

        <!-- Full-screen gradient background -->
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-purple-900 via-purple-600 to-pink-800"></div>
    
        <!-- Optional starry background overlay -->
        <div class="absolute inset-0 z-0 bg-[url('/assets/img/stars.svg')] bg-cover bg-center opacity-10"></div>
    
        <!-- Floating Animated Background Blobs -->
        <div class="pointer-events-none absolute inset-0 z-10">
            <div class="animate-float-slow absolute left-[-10%] top-[-10%] h-72 w-72 rounded-full bg-purple-400 opacity-30 mix-blend-overlay"></div>
            <div class="animate-float-medium absolute bottom-[-15%] right-[-10%] h-96 w-96 rounded-full bg-pink-500 opacity-20 mix-blend-overlay"></div>
            <div class="animate-float-fast absolute left-10 top-5 hidden h-60 w-60 rotate-45 transform rounded-xl bg-purple-300 opacity-40 blur-2xl sm:block"></div>
            <div class="animate-float-medium absolute bottom-6 right-10 hidden h-48 w-48 rotate-12 transform rounded-xl bg-pink-300 opacity-40 blur-2xl sm:block"></div>
            <div class="animate-float-slow absolute right-12 top-0 hidden h-40 w-40 rounded-full bg-purple-300 opacity-50 blur-md sm:block"></div>
            <div class="animate-float-medium absolute bottom-20 left-10 hidden h-40 w-20 rotate-45 transform rounded-full bg-purple-400 opacity-40 blur-md sm:block"></div>
        </div>
    
        <!-- Page Content Area -->
        <main class="relative z-20 flex min-h-screen items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
            @yield('content')
        </main>
    
        @livewireScripts
    
        <!-- Custom Animation Styles (scoped here, no config needed) -->
        <style>
            @keyframes float-slow {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-20px); }
            }
            @keyframes float-medium {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-40px); }
            }
            @keyframes float-fast {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-60px); }
            }
    
            .animate-float-slow {
                animation: float-slow 10s ease-in-out infinite;
            }
            .animate-float-medium {
                animation: float-medium 8s ease-in-out infinite;
            }
            .animate-float-fast {
                animation: float-fast 6s ease-in-out infinite;
            }
        </style>
    </body>    
</html>
