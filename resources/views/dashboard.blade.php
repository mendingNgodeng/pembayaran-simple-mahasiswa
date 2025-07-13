<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} | Selamat Datang 
            <span class="sm:mt-3 bg-blue-500 p-2 text-white rounded-md">{{ Auth::user()->name }}</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="w-full mx-auto sm:px-6">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="text-gray-900 grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    
                    {{-- Total Mahasiswa --}}
                    <div class="w-full max-w-sm p-4 bg-white border-l-4 border-red-900 rounded-lg shadow-sm text-center">
                        <h5 class="mb-2 text-lg font-bold text-gray-900">Jumlah Mahasiswa</h5>
                        <p class="text-2xl font-bold text-gray-800">{{ $mahasiswa }}</p>
                    </div>

                    {{-- Total Transaksi --}}
                    <div class="w-full max-w-sm p-4 bg-white border-l-4 border-blue-800 rounded-lg shadow-sm text-center">
                        <h5 class="mb-2 text-lg font-bold text-gray-900">Jumlah Transaksi</h5>
                        <p class="text-2xl font-bold text-gray-800">{{ $pembayaran }}</p>
                    </div>

                    {{-- Total Admin --}}
                    <div class="w-full max-w-sm p-4 bg-white border-l-4 border-indigo-900 rounded-lg shadow-sm text-center">
                        <h5 class="mb-2 text-lg font-bold text-gray-900">Jumlah Admin Terdaftar</h5>
                        <p class="text-2xl font-bold text-gray-800">{{ $total_admin }}</p>
                    </div>

                    {{-- Total Nominal --}}
                    <div class="w-full max-w-sm p-4 bg-white border-l-4 border-indigo-900 rounded-lg shadow-sm text-center">
                        <h5 class="mb-2 text-lg font-bold text-gray-900">Nominal Total</h5>
                        <p class="text-2xl font-bold text-gray-800">Rp. {{ $total }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
