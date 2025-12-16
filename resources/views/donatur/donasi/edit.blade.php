{{-- resources/views/donatur/donasi/edit.blade.php --}}

<x-donatur-layout>
    <x-slot name="header">Edit Donasi #{{ $donasi->id }}</x-slot>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Logika untuk mencegah edit jika status bukan 'Tersedia' --}}
    @if ($donasi->status !== 'Tersedia')
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
            <p class="font-bold">Perhatian</p>
            <p>Donasi ini tidak dapat diubah karena statusnya saat ini adalah: **{{ $donasi->status }}**.</p>
        </div>
        <div class="mt-6">
            <a href="{{ route('donatur.donasi.show', $donasi) }}" class="text-gray-600 hover:text-gray-800">
                &larr; Lihat Detail Donasi
            </a>
        </div>
    @else
        {{-- Form Edit --}}
        <form method="POST" action="{{ route('donatur.donasi.update', $donasi) }}" class="space-y-6">
            @csrf
            @method('PATCH') {{-- Menggunakan metode PATCH untuk UPDATE --}}

            {{-- Jenis Pakaian --}}
            <div>
                <label for="jenis_pakaian" class="block text-sm font-medium text-gray-700">Jenis Pakaian</label>
                <input type="text" name="jenis_pakaian" id="jenis_pakaian" required 
                       value="{{ old('jenis_pakaian', $donasi->jenis_pakaian) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                @error('jenis_pakaian')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah Pakaian (Biasanya tidak boleh diubah jika sudah ada pengajuan, tapi kita biarkan dulu) --}}
            <div>
                <label for="jumlah_pakaian" class="block text-sm font-medium text-gray-700">Jumlah Pakaian (Satuan)</label>
                <input type="number" name="jumlah" id="jumlah" required min="1"
                       value="{{ old('jumlah', $donasi->jumlah) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                @error('jumlah')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi/Keterangan</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" 
                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('deskripsi', $donasi->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('donatur.donasi.show', $donasi) }}" class="text-gray-600 hover:text-gray-800">Batal</a>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md shadow-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    @endif
</x-donatur-layout>