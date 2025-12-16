{{-- resources/views/admin/donasi/list_pengajuan.blade.php --}}

<x-admin-layout>
    <x-slot name="header">Antrian Pengajuan Donasi (Menunggu Persetujuan)</x-slot>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="space-y-6">
        @forelse ($pengajuans as $pengajuan)
            <div class="bg-white border p-6 rounded-lg shadow-md">
                <h4 class="text-xl font-bold text-indigo-700 mb-3">Pengajuan #{{ $pengajuan->id }}</h4>
                
                <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                    <div>
                        <p class="font-semibold">Donasi:</p>
                        <p>{{ $pengajuan->donasi->jenis_pakaian ?? 'N/A' }} ({{ $pengajuan->donasi->jumlah ?? 'N/A' }} unit)</p>
                    </div>
                    <div>
                        <p class="font-semibold">Diajukan Oleh:</p>
                        <p>{{ $pengajuan->penerima->name ?? 'N/A' }}</p>
                    </div>
                </div>

                {{-- FORM PERSETUJUAN --}}
                <form action="{{ route('admin.pengajuan.approve', $pengajuan) }}" method="POST" class="mt-4 space-y-3 p-4 border border-green-200 rounded-md bg-green-50">
                    @csrf
                    <h5 class="font-bold text-green-800">Assign Kurir & Jadwal</h5>
                    
                    {{-- Pilih Kurir --}}
                    <div>
                        <label for="kurir_id_{{ $pengajuan->id }}" class="block text-sm font-medium text-gray-700">Pilih Kurir</label>
                        <select name="kurir_id" id="kurir_id_{{ $pengajuan->id }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Pilih Kurir --</option>
                            @foreach ($kurirs as $kurir)
                                <option value="{{ $kurir->id }}">{{ $kurir->name }}</option>
                            @endforeach
                        </select>
                        @error('kurir_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    {{-- Jadwal Ambil --}}
                    <div>
                        <label for="tanggal_ambil_{{ $pengajuan->id }}" class="block text-sm font-medium text-gray-700">Tanggal & Waktu Ambil (Donatur)</label>
                        <input type="datetime-local" name="tanggal_ambil" id="tanggal_ambil_{{ $pengajuan->id }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tanggal_ambil') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jadwal Kirim --}}
                    <div>
                        <label for="tanggal_kirim_{{ $pengajuan->id }}" class="block text-sm font-medium text-gray-700">Tanggal & Waktu Kirim (Penerima)</label>
                        <input type="datetime-local" name="tanggal_kirim" id="tanggal_kirim_{{ $pengajuan->id }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('tanggal_kirim') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md shadow-md w-full mt-3">
                        Setujui & Buat Jadwal
                    </button>
                </form>
            </div>
        @empty
            <div class="p-6 text-center border-2 border-dashed border-gray-300 rounded-lg">
                <p class="text-lg text-gray-600">Tidak ada pengajuan donasi yang menunggu persetujuan saat ini.</p>
            </div>
        @endforelse
    </div>
</x-admin-layout>