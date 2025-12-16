<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posting Kebutuhan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('penerima.kebutuhan.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block font-bold mb-2">Barang yang Dibutuhkan</label>
                            <input type="text" name="jenis_pakaian" placeholder="Contoh: Selimut Tebal" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold mb-2">Jumlah (Pcs)</label>
                            <input type="number" name="jumlah" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div class="mb-4">
                            <label class="block font-bold mb-2">Ceritakan Kondisi/Alasan</label>
                            <textarea name="deskripsi" rows="3" class="w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Posting Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>