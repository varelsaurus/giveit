<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Status Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4">Edit Status: {{ $donasi->nama_barang }}</h3>

                <form action="{{ route('admin.donasi.updateStatusProcess', $donasi->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Status Saat Ini</label>
                        <select name="status" class="w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="Tersedia" {{ $donasi->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Butuh Kurir" {{ $donasi->status == 'Butuh Kurir' ? 'selected' : '' }}>Butuh Kurir</option>
                            <option value="Proses Pengiriman" {{ $donasi->status == 'Proses Pengiriman' ? 'selected' : '' }}>Proses Pengiriman</option>
                            <option value="Selesai" {{ $donasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">*Ubah ke "Butuh Kurir" agar muncul di dashboard kurir.</p>
                    </div>

                    <div class="flex justify-end items-center space-x-3">
                        <a href="{{ route('admin.donasi.index') }}" class="text-gray-600 hover:text-gray-900 font-bold">
                            &larr; Batal
                        </a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>