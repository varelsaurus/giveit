{{-- resources/views/admin/donasi/report.blade.php --}}

<x-admin-layout>
    <x-slot name="header">Laporan Histori Donasi</x-slot>

    <div class="bg-gray-50 border p-6 rounded-lg">
        <h4 class="text-2xl font-bold mb-4 text-green-700">Ringkasan Statistik Donasi</h4>

        <div class="grid grid-cols-3 gap-4 text-center">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-3xl font-bold text-indigo-600">{{ $total_donasi_selesai ?? '0' }}</p>
                <p class="text-sm text-gray-500">Donasi Selesai (Tersalurkan)</p>
            </div>
             <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-3xl font-bold text-yellow-600">{{ $total_donasi_proses ?? '0' }}</p>
                <p class="text-sm text-gray-500">Donasi Dalam Proses</p>
            </div>
             <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-3xl font-bold text-gray-600">{{ $total_semua_donasi ?? '0' }}</p>
                <p class="text-sm text-gray-500">Total Semua Donasi</p>
            </div>
        </div>

        <div class="mt-8">
            <h5 class="text-xl font-semibold mb-3">Histori Donasi Detail</h5>
            {{-- Placeholder untuk tabel yang berisi semua data donasi, pengajuan, dan jadwal --}}
            <p class="text-gray-500 italic">Data histori donasi lengkap (yang mencakup Donasi, Penerima, Kurir, dan Status Akhir) akan ditampilkan di sini. Logika pengambilan data perlu diimplementasikan di Admin/DonasiManagementController@generateReport.</p>
        </div>

    </div>

</x-admin-layout>