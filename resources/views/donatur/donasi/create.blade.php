<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Formulir Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-6 bg-blue-50 p-4 rounded border border-blue-200">
                        <h3 class="font-bold text-blue-800">Anda akan membantu:</h3>
                        <p><strong>Permintaan:</strong> {{ $kebutuhan->jenis_pakaian }} ({{ $kebutuhan->jumlah }} pcs)</p>
                        <p><strong>Penerima:</strong> {{ $kebutuhan->user->name }}</p>
                    </div>

                    <form action="{{ route('donatur.donasi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kebutuhan_id" value="{{ $kebutuhan->id }}">
                        
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Barang yang Anda Donasikan</label>
                            <input type="text" name="nama_barang" value="{{ $kebutuhan->jenis_pakaian }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah yang Anda Kirim</label>
                            <input type="number" name="jumlah" placeholder="Misal: 5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <p class="text-xs text-gray-500 mt-1">Anda tidak harus memenuhi semua permintaan, semampunya saja.</p>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Pesan / Deskripsi Barang</label>
                            <textarea name="deskripsi" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="3" required placeholder="Contoh: Barang bekas layak pakai, sudah dicuci bersih."></textarea>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Kirim Donasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>