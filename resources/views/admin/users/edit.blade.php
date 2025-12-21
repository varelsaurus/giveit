<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- PERBAIKAN: Gunakan $user->id, BUKAN $donasi->id --}}
                <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="shadow border rounded w-full py-2 px-3">
                    </div>

                    {{-- Email --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="shadow border rounded w-full py-2 px-3">
                    </div>

                    {{-- Role --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                        <select name="role" class="shadow border rounded w-full py-2 px-3">
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="donatur" {{ $user->role == 'donatur' ? 'selected' : '' }}>Donatur</option>
                            <option value="penerima" {{ $user->role == 'penerima' ? 'selected' : '' }}>Penerima</option>
                            <option value="kurir" {{ $user->role == 'kurir' ? 'selected' : '' }}>Kurir</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.user.index') }}" class="text-gray-500 mr-4">Batal</a>
                        <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded">Update User</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>