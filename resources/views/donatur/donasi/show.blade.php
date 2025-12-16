{{-- resources/views/donatur/donasi/show.blade.php --}}

<x-donatur-layout>
    <x-slot name="header">Detail Donasi #{{ $donasi->id }}</x-slot>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informasi Donasi
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Detail lengkap tentang barang yang Anda donasikan.
            </p>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Jenis Pakaian
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $donasi->jenis_pakaian }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Jumlah
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $donasi->jumlah }} unit
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Status
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                         <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if ($donasi->status == 'Tersedia') bg-green-200 text-green-800
                            @elseif ($donasi->status == 'Diajukan') bg-yellow-200 text-yellow-800
                            @else bg-gray-200 text-gray-800 @endif">
                            {{ $donasi->status }}
                        </span>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Deskripsi
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $donasi->deskripsi ?? '-' }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Tanggal Dibuat
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $donasi->created_at->format('d M Y H:i') }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="mt-6 flex justify-between items-center">
        <a href="{{ route('donatur.donasi.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center">
            &larr; Kembali ke Daftar Donasi
        </a>

        @if ($donasi->status == 'Tersedia')
            <a href="{{ route('donatur.donasi.edit', $donasi) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md shadow-md">
                Edit Donasi
            </a>
        @else
             <span class="text-sm text-gray-500 italic">Donasi tidak dapat diubah karena sudah dalam proses penyaluran.</span>
        @endif
    </div>
</x-donatur-layout>