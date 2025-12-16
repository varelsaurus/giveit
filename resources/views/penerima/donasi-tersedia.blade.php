<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Donasi Tersedia') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($donasi as $item)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col h-full">
                    <div class="p-6 flex-grow">
                        <h3 class="font-bold text-xl mb-2">{{ $item->nama_barang }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($item->deskripsi, 100) }}</p>
                        <div class="text-sm text-gray-500">
                            <p>Donatur: {{ $item->user->name }}</p>
                            <p>Lokasi: {{ $item->alamat_jemput ?? 'Kota Bandung' }}</p>
                        </div>
                    </div>
                    <div class="p-6 bg-gray-50 border-t">
                        <form action="{{ route('penerima.pengajuan.store', $item->id) }}" method="POST">
                            @csrf
                            <input type="text" name="alasan" placeholder="Alasan membutuhkan..." class="w-full text-sm border-gray-300 rounded-md shadow-sm mb-2" required>
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Ajukan Permintaan
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-10 bg-white rounded-lg shadow">
                    <p class="text-gray-500 text-lg">Belum ada donasi yang tersedia saat ini.</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>