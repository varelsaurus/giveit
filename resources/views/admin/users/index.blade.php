<x-admin-layout :header="'Manage User'">
    <div class="mb-6">
        <a href="{{ route('admin.user.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Tambah User
        </a>
    </div>

    @if ($users->isEmpty())
        <p class="text-gray-500">Tidak ada data user.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300 bg-white">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">ID</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Nama</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Role</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2">{{ $user->id }}</td>
                            <td class="border border-gray-300 px-4 py-2 font-bold">{{ $user->name }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                            
                            {{-- BAGIAN PERBAIKAN ROLE (Menggunakan Badge Warna) --}}
                            <td class="border border-gray-300 px-4 py-2">
                                @if($user->role == 'admin')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Admin
                                    </span>
                                @elseif($user->role == 'kurir')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Kurir
                                    </span>
                                @elseif($user->role == 'donatur')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Donatur
                                    </span>
                                @elseif($user->role == 'penerima_donor')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Penerima
                                    </span>
                                @else
                                    {{-- Fallback untuk role lain --}}
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 capitalize">
                                        {{ $user->role }}
                                    </span>
                                @endif
                            </td>

                            <td class="border border-gray-300 px-4 py-2 text-center space-x-2">
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 font-bold">Edit</a>
                                
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-bold" onclick="return confirm('Yakin ingin hapus user {{ $user->name }}?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-admin-layout>