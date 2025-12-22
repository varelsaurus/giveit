<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                {{-- Judul Halaman --}}
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-lg font-bold text-gray-800">Edit Data: {{ $user->name }}</h3>
                </div>

                {{-- FORM EDIT USER --}}
                {{-- Perhatikan: Route mengarah ke admin.user.update dan menggunakan ID $user --}}
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT') 

                    {{-- 1. NAMA --}}
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" 
                            value="{{ old('name', $user->name) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 2. EMAIL --}}
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" 
                            value="{{ old('email', $user->email) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 3. ROLE (PENTING) --}}
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role / Peran</label>
                        <select name="role" id="role" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="donatur" {{ $user->role == 'donatur' ? 'selected' : '' }}>Donatur</option>
                            <option value="penerima" {{ $user->role == 'penerima' ? 'selected' : '' }}>Penerima Manfaat</option>
                            <option value="kurir" {{ $user->role == 'kurir' ? 'selected' : '' }}>Kurir</option>
                        </select>
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 4. NO HP --}}
                    <div class="mb-4">
                        <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No. HP / WhatsApp</label>
                        <input type="text" name="no_hp" id="no_hp" 
                            value="{{ old('no_hp', $user->no_hp) }}"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 5. ALAMAT --}}
                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="3"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat', $user->alamat) }}</textarea>
                        @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex items-center justify-end gap-4 mt-6">
                        <a href="{{ route('admin.user.index') }}" class="text-gray-600 hover:text-gray-900 font-bold">
                            &larr; Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                            Update User
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>