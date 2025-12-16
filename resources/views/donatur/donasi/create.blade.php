{{-- resources/views/donatur/donasi/create.blade.php --}}

<x-donatur-layout>
    <x-slot name="header">Unggah Donasi Baru</x-slot>

    <form method="POST" action="{{ route('donatur.donasi.store') }}" class="space-y-6">
        @csrf

        {{-- Jenis Pakaian --}}
        <div>
            <label for="jenis_pakaian" class="block text-sm font-medium text-gray-700">Jenis Pakaian</label>
            <input type="text" name="jenis_pakaian" id="jenis_pakaian" required 
                   value="{{ old('jenis_pakaian') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('jenis_pakaian')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Jumlah Pakaian --}}
        <div>
            <label for="jumlah_pakaian" class="block text-sm font-medium text-gray-700">Jumlah Pakaian (Satuan)</label>
            <input type="number" name="jumlah_pakaian" id="jumlah_pakaian" required min="1"
                   value="{{ old('jumlah_pakaian') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('jumlah_pakaian')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi/Keterangan</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" 
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('donatur.donasi.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md shadow-md">
                Unggah Donasi
            </button>
        </div>
    </form>
</x-donatur-layout>