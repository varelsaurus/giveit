<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Arsip Laporan Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-bold">Riwayat Laporan</h3>
                    {{-- Tombol CREATE REPORT --}}
                    <a href="{{ route('admin.report.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Buat Laporan Baru
                    </a>
                </div>

                <table class="min-w-full border mt-4">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Judul</th>
                            <th class="border px-4 py-2">Periode</th>
                            <th class="border px-4 py-2">Total Donasi</th>
                            <th class="border px-4 py-2">Dibuat Oleh</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reports as $report)
                        <tr>
                            <td class="border px-4 py-2">
                                {{ $report->judul }} <br>
                                <span class="text-xs text-gray-500">{{ $report->catatan }}</span>
                            </td>
                            <td class="border px-4 py-2">
                                {{ \Carbon\Carbon::parse($report->tanggal_awal)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($report->tanggal_akhir)->format('d M Y') }}
                            </td>
                            <td class="border px-4 py-2 text-center">{{ $report->total_donasi_tercatat }}</td>
                            <td class="border px-4 py-2">{{ $report->user->name }}</td>
                            <td class="border px-4 py-2 text-center">
                                <form action="{{ route('admin.report.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Hapus arsip ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>