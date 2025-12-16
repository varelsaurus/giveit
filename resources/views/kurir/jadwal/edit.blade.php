{{-- resources/views/kurir/jadwal/edit.blade.php --}}

<x-kurir-layout>
    <x-slot name="header">Update Status Jadwal #{{ $jadwal->id }}</x-slot>

    <div class="p-6 bg-white rounded-lg shadow-md">
        <p class="mb-4 text-gray-700">Jenis Donasi: **{{ $jadwal->pengajuan->donasi->jenis_pakaian ?? 'N/A' }}**</p>
        
        <form method="POST" action="{{ route('kurir.jadwal.update', $jadwal) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Update Status --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Perbarui Status</label>
                <select name="status" id="status" required 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    <option value="Menunggu Ambil" @selected($jadwal->status == 'Menunggu Ambil')>Menunggu Ambil (di lokasi Donatur)</option>
                    <option value="Dalam Perjalanan" @selected($jadwal->status == 'Dalam Perjalanan')>Dalam Perjalanan (menuju Penerima)</option>
                    <option value="Selesai" @selected($jadwal->status == 'Selesai')>Selesai (Sudah diterima Penerima)</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Update Waktu Kirim (Opsional) --}}
            <div>
                <label for="tanggal_waktu_kirim" class="block text-sm font-medium text-gray-700">Perbarui Waktu Kirim (Opsional)</label>
                <input type="datetime-local" name="tanggal_waktu_kirim" id="tanggal_waktu_kirim"
                       value="{{ old('tanggal_waktu_kirim', \Carbon\Carbon::parse($jadwal->tanggal_waktu_kirim)->format('Y-m-d\TH:i')) }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                <p class="text-xs text-gray-500 mt-1">Gunakan ini jika waktu pengiriman berbeda dari jadwal awal.</p>
                @error('tanggal_waktu_kirim')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('kurir.jadwal.index') }}" class="text-gray-600 hover:text-gray-800">Batal</a>
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-md shadow-md">
                    Simpan Update
                </button>
            </div>
        </form>
    </div>
</x-kurir-layout>