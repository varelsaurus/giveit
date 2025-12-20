<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- JUDUL --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Berita</label>
                        <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    {{-- KONTEN --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Isi Berita</label>
                        <textarea name="konten" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>{{ old('konten', $berita->konten) }}</textarea>
                    </div>

                    {{-- TOMBOL --}}
                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.berita.index') }}" class="text-gray-500 mr-4">Batal</a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Update Berita
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>