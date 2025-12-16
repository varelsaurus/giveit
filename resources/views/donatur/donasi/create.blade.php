<x-donatur-layout>
    <x-slot name="header">Unggah Donasi Baru</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                {{-- HAPUS enctype="multipart/form-data" --}}
                <form method="POST" action="{{ route('donatur.donasi.store') }}" class="space-y-6">
                    @csrf

                    {{-- Jenis Pakaian --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Pakaian</label>
                        <input type="text" name="jenis_pakaian" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
                    </div>
                    
                    {{-- Jumlah --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jumlah (Pcs/Stel)</label>
                        <input type="number" name="jumlah" required min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2"></textarea>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('donatur.donasi.index') }}" class="text-gray-600">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-donatur-layout>