<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Update Status Donasi #{{ $donasi->id }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- TAMBAHKAN INI UNTUK MELIHAT PESAN ERROR --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">Gagal Update!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.donasi.updateStatusProcess', $donasi->id) }}" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Pilih Status Baru</label>
                        <select name="status" id="status" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2">
                            
                            {{-- PERBAIKAN VALUE DI SINI --}}
                            
                            <option value="pending" {{ $donasi->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            
                            {{-- GANTI 'verified' JADI 'approved' SESUAI DB --}}
                            <option value="approved" {{ $donasi->status == 'approved' ? 'selected' : '' }}>
                                Approved (Disetujui)
                            </option>
                            
                            <option value="rejected" {{ $donasi->status == 'rejected' ? 'selected' : '' }}>
                                Rejected (Ditolak)
                            </option>
                            
                            <option value="proses_kurir" {{ $donasi->status == 'proses_kurir' ? 'selected' : '' }}>
                                Proses Kurir
                            </option>

                        </select>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('admin.donasi.index') }}" class="text-gray-600 font-bold">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>