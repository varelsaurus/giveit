{{-- resources/views/penerima/kebutuhan/index.blade.php --}}

<x-penerima-layout>
    <x-slot name="header">Kebutuhan Pakaian Saya</x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if ($kebutuhan)
        {{-- TAMPILKAN KEBUTUHAN YANG SUDAH ADA --}}
        <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
            <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Kebutuhan Pakaian Aktif
                </h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Jenis Pakaian
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $kebutuhan->jenis_pakaian }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Jumlah Total Dibutuhkan
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $kebutuhan->jumlah_total }} unit
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            Deskripsi Kebutuhan
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $kebutuhan->deskripsi ?? '-' }}
                        </dd>
                    </div>
                    <div class="px-4 py-5 sm:px-6 flex justify-end space-x-2 bg-gray-50">
                        <a href="{{ route('penerima.kebutuhan.edit', $kebutuhan) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm">
                            Update Kebutuhan
                        </a>
                        <form action="{{ route('penerima.kebutuhan.destroy', $kebutuhan) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua daftar kebutuhan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                Hapus Kebutuhan
                            </button>
                        </form>
                    </div>
                </dl>
            </div>
        </div>
    @else
        {{-- JIKA BELUM ADA KEBUTUHAN --}}
        <div class="p-6 text-center border-2 border-dashed border-gray-300 rounded-lg">
            <p class="text-lg text-gray-600 mb-4">Anda belum memiliki daftar kebutuhan pakaian yang terdaftar.</p>
            <a href="{{ route('penerima.kebutuhan.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md shadow-md">
                + Buat Kebutuhan Baru
            </a>
        </div>
    @endif
</x-penerima-layout>