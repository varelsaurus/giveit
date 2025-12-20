<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Laporan Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                
                <form action="{{ route('admin.report.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Judul Laporan</label>
                        <input type="text" name="judul" class="w-full border-gray-300 rounded" placeholder="Contoh: Laporan Keuangan Q1" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" class="w-full border-gray-300 rounded" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Catatan Admin</label>
                        <textarea name="catatan" class="w-full border-gray-300 rounded" rows="3"></textarea>
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan Laporan</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>