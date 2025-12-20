<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kebutuhan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('penerima.kebutuhan.update', $kebutuhan->id) }}" method="POST">
                    @csrf
                    
                    @method('PUT') 

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Jenis Pakaian</label>
                        <input type="text" name="jenis_pakaian" value="{{ old('jenis_pakaian', $kebutuhan->jenis_pakaian) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        <x-input-error :messages="$errors->get('jenis_pakaian')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Jumlah</label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', $kebutuhan->jumlah) }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">
                        <x-input-error :messages="$errors->get('jumlah')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Deskripsi</label>
                        <textarea name="deskripsi" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full">{{ old('deskripsi', $kebutuhan->deskripsi) }}</textarea>
                    </div>

                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>