<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jadwal Pengantaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('kurir.jadwal.update', $jadwal->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Wajib untuk Update --}}

                    {{-- Info Barang (Read Only) --}}
                    <div class="mb-4 bg-gray-100 p-4 rounded">
                        <p class="font-bold">Barang: {{ $jadwal->donasi->nama_barang }}</p>
                        <p class="text-sm">Tujuan: {{ $jadwal->donasi->pengajuan ? $jadwal->donasi->pengajuan->user->name : 'Gudang/Posko' }}</p>
                    </div>

                    {{-- TANGGAL --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tanggal Jemput/Antar</label>
                        <input type="date" name="tanggal" 
                               value="{{ old('tanggal', $jadwal->tanggal_pengambilan) }}" 
                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                    </div>

                    {{-- ESTIMASI WAKTU --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Estimasi Waktu (Jam)</label>
                        <input type="text" name="estimasi_waktu" 
                               value="{{ old('estimasi_waktu', $jadwal->estimasi_waktu) }}" 
                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                               placeholder="Contoh: 14:00 WIB">
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Status Pengantaran</label>
                        <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                            <option value="waiting" {{ $jadwal->status == 'waiting' ? 'selected' : '' }}>Waiting (Menunggu)</option>
                            <option value="dijemput" {{ $jadwal->status == 'dijemput' ? 'selected' : '' }}>Dijemput (Picked Up)</option>
                            <option value="on_the_way" {{ $jadwal->status == 'on_the_way' ? 'selected' : '' }}>On The Way (Di Jalan)</option>
                            <option value="delivered" {{ $jadwal->status == 'delivered' ? 'selected' : '' }}>Delivered (Sampai)</option>
                            <option value="failed" {{ $jadwal->status == 'failed' ? 'selected' : '' }}>Failed (Gagal)</option>
                        </select>
                    </div>

                    {{-- CATATAN --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Catatan</label>
                        <textarea name="catatan" rows="3" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">{{ old('catatan', $jadwal->catatan) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('kurir.jadwal.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>