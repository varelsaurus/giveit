{{-- resources/views/penerima/pengajuan/index.blade.php --}}

<x-penerima-layout>
    <x-slot name="header">Riwayat Pengajuan Donasi Saya</x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID Pengajuan</th>
                    <th class="py-2 px-4 border-b">Donasi (Jenis Pakaian)</th>
                    <th class="py-2 px-4 border-b">Tgl. Pengajuan</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengajuans as $pengajuan)
                    <tr>
                        <td class="py-2 px-4 border-b text-center">{{ $pengajuan->id }}</td>
                        <td class="py-2 px-4 border-b">{{ $pengajuan->donasi->jenis_pakaian ?? 'Donasi Dihapus' }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $pengajuan->created_at->format('d M Y') }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if ($pengajuan->status == 'Menunggu') bg-yellow-200 text-yellow-800
                                @elseif ($pengajuan->status == 'Diproses') bg-blue-200 text-blue-800
                                @elseif ($pengajuan->status == 'Selesai') bg-green-200 text-green-800
                                @else bg-red-200 text-red-800 @endif">
                                {{ $pengajuan->status }}
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b text-center space-x-2">
                            @if ($pengajuan->status == 'Menunggu')
                                {{-- 4. Delete pengajuan (Batalkan) --}}
                                <form action="{{ route('penerima.pengajuan.destroy', $pengajuan) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Batalkan</button>
                                </form>
                            @else
                                <span class="text-xs text-gray-500 italic">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4 text-center text-gray-500">
                            Anda belum pernah mengajukan permintaan donasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-penerima-layout>