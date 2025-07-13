@extends('layouts.layout')
<!-- yes i am using diff lay out -->
@section('content')
<img src="{{asset('logo.png')}}" alt="Logo" class="object-contain w-80 h-80">
<div class="flex flex-col md:flex-row md:items-start gap-8 w-full px-4 max-w-7xl mx-auto">

 <div class="w-full md:w-1/2 bg-white p-6 rounded shadow">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <h2 class="text-2xl font-bold mb-4">Daftar</h2>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Sudaf Daftar? Login Sini!') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>

<div class="w-full md:w-1/2 bg-white p-6 rounded shadow text-center">
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
