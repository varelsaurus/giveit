<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- PERBAIKAN 1: Form Action ke 'donasi.update' --}}
                <form action="{{ route('donasi.update', $donasi->id) }}" method="POST">
                    @csrf
                    @method('PUT') 

                    {{-- Nama Barang --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nama Barang</label>
                        <input type="text" name="nama_barang" 
                               value="{{ old('nama_barang', $donasi->nama_barang) }}" 
                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                               required>
                        <x-input-error :messages="$errors->get('nama_barang')" class="mt-2" />
                    </div>

                    {{-- Jumlah --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Jumlah</label>
                        <input type="number" name="jumlah" 
                               value="{{ old('jumlah', $donasi->jumlah) }}" 
                               class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                               required>
                        <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" 
                                  class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                                  required>{{ old('deskripsi', $donasi->deskripsi) }}</textarea>
                        <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-2">
                        {{-- PERBAIKAN 2: Tombol Batal arahkan ke 'donasi.index' --}}
                        <a href="{{ route('donasi.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
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