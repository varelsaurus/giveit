{{-- File: resources/views/kurir/jadwal/index.blade.php --}}

<x-kurir-layout> {{-- <== PASTIKAN TAG PEMBUKA INI ADA --}}
    <x-slot name="header">Daftar Jadwal Pengantaran</x-slot>

    {{-- Konten Utama --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded-md overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-left">ID</th>
                    <th class="py-2 px-4 border-b text-left">Barang & Waktu</th>
                    <th class="py-2 px-4 border-b text-left">Rute</th>
                    <th class="py-2 px-4 border-b text-center">Status</th>
                    <th class="py-2 px-4 border-b text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($jadwals as $jadwal)
                    {{-- Baris Data Jadwal (seperti kode sebelumnya) --}}
                    <tr>
                        <td>{{ $jadwal->id }}</td>
                        {{-- ... kolom lainnya ... --}}
                    </tr>
                @empty
                    {{-- Tampilan Kosong --}}
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="font-medium">Belum ada tugas pengiriman.</p>
                                <p class="text-sm mt-1">Tugas akan muncul setelah Admin menyetujui pengajuan donasi.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-kurir-layout> {{-- <== PASTIKAN TAG PENUTUP INI ADA --}}