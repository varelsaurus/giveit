{{-- resources/views/kurir/jadwal/show.blade.php --}}

<x-kurir-layout>
    <x-slot name="header">Detail Jadwal Pengantaran #{{ $jadwal->id }}</x-slot>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 bg-indigo-50">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                Informasi Tugas Pengiriman
            </h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Status Pengiriman
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                         <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if ($jadwal->status == 'Menunggu Ambil') bg-yellow-200 text-yellow-800
                            @elseif ($jadwal->status == 'Dalam Perjalanan') bg-blue-200 text-blue-800
                            @else bg-green-200 text-green-800 @endif">
                            {{ $jadwal->status }}
                        </span>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Tanggal & Waktu Ambil
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ \Carbon\Carbon::parse($jadwal->tanggal_waktu_ambil)->translatedFormat('l, d F Y H:i') }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Alamat Ambil (Donatur)
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $jadwal->alamat_ambil }}
                    </dd>
                </div>
                 <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Tanggal & Waktu Kirim
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ \Carbon\Carbon::parse($jadwal->tanggal_waktu_kirim)->translatedFormat('l, d F Y H:i') }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        Alamat Kirim (Penerima)
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $jadwal->alamat_kirim }}
                    </dd>
                </div>
                {{-- Detail Donasi/Pengajuan bisa ditambahkan di sini melalui relasi --}}
            </dl>
        </div>
    </div>

    <div class="mt-6 flex justify-between items-center">
        <a href="{{ route('kurir.jadwal.index') }}" class="text-gray-600 hover:text-gray-800 flex items-center">
            &larr; Kembali ke Daftar Jadwal
        </a>

        <a href="{{ route('kurir.jadwal.edit', $jadwal) }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md shadow-md">
            Update Status
        </a>
    </div>
</x-kurir-layout>