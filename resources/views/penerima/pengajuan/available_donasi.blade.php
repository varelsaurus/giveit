{{-- resources/views/penerima/pengajuan/available_donasi.blade.php --}}

<x-penerima-layout>
    <x-slot name="header">Donasi Pakaian Tersedia</x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <h4 class="text-xl font-semibold mb-4 text-indigo-800">Pilih Donasi yang Sesuai dengan Kebutuhan Anda</h4>
    
    @if (!$kebutuhan)
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
            <p class="font-bold">Perhatian!</p>
            <p>Untuk mempermudah proses penyaluran, Anda disarankan <a href="{{ route('penerima.kebutuhan.create') }}" class="font-semibold underline">mengunggah daftar kebutuhan pakaian</a> terlebih dahulu.</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($availableDonations as $donasi)
            <div class="bg-white border border-gray-200 rounded-lg shadow-md p-5 flex flex-col justify-between">
                <div>
                    <h5 class="text-xl font-bold mb-2 text-gray-800">{{ $donasi->jenis_pakaian }}</h5>
                    <p class="text-sm text-gray-600 mb-3">
                        **Jumlah:** <span class="font-semibold">{{ $donasi->jumlah }} unit</span>
                    </p>
                    <p class="text-sm text-gray-700 italic">
                        {{ Str::limit($donasi->deskripsi, 100) ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>

                <div class="mt-4">
                    {{-- Form Pengajuan --}}
                    <form action="{{ route('penerima.pengajuan.store', $donasi) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out">
                            Ajukan Permintaan
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full p-6 text-center border-2 border-dashed border-gray-300 rounded-lg">
                <p class="text-lg text-gray-600">Saat ini belum ada donasi pakaian yang tersedia.</p>
            </div>
        @endforelse
    </div>
</x-penerima-layout>