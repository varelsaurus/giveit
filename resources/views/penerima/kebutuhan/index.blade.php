<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kebutuhan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Success/Error --}}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Header & Tombol Action --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Daftar Permintaan Bantuan</h3>
                    
                    <div class="flex space-x-2">
                         <a href="{{ route('dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm shadow">
                            &larr; Dashboard
                        </a>
                        
                        <a href="{{ route('penerima.kebutuhan.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                            + Posting Kebutuhan
                        </a>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi/Alasan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- PERBAIKAN: Gunakan $kebutuhans (Jamak) sesuai Controller --}}
                            @forelse($kebutuhans as $item)
                            <tr>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $item->jenis_pakaian }}</td>
                                <td class="px-6 py-4">{{ $item->jumlah }} Pcs</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($item->deskripsi, 50) }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        // Sesuaikan value case dengan Enum di Database Anda (biasanya lowercase)
                                        $statusClass = match($item->status) {
                                            'belum_terpenuhi' => 'bg-red-100 text-red-800',
                                            'terpenuhi' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        
                                        // Format tampilan teks (Hilangkan underscore & Kapitalisasi)
                                        $statusLabel = ucfirst(str_replace('_', ' ', $item->status));
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    {{-- Cek status (lowercase) --}}
                                    @if($item->status == 'belum_terpenuhi')
                                        <a href="{{ route('penerima.kebutuhan.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                        
                                        <form action="{{ route('penerima.kebutuhan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus permintaan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 italic">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Anda belum memposting kebutuhan apapun.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>