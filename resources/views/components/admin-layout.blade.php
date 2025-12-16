{{-- File: resources/views/components/admin-layout.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $header ?? 'Dashboard Admin' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Navigasi Admin --}}
                    <div class="mb-6 flex flex-wrap gap-4 border-b pb-2">
                        <a href="{{ route('admin.user.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">👤 Manage User</a>
                        <a href="{{ route('admin.donasi.index') }}" class="text-purple-600 hover:text-purple-800 font-semibold">🎁 Manage Donasi</a>
                        <a href="{{ route('admin.pengajuan.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">📝 Persetujuan Pengajuan</a>
                        <a href="{{ route('admin.report.donasi') }}" class="text-green-600 hover:text-green-800 font-semibold">📊 Report</a>
                    </div>
                    
                    {{-- SLOT WAJIB --}}
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>