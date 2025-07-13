<x-guest-layout>
    <div class="text-center">
        <h1 class="text-3xl font-bold mb-4">Sistem Informasi Mahasiswa</h1>
        <p class="text-gray-700 mb-6">Kelola data mahasiswa dan pembayaran UKT dengan mudah.</p>

           @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="{{ route('mahasiswa.index') }}" class="bg-indigo-600 text-white px-6 py-3 rounded hover:bg-indigo-700 transition">
                Kelola Mahasiswa
            </a>
            <a href="{{ route('bayar.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
                Kelola Pembayaran
            </a>
        </div>
    </div>
</x-guest-layout>
