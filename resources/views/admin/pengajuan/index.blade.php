{{-- File: resources/views/admin/pengajuan/index.blade.php --}}

<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Pengajuan Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left">No</th>
                                    <th class="px-4 py-2 text-left">Penerima</th>
                                    <th class="px-4 py-2 text-left">Barang Donasi</th>
                                    <th class="px-4 py-2 text-left">Lokasi Donatur</th>
                                    <th class="px-4 py-2 text-left">Tentukan Jadwal & Kurir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengajuans as $index => $pengajuan)
                                    <tr class="border-b hover:bg-gray-50 align-top">
                                        <td class="px-4 py-4">{{ $index + 1 }}</td>
                                        
                                        {{-- Info Penerima --}}
                                        <td class="px-4 py-4">
                                            <div class="font-bold">{{ $pengajuan->penerima->name ?? 'User Terhapus' }}</div>
                                            <div class="text-xs text-gray-500">
                                                {{ $pengajuan->created_at->format('d M Y') }}
                                            </div>
                                        </td>

                                        {{-- Info Barang --}}
                                        <td class="px-4 py-4">
                                            <div class="text-sm font-semibold">{{ $pengajuan->donasi->jenis_pakaian }}</div>
                                            <div class="text-xs text-gray-500">
                                                Jml: {{ $pengajuan->donasi->jumlah }} <br>
                                                Ket: {{ Str::limit($pengajuan->donasi->deskripsi, 30) }}
                                            </div>
                                        </td>

                                        {{-- Info Lokasi (Donatur) --}}
                                        <td class="px-4 py-4 text-sm">
                                            <span class="font-semibold">Donatur:</span> {{ $pengajuan->donasi->user->name ?? '-' }} <br>
                                            {{-- Jika User punya kolom alamat, tampilkan disini --}}
                                            {{-- <span class="text-xs text-gray-500">{{ $pengajuan->donasi->user->alamat }}</span> --}}
                                        </td>

                                        {{-- Form Action (Approve) --}}
                                        <td class="px-4 py-4 bg-blue-50 rounded-lg">
                                            <form action="{{ route('admin.pengajuan.approve', $pengajuan->id) }}" method="POST" onsubmit="return confirm('Setujui pengajuan ini dan tugaskan kurir?');">
                                                @csrf
                                                
                                                <div class="grid gap-2">
                                                    {{-- Pilih Kurir --}}
                                                    <div>
                                                        <label class="text-xs font-bold text-gray-600">Pilih Kurir:</label>
                                                        <select name="kurir_id" required class="w-full text-sm border-gray-300 rounded p-1">
                                                            <option value="">-- Pilih --</option>
                                                            @foreach($kurirs as $kurir)
                                                                <option value="{{ $kurir->id }}">{{ $kurir->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    {{-- Pilih Tanggal Jemput --}}
                                                    <div>
                                                        <label class="text-xs font-bold text-gray-600">Tgl Jemput:</label>
                                                        <input type="datetime-local" name="tanggal_ambil" required class="w-full text-sm border-gray-300 rounded p-1">
                                                    </div>

                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded shadow mt-1">
                                                        ✅ Setujui & Tugaskan
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-gray-500">
                                            Tidak ada pengajuan donasi baru yang menunggu persetujuan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>