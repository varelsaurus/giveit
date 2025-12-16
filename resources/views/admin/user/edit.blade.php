{{-- resources/views/admin/donasi/update_status.blade.php --}}

<x-admin-layout>
    <x-slot name="header">Update Status Donasi #{{ $donasi->id }}</x-slot>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h4 class="text-xl font-semibold mb-4">Donasi: {{ $donasi->jenis_pakaian }} (Donatur: {{ $donasi->user->name ?? 'N/A' }})</h4>
        
        <form method="POST" action="{{ route('admin.donasi.updateStatusProcess', $donasi) }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Perbarui Status Donasi</label>
                <select name="status" id="status" required 
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @php $statuses = ['Tersedia', 'Diajukan', 'Dalam Pengiriman', 'Selesai', 'Dibatalkan']; @endphp
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected($donasi->status == $status)>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex items-center justify-end">
                <a href="{{ route('admin.donasi.index') }}" class="mr-4 text-gray-600 hover:text-gray-800">Batal</a>
                <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded-md shadow-md">
                    Simpan Perubahan Status
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>