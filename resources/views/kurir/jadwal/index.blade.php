<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Kurir') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-blue-600">Tugas Pengantaran Tersedia (Pool)</h3>
                    <p class="mb-4 text-sm text-gray-600">Donasi ini sudah disetujui Admin dan menunggu Kurir.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($tugasTersedia as $tugas)
                        <div class="border rounded-lg p-4 shadow hover:shadow-md transition">
                            <h4 class="font-bold text-lg">{{ $tugas->donasi->nama_barang }}</h4>
                            <div class="mt-2 text-sm text-gray-600">
                                <p><strong>Dari (Donatur):</strong> {{ $tugas->donasi->user->name }}</p>
                                <p><strong>Ke (Penerima):</strong> {{ $tugas->user->name }}</p>
                                <p><strong>Lokasi:</strong> {{ $tugas->donasi->alamat_jemput ?? 'Sesuai Profil Donatur' }}</p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('kurir.tugas.create', ['pengajuan_id' => $tugas->id]) }}" 
                                   class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Ambil Tugas Ini
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-4 text-gray-500">Tidak ada tugas pengantaran saat ini.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-green-600">Jadwal Pengantaran Saya</h3>
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Jemput</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estimasi Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($jadwalSaya as $jadwal)
                            <tr>
                                <td class="px-6 py-4">{{ $jadwal->donasi->nama_barang }}</td>
                                <td class="px-6 py-4">{{ $jadwal->tanggal_pengiriman }}</td>
                                <td class="px-6 py-4">{{ $jadwal->estimasi_waktu }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ $jadwal->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($jadwal->status != 'Selesai')
                                    <form action="{{ route('kurir.jadwal.update', $jadwal->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="Selesai">
                                        <button type="submit" class="text-green-600 hover:text-green-900 font-bold">Tandai Selesai</button>
                                    </form>
                                    @else
                                    <span class="text-gray-400">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="px-6 py-4 text-center">Anda belum mengambil jadwal.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>