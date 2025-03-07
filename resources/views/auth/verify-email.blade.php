@extends('layouts.auth')

@section('content')
<div class="relative z-20 w-full max-w-full rounded-3xl bg-white/70 px-6 py-10 shadow-2xl backdrop-blur-md sm:max-w-full sm:px-8 md:max-w-lg md:px-10 lg:max-w-xl xl:max-w-2xl">
    {{-- Progress Bar --}}
    <div class="mb-6">
        <div class="h-2 w-full rounded-full bg-purple-100">
            <div class="h-2 w-2/3 rounded-full bg-gradient-to-r from-purple-500 to-purple-700 transition-all duration-700 ease-in-out"></div>
        </div>
        <p class="mt-2 text-center text-xs font-medium tracking-wide text-purple-600">Step 2 of 3: Verify your email</p>
    </div>

    {{-- Logo --}}
    <div class="mb-6 flex justify-center">
        <a href="/">
            <img src="{{ asset('assets/img/logo_text.png') }}" alt="Logo" class="h-12">
        </a>
    </div>

    {{-- Heading --}}
    <h1 class="mb-2 text-center text-3xl font-bold text-purple-900">Verify Your Email</h1>
    <p class="mb-6 text-center text-sm text-purple-700">
        We’ve sent you a verification link. Click it to activate your account.
    </p>

    {{-- Success Message --}}
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 flex translate-y-0 items-center justify-center gap-2 rounded-md bg-green-100 p-3 text-center text-sm font-medium text-green-700 opacity-100 transition-all duration-500 ease-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            A new verification link has been sent!
        </div>
    @endif

    <div class="mb-6 text-center text-sm text-purple-700">
        Didn’t get the email? No problem — you can resend it.
    </div>

    {{-- Action Buttons --}}
    <div class="mb-6 flex justify-center gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit"
                    class="w-full transform rounded-full bg-gradient-to-r from-purple-500 to-purple-700 px-6 py-2 text-sm font-semibold text-white shadow-md transition-transform duration-300 hover:scale-105 hover:from-purple-600 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-offset-2 sm:w-auto">
                <span class="inline-block align-middle">🔁</span> Resend Email
            </button>
        </form>
    </div>

    {{-- Footer Actions --}}
    <div class="flex flex-col justify-between gap-2 text-center text-sm text-purple-800 sm:flex-row sm:text-left">
        <a href="{{ route('profile.show') }}" class="underline transition hover:text-purple-900">
            ✏️ Edit Profile
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline transition hover:text-purple-900">
                🚪 Log Out
            </button>
        </form>
    </div>
</div>
@endsection



{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm font-medium text-green-600">
                {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button type="submit">
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

            <div>
                <a
                    href="{{ route('profile.show') }}"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    {{ __('Edit Profile') }}</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <button type="submit" class="ms-2 rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout> --}}
