<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Jadwal Pengantaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-4">Edit Jadwal</h3>

                <form action="{{ route('kurir.jadwal.update', $jadwal->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal & Jam Pengiriman</label>
                        <input type="datetime-local" name="tanggal_pengiriman" value="{{ $jadwal->tanggal_pengiriman }}" class="w-full border-gray-300 rounded shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Estimasi Waktu</label>
                        <input type="text" name="estimasi_waktu" value="{{ $jadwal->estimasi_waktu }}" class="w-full border-gray-300 rounded shadow-sm" required>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('kurir.jadwal.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Jadwal</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>