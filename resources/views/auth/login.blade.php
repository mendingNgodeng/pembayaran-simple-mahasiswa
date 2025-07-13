@extends('layouts.layout')

@section('content')

<div class="flex justify-center my-6">
    <img src="{{ asset('logo.png') }}" alt="Logo" class="w-48 md:w-64 lg:w-80 object-contain">
</div>

<div class="flex flex-col md:flex-row gap-8 w-full max-w-7xl px-8 mx-auto">

    <!-- Login Form -->
    <div class="w-full md:w-1/2 bg-white p-6 rounded shadow text-base">
        <h2 class="text-2xl font-bold mb-4">Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                    required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                <a class="underline text-sm text-gray-600 ml-5 hover:text-gray-900"
                    href="{{ route('register') }}">
                    {{ __('Belum daftar? daftar dulu disini!') }}
                </a>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Info Section -->
    <div class="w-full md:w-1/2 bg-white p-6 rounded shadow text-center text-lg">
        <h1 class="text-3xl font-bold mb-4 text-indigo-700">Sistem Informasi Mahasiswa</h1>
        <p class="text-gray-700 mb-4">
            Selamat datang di <strong>Sistem Informasi Mahasiswa</strong>, sebuah platform digital yang dirancang untuk membantu proses pengelolaan data akademik dan administrasi mahasiswa secara lebih efisien.
        </p>
        <p class="text-gray-700 mb-4">
            Sistem ini mencakup berbagai fitur penting, seperti manajemen data mahasiswa dan pemantauan pembayaran secara real-time, sehingga mempermudah tugas staf akademik dan keuangan.
        </p>
        <p class="text-gray-700">
            Silakan login menggunakan akun yang telah diberikan untuk mulai mengakses sistem.
        </p>
    </div>

</div>
@endsection
