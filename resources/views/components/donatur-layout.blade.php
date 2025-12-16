<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Donatur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">{{ $header ?? 'Kelola Donasi' }}</h3>
                    
                    {{-- Navigasi Donatur --}}
                    <div class="mb-6 flex space-x-4 border-b pb-2">
                        <a href="{{ route('donatur.donasi.index') }}" class="text-blue-600 hover:text-blue-800">Daftar Donasi</a>
                        <a href="{{ route('donatur.donasi.create') }}" class="text-green-600 hover:text-green-800">Unggah Donasi Baru</a>
                        {{-- Tambahkan navigasi lain di sini --}}
                    </div>
                    
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>