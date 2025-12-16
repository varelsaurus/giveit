{{-- resources/views/penerima/kebutuhan/edit.blade.php --}}

<x-penerima-layout>
    <x-slot name="header">Update Kebutuhan Pakaian</x-slot>

    <form method="POST" action="{{ route('penerima.kebutuhan.update', $kebutuhan) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Jenis Pakaian --}}
        <div>
            <label for="jenis_pakaian" class="block text-sm font-medium text-gray-700">Jenis Pakaian yang Dibutuhkan</label>
            <input type="text" name="jenis_pakaian" id="jenis_pakaian" required 
                   value="{{ old('jenis_pakaian', $kebutuhan->jenis_pakaian) }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('jenis_pakaian')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Jumlah Total Dibutuhkan --}}
        <div>
            <label for="jumlah_total" class="block text-sm font-medium text-gray-700">Jumlah Total Dibutuhkan (Unit)</label>
            <input type="number" name="jumlah_total" id="jumlah_total" required min="1"
                   value="{{ old('jumlah_total', $kebutuhan->jumlah_total) }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('jumlah_total')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Detail Kebutuhan (Ukuran, Warna, Kondisi)</label>
            <textarea name="deskripsi" id="deskripsi" rows="4" 
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('deskripsi', $kebutuhan->deskripsi) }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('penerima.kebutuhan.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md shadow-md">
                Simpan Perubahan
            </button>
        </div>
    </form>
</x-penerima-layout>