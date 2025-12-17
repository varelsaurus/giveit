{{-- resources/views/admin/user/create.blade.php --}}

<x-admin-layout>
    <x-slot name="header">Tambah User Baru</x-slot>

    <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-6">
        @csrf

        {{-- Nama --}}
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        
        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Role (Assign Kurir/Admin) --}}
        <div>
            <label for="role_id" class="block text-sm font-medium text-gray-700">Pilih Role</label>
            <select name="role_id" id="role_id" required 
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                {{-- $roles harus di-pass dari Controller, berisi daftar Role --}}
                @foreach ($roles as $role)
                    {{-- Biasanya Admin tidak perlu create Donatur/Penerima Donor --}}
                    @if (in_array($role->name, ['kurir', 'admin']))
                        <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('role_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md shadow-md">
                Daftarkan User
            </button>
        </div>
    </form>
</x-admin-layout>