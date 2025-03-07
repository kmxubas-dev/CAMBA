@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('two-factor.login') }}"
        x-data="{ recovery: false }"
        class="relative z-20 w-full rounded-3xl bg-white/70 px-6 py-10 shadow-2xl backdrop-blur-md sm:max-w-full sm:px-8 md:max-w-lg md:px-10 lg:max-w-xl xl:max-w-2xl">
        @csrf

        <!-- Centered Purple Logo -->
        <div class="mb-6 flex justify-center">
            <a href="/" class="inline-block">
                <img src="{{ asset('assets/img/logo_text.png') }}" alt="Logo" class="h-12">
            </a>
        </div>

        <!-- Heading -->
        <h1 class="mb-1 text-center text-3xl font-bold text-purple-900">
            {{ __('Two-Factor Authentication') }}
        </h1>

        <!-- Description -->
        <p class="mb-6 text-center text-sm text-purple-700" x-show="! recovery">
            {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
        </p>
        <p class="mb-6 text-center text-sm text-purple-700" x-cloak x-show="recovery">
            {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
        </p>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4 text-sm text-red-600" />

        <!-- Form Inputs -->
        <div class="space-y-4">
            <div x-show="! recovery">
                <input id="code" name="code" type="text" inputmode="numeric" autofocus autocomplete="one-time-code"
                    placeholder="Authentication Code"
                    x-ref="code"
                    class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400" />
            </div>

            <div x-cloak x-show="recovery">
                <input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code"
                    placeholder="Recovery Code"
                    x-ref="recovery_code"
                    class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400" />
            </div>
        </div>

        <!-- Toggle Links -->
        <div class="mt-4 flex flex-col items-center text-sm">
            <button type="button" class="mb-2 text-purple-700 underline hover:text-purple-900 focus:outline-none"
                x-show="! recovery"
                x-on:click="
                    recovery = true;
                    $nextTick(() => { $refs.recovery_code.focus() })
                ">
                {{ __('Use a recovery code') }}
            </button>

            <button type="button" class="mb-2 text-purple-700 underline hover:text-purple-900 focus:outline-none"
                x-cloak
                x-show="recovery"
                x-on:click="
                    recovery = false;
                    $nextTick(() => { $refs.code.focus() })
                ">
                {{ __('Use an authentication code') }}
            </button>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 text-center">
            <button type="submit"
                class="w-full rounded-full bg-gradient-to-r from-purple-500 to-purple-700 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all hover:scale-105 hover:from-purple-600 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">
                🔐 {{ __('Log in') }}
            </button>
        </div>
    </form>
@endsection



{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div x-data="{ recovery: false }">
            <div class="mb-4 text-sm text-gray-600" x-show="! recovery">
                {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
            </div>

            <div class="mb-4 text-sm text-gray-600" x-cloak x-show="recovery">
                {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf

                <div class="mt-4" x-show="! recovery">
                    <x-label for="code" value="{{ __('Code') }}" />
                    <x-input id="code" class="mt-1 block w-full" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                </div>

                <div class="mt-4" x-cloak x-show="recovery">
                    <x-label for="recovery_code" value="{{ __('Recovery Code') }}" />
                    <x-input id="recovery_code" class="mt-1 block w-full" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="mt-4 flex items-center justify-end">
                    <button type="button" class="cursor-pointer text-sm text-gray-600 underline hover:text-gray-900"
                                    x-show="! recovery"
                                    x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                        {{ __('Use a recovery code') }}
                    </button>

                    <button type="button" class="cursor-pointer text-sm text-gray-600 underline hover:text-gray-900"
                                    x-cloak
                                    x-show="recovery"
                                    x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                        {{ __('Use an authentication code') }}
                    </button>

                    <x-button class="ms-4">
                        {{ __('Log in') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-authentication-card>
</x-guest-layout> --}}
