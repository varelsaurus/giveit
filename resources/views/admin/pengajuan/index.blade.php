<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Pengajuan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- === MENU NAVIGASI ADMIN === --}}
                <div class="flex flex-wrap gap-6 mb-8 border-b pb-4">
                    {{-- 1. Manage User --}}
                    <a href="{{ route('admin.user.index') }}" class="flex items-center text-gray-500 hover:text-blue-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Manage User
                    </a>

                    {{-- 2. Manage Donasi --}}
                    <a href="{{ route('admin.donasi.index') }}" class="flex items-center text-gray-500 hover:text-blue-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Manage Donasi
                    </a>

                    {{-- 3. Persetujuan Pengajuan (AKTIF) --}}
                    <a href="{{ route('admin.pengajuan.index') }}" class="flex items-center text-blue-600 font-bold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Persetujuan Pengajuan
                    </a>

                    {{-- 4. Report --}}
                    <a href="{{ route('admin.report.index') }}" class="flex items-center text-gray-500 hover:text-blue-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Report
                    </a>

                    {{-- 5. Manage Berita --}}
                    <a href="{{ route('admin.berita.index') }}" class="flex items-center text-gray-500 hover:text-blue-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        Manage Berita
                    </a>
                </div>

                {{-- KONTEN UTAMA PERSETUJUAN --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 border-b pb-2">
                    <h3 class="text-lg font-bold text-indigo-700">Daftar Kebutuhan Penerima (Wishlist)</h3>
                    <p class="text-sm text-gray-500">Daftar barang yang sedang dicari/dibutuhkan oleh penerima (Data "Gamis" kamu ada di sini).</p>
                </div>
            
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Penerima</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Barang Dicari</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($kebutuhans as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $item->user->name ?? 'User Dihapus' }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-800">{{ $item->jenis_pakaian }}</td>
                                <td class="px-6 py-4">{{ $item->jumlah }} Pcs</td>
                                <td class="px-6 py-4 text-sm italic text-gray-600">
                                    {{ Str::limit($item->deskripsi, 50) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($item->status == 'terpenuhi')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Terpenuhi</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Belum Terpenuhi</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    Belum ada data kebutuhan yang masuk.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            </div>
        </div>
    </div>
</x-app-layout>