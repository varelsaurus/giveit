<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Kurir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- PESAN NOTIFIKASI --}}
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

            {{-- TABEL 1: TUGAS TERSEDIA (POOL) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-bold text-blue-800 mb-4">Tugas Pengantaran Tersedia (Pool)</h3>
                <p class="text-sm text-gray-500 mb-4">Daftar barang yang siap dijemput dari Donatur.</p>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lokasi Jemput (Donatur)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tujuan Antar</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tugasTersedia as $donasi)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold">{{ $donasi->user->name }}</div>
                                    <div class="text-xs text-gray-500">Alamat: {{ $donasi->user->alamat ?? 'Bandung' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($donasi->pengajuan)
                                        <div class="text-sm font-bold text-green-700">Ke: {{ $donasi->pengajuan->user->name }}</div>
                                        <div class="text-xs text-gray-500">Penerima Bantuan</div>
                                    @else
                                        <div class="text-sm font-bold text-orange-600">Ke: Gudang / Posko</div>
                                        <div class="text-xs text-gray-500">Stok Logistik</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $donasi->nama_barang }} <br>
                                    <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $donasi->jumlah }} Pcs</span>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- TOMBOL AMBIL (Mengarah ke Form Create) --}}
                                    <a href="{{ route('kurir.jadwal.create', $donasi->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                                        Ambil & Atur Jadwal
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Tidak ada tugas pengantaran saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- TABEL 2: JADWAL SAYA --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-green-800 mb-4">Sedang Saya Antar</h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barang & Tujuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Jemput</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estimasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($tugasSaya as $jadwal)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-bold">{{ $jadwal->donasi->nama_barang }}</div>
                                    <div class="text-xs text-gray-500">
                                        Ke: {{ $jadwal->donasi->pengajuan ? $jadwal->donasi->pengajuan->user->name : 'Gudang/Posko' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Menampilkan Tanggal Pengiriman --}}
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_pengiriman)->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    {{-- Menampilkan Estimasi --}}
                                    {{ $jadwal->estimasi_waktu }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $jadwal->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex flex-col space-y-2">
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('kurir.jadwal.edit', $jadwal->id) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-1 px-3 rounded text-xs">
                                            Edit
                                        </a>

                                        <form action="{{ route('kurir.jadwal.selesaikan', $jadwal->id) }}" method="POST" onsubmit="return confirm('Selesaikan pengantaran ini?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs">
                                                Selesai
                                            </button>
                                        </form>
                                    </div>

                                    <form action="{{ route('kurir.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Batalkan tugas ini? Data akan kembali ke pool.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs w-full">
                                            Batalkan Tugas
                                        </button>
                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Anda belum mengambil jadwal apapun.
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