<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kebutuhan Penerima') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- MENU NAVIGASI ADMIN --}}
                <div class="flex flex-wrap gap-6 mb-8 border-b pb-4">
                    <a href="{{ route('admin.user.index') }}" class="text-gray-500 hover:text-blue-600 font-medium">Manage User</a>
                    <a href="{{ route('admin.donasi.index') }}" class="text-gray-500 hover:text-blue-600 font-medium">Manage Donasi</a>
                    <a href="{{ route('admin.pengajuan.index') }}" class="text-gray-500 hover:text-blue-600 font-medium">Persetujuan Pengajuan</a>
                    
                    {{-- MENU AKTIF --}}
                    <a href="{{ route('admin.kebutuhan.index') }}" class="text-blue-600 font-bold border-b-2 border-blue-600">Daftar Kebutuhan</a>
                    
                    <a href="{{ route('admin.report.index') }}" class="text-gray-500 hover:text-blue-600 font-medium">Report</a>
                    <a href="{{ route('admin.berita.index') }}" class="text-gray-500 hover:text-blue-600 font-medium">Manage Berita</a>
                </div>

                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-700">List Permintaan Barang (Wishlist)</h3>
                    <p class="text-sm text-gray-500">Daftar barang yang dibutuhkan oleh penerima manfaat namun belum tersedia.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-100">
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
                                <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $item->jenis_pakaian }}</td>
                                <td class="px-6 py-4 text-sm">{{ $item->jumlah }} Pcs</td>
                                <td class="px-6 py-4 text-sm italic text-gray-600">{{ Str::limit($item->deskripsi, 50) }}</td>
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
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data kebutuhan yang masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>