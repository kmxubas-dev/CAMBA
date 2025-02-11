@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('register') }}" class="z-20 mx-6 w-full rounded-2xl bg-white px-6 pb-12 pt-4 shadow-xl sm:w-full lg:w-3/5 lg:px-10">
    @csrf

    <div class="text-purple-800">
        <div class="m-auto max-w-[25rem] px-24">
            <a href="/">
                <img src="{{ asset('assets/img/logo_text.png') }}" alt="" class="">
            </a>
        </div>

        <hr class="my-4">
        <h1 class="mb-8 text-center text-3xl font-bold text-purple-900">Sign up</h1>
    </div>
    <div class="space-y-4 font-medium text-purple-950">
        <x-validation-errors class="mb-4" />

        <div class="flex flex-col gap-2 lg:flex-row">
            {{-- Fname --}}
            <input id="fname" type="text" name="name" :value="old('fname')" required autofocus autocomplete="fname" placeholder="First Name" class="block w-full rounded-full border-transparent bg-purple-300 px-4 py-3 text-sm placeholder:text-purple-100 focus:border-transparent focus:bg-purple-400 focus:ring-0" />

            {{-- Lname --}}
            <input id="lname" type="text" name="lname" :value="old('lname')" required autocomplete="lname" placeholder="Last Name" class="block w-full rounded-full border-transparent bg-purple-300 px-4 py-3 text-sm placeholder:text-purple-100 focus:border-transparent focus:bg-purple-400 focus:ring-0" />
        </div>

        {{-- Email --}}
        <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email Addres" class="block w-full rounded-full border-transparent bg-purple-300 px-4 py-3 text-sm placeholder:text-purple-100 focus:border-transparent focus:bg-purple-400 focus:ring-0" />

        {{-- Password --}}
        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password" class="block w-full rounded-full border-transparent bg-purple-300 px-4 py-3 text-sm placeholder:text-purple-100 focus:border-transparent focus:bg-purple-400 focus:ring-0" />

        {{-- Confirm Password --}}
        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password" class="block w-full rounded-full border-transparent bg-purple-300 px-4 py-3 text-sm placeholder:text-purple-100 focus:border-transparent focus:bg-purple-400 focus:ring-0" />
    </div>
    <div class="mt-6 text-center">
        <button class="w-full rounded-full bg-purple-500 py-2 text-white transition-all hover:bg-purple-800">Signup</button>

        <p class="mt-8 text-sm text-purple-800">
            Already have an account?
            <a href="{{ route('login') }}" class="cursor-pointer font-bold text-purple-900 underline"> Login</a>
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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="mt-1 block w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="mt-1 block w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="mt-1 block w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="mt-1 block w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

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

            <div class="mt-4 flex items-center justify-end">
                <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
