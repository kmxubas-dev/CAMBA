@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('login') }}" class="z-20 mx-6 w-full rounded-2xl bg-white px-6 pb-12 pt-4 shadow-xl sm:w-full lg:w-1/2 lg:px-10">
    @csrf

    <div class="text-purple-800">
        <div class="m-auto max-w-[25rem] px-24">
            <a href="/">
                <img src="{{ asset('assets/img/logo_text.png') }}" alt="" class="">
            </a>
        </div>

        <hr class="my-4">
        <h1 class="mb-1 text-center text-3xl font-bold text-purple-900">Login</h1>
        <p class="mb-8 w-full text-center text-sm font-medium tracking-wide">Enter account details</p>
    </div>
    <div class="space-y-4 font-medium text-purple-950">
        <x-validation-errors class="mb-4" />

        <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email Addres" class="block w-full rounded-full border-transparent bg-purple-300 px-4 py-3 text-sm placeholder:text-purple-100 focus:border-transparent focus:bg-purple-400 focus:ring-0" />

        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" class="block w-full rounded-full border-transparent bg-purple-300 px-4 py-3 text-sm placeholder:text-purple-100 focus:border-transparent focus:bg-purple-400 focus:ring-0" />
    </div>
    <div class="mt-6 text-center">
        <button class="w-full rounded-full bg-purple-500 py-2 text-white transition-all hover:bg-purple-800">Login</button>

        @if (Route::has('password.request'))
            <p class="mt-4">
                <a class="rounded-md text-sm text-purple-800 underline hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            </p>
        @endif

        <p class="mt-8 text-sm text-purple-800">
            Don't have an account?
            <a href="{{ route('register') }}" class="cursor-pointer font-bold text-purple-900 underline"> Signup</a>
        </p>
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
