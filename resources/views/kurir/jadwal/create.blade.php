<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfirmasi Ambil Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Detail Pengantaran</h3>
                    <div class="mb-4 bg-gray-50 p-4 rounded">
                        <p><strong>Barang:</strong> {{ $pengajuan->donasi->nama_barang }}</p>
                        <p><strong>Rute:</strong> {{ $pengajuan->donasi->user->name }} &#8594; {{ $pengajuan->user->name }}</p>
                    </div>

                    <form action="{{ route('kurir.jadwal.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="pengajuan_id" value="{{ $pengajuan->id }}">

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Jemput</label>
                            <input type="date" name="tanggal_pengiriman" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Estimasi Waktu (Jam)</label>
                            <input type="text" name="estimasi_waktu" placeholder="Contoh: 10:00 - 12:00 WIB" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Jadwal & Ambil Tugas
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>