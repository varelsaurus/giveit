<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header ?? 'Dashboard Kurir' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 flex space-x-4 border-b pb-2">
                        <a href="{{ route('kurir.jadwal.index') }}" class="text-blue-600 hover:text-blue-800">Daftar Jadwal Saya</a>
                    </div>
                    
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>