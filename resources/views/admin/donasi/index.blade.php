<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Donasi') }}
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

                    {{-- 2. Manage Donasi (AKTIF) --}}
                    <a href="{{ route('admin.donasi.index') }}" class="flex items-center text-blue-600 font-bold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Manage Donasi
                    </a>

                    {{-- 3. Persetujuan Pengajuan --}}
                    <a href="{{ route('admin.pengajuan.index') }}" class="flex items-center text-gray-500 hover:text-blue-600">
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

                {{-- KONTEN UTAMA MANAGE DONASI --}}
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-700">Daftar Semua Donasi</h3>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Donatur</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($donasis as $donasi)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $donasi->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $donasi->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $donasi->nama_barang }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $donasi->jumlah }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $donasi->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    {{-- Badge Status --}}
                                    @php
                                        $statusColor = match($donasi->status) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'verified' => 'bg-blue-100 text-blue-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($donasi->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium">
                                    {{-- Tombol Verifikasi/Update Status --}}
                                    <a href="{{ route('admin.donasi.updateStatus', $donasi->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2 font-bold">Update Status</a>
                                    
                                    <form action="{{ route('admin.donasi.destroy', $donasi->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus donasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data donasi masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>