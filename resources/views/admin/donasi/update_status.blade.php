<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Status Donasi #{{ $donasi->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('admin.donasi.updateStatusProcess', $donasi->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Pakaian</label>
                            <input type="text" value="{{ $donasi->jenis_pakaian }}" disabled class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight bg-gray-100">
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Status Saat Ini</label>
                            <select name="status" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="Tersedia" {{ $donasi->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="Diajukan" {{ $donasi->status == 'Diajukan' ? 'selected' : '' }}>Diajukan (Booked)</option>
                                <option value="Dalam Pengiriman" {{ $donasi->status == 'Dalam Pengiriman' ? 'selected' : '' }}>Dalam Pengiriman</option>
                                <option value="Selesai" {{ $donasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Dibatalkan" {{ $donasi->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.donasi.index') }}" class="text-gray-600 mr-4">Batal</a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>