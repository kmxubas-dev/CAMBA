@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}"
        class="relative z-20 w-full rounded-3xl bg-white/70 px-6 py-10 shadow-2xl backdrop-blur-md sm:max-w-full sm:px-8 md:max-w-lg md:px-10 lg:max-w-xl xl:max-w-2xl">
        @csrf

        <!-- Centered Purple Logo -->
        <div class="mb-6 flex justify-center">
            <a href="/" class="inline-block">
                <img src="{{ asset('assets/img/logo_text.png') }}" alt="Logo" class="h-12">
            </a>
        </div>

        <!-- Heading -->
        <h1 class="mb-1 text-center text-3xl font-bold text-purple-900">Login</h1>
        <p class="mb-6 text-center text-sm text-purple-700">Enter your account details to sign in.</p>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4 text-sm text-red-600" />

        <!-- Form Inputs -->
        <div class="space-y-4">
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="Email Address"
                class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400" />

            <input id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="Password"
                class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400" />
        </div>

        <!-- Submit Button -->
        <div class="mt-6 text-center">
            <button type="submit"
                    class="w-full rounded-full bg-gradient-to-r from-purple-500 to-purple-700 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all hover:scale-105 hover:from-purple-600 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">
                🔐 Login
            </button>
        </div>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}"
                class="text-sm text-purple-800 underline hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    {{ __('Forgot your password?') }}
                </a>
            </div>
        @endif

        <!-- Register Prompt -->
        <div class="mt-6 text-center text-sm text-purple-800">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-bold text-purple-900 underline hover:text-purple-700">Sign up</a>
        </div>
    </form>
@endsection



{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="mt-4 block">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="mt-4 flex items-center justify-end">
                @if (Route::has('password.request'))
                    <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
