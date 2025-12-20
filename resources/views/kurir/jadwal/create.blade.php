<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ambil Tugas Pengjemputan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('kurir.jadwal.store') }}" method="POST">
                    @csrf

                    {{-- PILIH DONASI --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Pilih Paket Donasi</label>
                        <select name="donasi_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                            <option value="" disabled selected>-- Pilih Lokasi Jemput --</option>
                            @foreach($donasis as $donasi)
                                <option value="{{ $donasi->id }}">
                                    {{ $donasi->nama_barang }} ({{ $donasi->user->name }} - {{ $donasi->user->alamat ?? 'Alamat tidak ada' }})
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('donasi_id')" class="mt-2" />
                    </div>

                    {{-- TANGGAL PENGAMBILAN --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Rencana Tanggal Jemput</label>
                        <input type="date" name="tanggal" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" required>
                        <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                    </div>

                    {{-- CATATAN --}}
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Catatan (Opsional)</label>
                        <textarea name="catatan" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full" placeholder="Contoh: Jemput jam 2 siang"></textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('kurir.jadwal.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Batal
                        </a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Ambil Tugas
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>