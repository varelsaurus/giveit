<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Donasi Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- PERHATIKAN: Route ke STORE (Simpan Baru), bukan Update --}}
                <form action="{{ route('donasi.store') }}" method="POST">
                    @csrf

                    {{-- Input Hidden ID Kebutuhan (Jika ada) --}}
                    <input type="hidden" name="kebutuhan_id" value="{{ $kebutuhan?->id }}">

                    {{-- NAMA BARANG --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nama Barang</label>
                        {{-- 
                            LOGIKA:
                            1. Cek old input (jika validasi gagal).
                            2. Jika kosong, cek apakah ada $kebutuhan? Kalau ada ambil jenis_pakaian.
                            3. JANGAN pakai $donasi->nama_barang di sini.
                        --}}
                        <input type="text" name="nama_barang" 
                               value="{{ old('nama_barang', $kebutuhan?->jenis_pakaian) }}" 
                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                               placeholder="Contoh: Baju Kemeja Bekas"
                               required>
                        <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                    </div>

                    {{-- JUMLAH --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Jumlah</label>
                        <input type="number" name="jumlah" 
                               value="{{ old('jumlah', $kebutuhan?->jumlah) }}" 
                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                               required>
                        <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Deskripsi Barang</label>
                        <textarea name="deskripsi" rows="3" 
                                  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                  placeholder="Jelaskan kondisi barang..."
                                  required>{{ old('deskripsi') }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('donasi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Simpan Donasi
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>