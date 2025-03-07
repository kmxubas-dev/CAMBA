@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.email') }}"
        class="relative z-20 w-full rounded-3xl bg-white/70 px-6 py-10 shadow-2xl backdrop-blur-md sm:max-w-full sm:px-8 md:max-w-lg md:px-10 lg:max-w-xl xl:max-w-2xl">
        @csrf

        <!-- Centered Purple Logo -->
        <div class="mb-6 flex justify-center">
            <a href="/" class="inline-block">
                <img src="{{ asset('assets/img/logo_text.png') }}" alt="Logo" class="h-12">
            </a>
        </div>

        <!-- Heading -->
        <h1 class="mb-1 text-center text-3xl font-bold text-purple-900">Forgot Password</h1>
        <p class="mb-6 text-center text-sm text-purple-700">Enter your email address to receive a password reset link.</p>

        <!-- Success Message -->
        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4 text-sm text-red-600" />

        <!-- Form Input -->
        <div class="space-y-4">
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                placeholder="Email Address"
                class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400" />
        </div>

        <!-- Submit Button -->
        <div class="mt-6 text-center">
            <button type="submit"
                class="w-full rounded-full bg-gradient-to-r from-purple-500 to-purple-700 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all hover:scale-105 hover:from-purple-600 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">
                Email Password Reset Link
            </button>
        </div>

        <!-- Back to Login Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-purple-800">
                Remembered your password? <a href="{{ route('login') }}" class="font-bold text-purple-900 underline hover:text-purple-700">Log in</a>
            </p>
        </div>
    </form>
@endsection



{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @session('status')
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ $value }}
            </div>
        @endsession

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
