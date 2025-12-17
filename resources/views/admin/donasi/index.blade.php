<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Data Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- HEADER & TOMBOL BACK KE USER --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold">Semua Donasi Masuk</h3>
                    
                    <a href="{{ route('admin.user.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-sm transition duration-150 ease-in-out">
                        &larr; Kembali ke User
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Donatur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($donasis as $item)
                            <tr>
                                <td class="px-6 py-4">{{ $item->user->name }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $item->nama_barang }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->jumlah }} Pcs</div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $color = match($item->status) {
                                            'Tersedia' => 'bg-green-100 text-green-800',
                                            'Butuh Kurir' => 'bg-yellow-100 text-yellow-800',
                                            'Proses Pengiriman' => 'bg-blue-100 text-blue-800',
                                            'Selesai' => 'bg-gray-100 text-gray-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('admin.donasi.updateStatus', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold text-sm">
                                        Update Status
                                    </a>

                                    <form action="{{ route('admin.donasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data donasi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada data donasi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>