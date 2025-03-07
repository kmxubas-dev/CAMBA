@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.confirm') }}" 
          class="relative z-20 w-full rounded-3xl bg-white/70 px-6 py-10 shadow-2xl backdrop-blur-md sm:max-w-full sm:px-8 md:max-w-lg md:px-10 lg:max-w-xl xl:max-w-2xl">
        @csrf

        <!-- Centered Purple Logo -->
        <div class="mb-6 flex justify-center">
            <a href="/" class="inline-block">
                <img src="{{ asset('assets/img/logo_text.png') }}" alt="Logo" class="h-12">
            </a>
        </div>

        <!-- Heading -->
        <h1 class="mb-1 text-center text-3xl font-bold text-purple-900">Confirm Your Password</h1>
        <p class="mb-6 text-center text-sm text-purple-700">Please confirm your password before continuing.</p>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4 text-sm text-red-600" />

        <!-- Form Inputs -->
        <div class="space-y-4">
            <!-- Password Input -->
            <input id="password" type="password" name="password" required autocomplete="current-password" autofocus
                   placeholder="Password"
                   class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400" />
        </div>

        <!-- Submit Button -->
        <div class="mt-6 text-center">
            <button type="submit" 
                    class="w-full rounded-full bg-gradient-to-r from-purple-500 to-purple-700 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all hover:scale-105 hover:from-purple-600 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">
                {{ __('Confirm') }}
            </button>
        </div>

        <!-- Forgot Password Link (Optional) -->
        <!-- You can remove this if it's not needed -->
        <!-- @if (Route::has('password.request'))
            <div class="mt-4 text-center">
                <a href="{{ route('password.request') }}"
                   class="text-sm text-purple-800 underline hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    {{ __('Forgot your password?') }}
                </a>
            </div>
        @endif -->
    </form>
@endsection



{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div>
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="current-password" autofocus />
            </div>

            <div class="mt-4 flex justify-end">
                <x-button class="ms-4">
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
