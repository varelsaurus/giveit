<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kebutuhan Logistik (Ayo Bantu!)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($daftarKebutuhan as $item)
                <div class="bg-white overflow-hidden shadow-lg rounded-lg border-l-4 border-red-500">
                    <div class="p-6">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-xl mb-2 text-gray-800">{{ $item->jenis_pakaian }}</h3> <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                Butuh: {{ $item->jumlah }} pcs
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-4 mt-2">
                            "{{ $item->deskripsi }}"
                        </p>
                        
                        <div class="text-sm text-gray-500 mb-4">
                            <p><strong>Penerima:</strong> {{ $item->user->name }}</p>
                            <p class="text-xs">Diposting: {{ $item->created_at->diffForHumans() }}</p>
                        </div>

                        <a href="{{ route('donatur.donasi.create', $item->id) }}" 
                           class="block w-full text-center bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition transform hover:scale-105">
                            ❤️ Saya Mau Bantu Ini
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-10">
                    <p class="text-gray-500">Alhamdulillah, saat ini belum ada permintaan bantuan mendesak.</p>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>