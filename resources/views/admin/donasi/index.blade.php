{{-- resources/views/admin/donasi/index.blade.php --}}

<x-admin-layout>
    <x-slot name="header">Manajemen Semua Donasi</x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Donatur</th>
                    <th class="py-2 px-4 border-b">Jenis Pakaian</th>
                    <th class="py-2 px-4 border-b">Jumlah</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($donasis as $donasi)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ $donasi->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $donasi->user->name ?? 'Unknown' }}</td>
                        <td class="py-2 px-4 border-b">{{ $donasi->jenis_pakaian }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $donasi->jumlah }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if ($donasi->status == 'Tersedia') bg-green-200 text-green-800
                                @elseif ($donasi->status == 'Diajukan') bg-yellow-200 text-yellow-800
                                @else bg-gray-200 text-gray-800 @endif">
                                {{ $donasi->status }}
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b text-center space-x-2">
                            <a href="{{ route('admin.donasi.updateStatus', $donasi) }}" class="text-blue-600 hover:text-blue-800 text-sm">Update Status</a>
                            
                            <form action="{{ route('admin.donasi.destroy', $donasi) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus donasi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">
                            Tidak ada data donasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin-layout>