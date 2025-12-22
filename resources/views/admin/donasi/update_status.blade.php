<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Status Donasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="mb-6">
                    <a href="{{ route('admin.donasi.index') }}" class="text-gray-500 hover:text-blue-600 flex items-center">
                        &larr; Kembali ke Manage Donasi
                    </a>
                </div>

                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold text-gray-800">Barang: {{ $donasi->nama_barang }}</h3>
                    <p class="text-sm text-gray-500">Status Saat Ini: <span class="font-bold uppercase">{{ $donasi->status }}</span></p>
                </div>

                <form action="{{ route('admin.donasi.updateStatusProcess', $donasi->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Baru</label>
                        
                        <select name="status" id="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            {{-- PERBAIKAN: Value harus huruf kecil & pakai underscore (_) --}}
                            
                            <option value="pending" {{ $donasi->status == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            
                            <option value="approved" {{ $donasi->status == 'approved' ? 'selected' : '' }}>
                                Approved (Disetujui)
                            </option>
                            
                            {{-- INI YANG SEBELUMNYA SALAH (Butuh Kurir -> proses_kurir) --}}
                            <option value="proses_kurir" {{ $donasi->status == 'proses_kurir' ? 'selected' : '' }}>
                                Proses Kurir
                            </option>
                            
                            <option value="selesai" {{ $donasi->status == 'selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            
                            <option value="rejected" {{ $donasi->status == 'rejected' ? 'selected' : '' }}>
                                Rejected (Ditolak)
                            </option>
                        </select>
                        
                        @error('status')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                        Simpan Perubahan
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>