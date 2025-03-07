@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('register') }}"
        class="relative z-20 w-full rounded-3xl bg-white/70 px-6 py-10 shadow-2xl backdrop-blur-md sm:max-w-full sm:px-8 md:max-w-lg md:px-10 lg:max-w-xl xl:max-w-2xl">
        @csrf

        <!-- Centered Purple Logo -->
        <div class="mb-6 flex justify-center">
            <a href="/" class="inline-block">
                <img src="{{ asset('assets/img/logo_text.png') }}" alt="Logo" class="h-12">
            </a>
        </div>

        <!-- Heading -->
        <h1 class="mb-8 text-center text-3xl font-bold text-purple-900">Sign Up</h1>

        <!-- Validation Errors -->
        <x-validation-errors class="mb-4 text-sm text-red-600" />

        <!-- Form Inputs -->
        <div class="space-y-4">
            <div class="flex flex-col gap-2 lg:flex-row">
                {{-- First Name --}}
                <input id="fname" type="text" name="fname" :value="old('fname')" required autofocus autocomplete="fname"
                    placeholder="First Name"
                    class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400 lg:w-1/2" />

                {{-- Last Name --}}
                <input id="lname" type="text" name="lname" :value="old('lname')" required autocomplete="lname"
                    placeholder="Last Name"
                    class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400 lg:w-1/2" />
            </div>

            {{-- Email --}}
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                placeholder="Email Address"
                class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400" />

            {{-- Password --}}
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password"
                class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400" />

            {{-- Confirm Password --}}
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                placeholder="Confirm Password"
                class="w-full rounded-full border-none bg-purple-100 px-4 py-3 text-sm text-purple-900 placeholder-purple-400 focus:outline-none focus:ring-2 focus:ring-purple-400" />
        </div>

        <!-- Submit Button -->
        <div class="mt-6 text-center">
            <button type="submit"
                    class="w-full rounded-full bg-gradient-to-r from-purple-500 to-purple-700 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all hover:scale-105 hover:from-purple-600 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2">
                🚀 Sign Up
            </button>
        </div>

        <!-- Login Prompt -->
        <div class="mt-6 text-center text-sm text-purple-800">
            Already have an account?
            <a href="{{ route('login') }}" class="font-bold text-purple-900 underline hover:text-purple-700">Login</a>
        </div>
    </form>
@endsection



{{-- <x-guest-layout>
    <x-authentication-card>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
