<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GiveFit - Ubah Baju Sisa Jadi Manfaat</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="antialiased bg-white text-gray-800">

    <nav class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex-shrink-0">
                <a href="/">
                    {{-- Pastikan logo.png ada di public/images/ --}}
                    <img src="{{ asset('images/logo.png') }}" alt="GiveFit" class="h-12 w-auto">
                </a>
            </div>

            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
                <a href="#" class="hover:text-blue-600 transition">Beranda</a>
                <a href="#" class="hover:text-blue-600 transition">Tentang Kami</a>
                <a href="#" class="hover:text-blue-600 transition">Kontak</a>
                <a href="#" class="hover:text-blue-600 transition">Donasi</a>
            </div>

            <div class="flex items-center space-x-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 text-white rounded-full font-semibold text-sm hover:bg-blue-700 transition shadow-md shadow-blue-200">
                            Daftar
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-2 border border-gray-200 text-gray-700 rounded-full font-semibold text-sm hover:bg-gray-50 transition">
                            Masuk
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <section class="relative pt-10 pb-20 overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-50 -z-10"></div>
        <div class="absolute bottom-0 left-0 -ml-20 w-72 h-72 bg-purple-100 rounded-full blur-3xl opacity-50 -z-10"></div>

        <div class="max-w-7xl mx-auto px-6 flex flex-col-reverse md:flex-row items-center gap-12">
            <div class="md:w-1/2 space-y-6">
                <h1 class="text-4xl md:text-6xl font-extrabold leading-tight text-gray-900">
                    Ubah Baju Tak <br>
                    <span class="text-blue-600 relative inline-block">
                        Terpakai Jadi
                        <svg class="absolute w-full h-3 -bottom-1 left-0 text-blue-200 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none">
                            <path d="M0 5 Q 50 10 100 5" stroke="currentColor" stroke-width="8" fill="none" />
                        </svg>
                    </span> <br>
                    Kebaikan Nyata
                </h1>
                <p class="text-gray-500 text-lg leading-relaxed max-w-lg">
                    GiveFit hadir sebagai platform yang memudahkan kamu untuk berdonasi baju yang sudah tidak terpakai agar bisa kembali bermanfaat bagi mereka yang membutuhkan.
                </p>
                <div class="pt-2">
                    <a href="{{ route('register') }}" class="inline-block px-8 py-3.5 bg-blue-600 text-white rounded-lg font-bold shadow-lg shadow-blue-300 hover:bg-blue-700 transform hover:-translate-y-1 transition duration-200">
                        START NOW
                    </a>
                </div>
            </div>

            <div class="md:w-1/2 flex justify-center relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-blue-100 to-white rounded-full blur-2xl opacity-60"></div>
                <img src="{{ asset('images/hero-illustration.png') }}" alt="Hero" class="relative z-10 w-full max-w-lg drop-shadow-xl hover:scale-105 transition duration-500">
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16 text-gray-900">Fitur Utama</h2>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8 items-center">
                <div class="hidden lg:block">
                     <img src="{{ asset('images/hero-illustration.png') }}" alt="Charity" class="w-full">
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Mendonasikan Baju</h3>
                    <p class="text-sm text-gray-500">Memberikan Baju Yang Sudah Terpakai Kepada Yang Membutuhkan</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4 text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Mengajukan Permintaan</h3>
                    <p class="text-sm text-gray-500">Mengajukan Permintaan Donasi Kepada Calon Pendonor</p>
                </div>

                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4 text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Riwayat Donasi</h3>
                    <p class="text-sm text-gray-500">Melihat Riwayat Donasi Yang Sudah Dilakukan</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-2">Mari Mulai Membantu Orang Lain</h2>
            <p class="text-gray-500 mb-12">Ayo Coba fitur kami, Untuk mengaksesnya silahkan daftar !</p>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-8 border rounded-2xl shadow-sm hover:shadow-xl transition flex flex-col items-center">
                    <div class="w-20 h-20 mb-6 bg-blue-50 rounded-full flex items-center justify-center">
                         <img src="{{ asset('images/icon-shirt.png') }}" alt="Icon" class="h-10 w-10 object-contain">
                    </div>
                    <h3 class="font-bold mb-2">Mendonasikan Baju</h3>
                    <p class="text-xs text-gray-500 mb-6 px-4">Mulai donasi baju dengan mudah</p>
                    <a href="{{ route('register') }}" class="px-8 py-2 bg-blue-500 text-white rounded-full text-sm font-semibold hover:bg-blue-600 w-full">Mulai</a>
                </div>
                <div class="p-8 border rounded-2xl shadow-sm hover:shadow-xl transition flex flex-col items-center">
                     <div class="w-20 h-20 mb-6 bg-blue-50 rounded-full flex items-center justify-center">
                         <img src="{{ asset('images/icon-phone.png') }}" alt="Icon" class="h-10 w-10 object-contain">
                    </div>
                    <h3 class="font-bold mb-2">Mengajukan Permintaan</h3>
                    <p class="text-xs text-gray-500 mb-6 px-4">Buat permintaan permintaan donasi</p>
                    <a href="{{ route('register') }}" class="px-8 py-2 bg-blue-500 text-white rounded-full text-sm font-semibold hover:bg-blue-600 w-full">Mulai</a>
                </div>
                <div class="p-8 border rounded-2xl shadow-sm hover:shadow-xl transition flex flex-col items-center">
                     <div class="w-20 h-20 mb-6 bg-blue-50 rounded-full flex items-center justify-center">
                         <img src="{{ asset('images/icon-history.png') }}" alt="Icon" class="h-10 w-10 object-contain">
                    </div>
                    <h3 class="font-bold mb-2">Riwayat Donasi</h3>
                    <p class="text-xs text-gray-500 mb-6 px-4">Pantau riwayat donasi</p>
                    <a href="{{ route('register') }}" class="px-8 py-2 bg-blue-500 text-white rounded-full text-sm font-semibold hover:bg-blue-600 w-full">Mulai</a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-center mb-16 text-gray-900">
                Untuk Siapa Giveit?
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl border border-blue-500 flex flex-col items-center text-center hover:shadow-xl transition duration-300">
                    <div class="w-32 h-32 mb-6 rounded-full overflow-hidden border-4 border-blue-50">
                        {{-- Ganti dengan gambar avatar orang --}}
                        <img src="{{ asset('images/target-all.png') }}" alt="Semua Orang" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-xl mb-4 text-gray-900">Untuk Semua Orang</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        GiveIt hadir untuk siapa pun yang ingin berbagi kebaikan. Tidak peduli usia, profesi, atau latar belakang — setiap orang bisa ikut berkontribusi dalam membantu sesama.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-blue-500 flex flex-col items-center text-center hover:shadow-xl transition duration-300">
                    <div class="w-32 h-32 mb-6 rounded-full overflow-hidden border-4 border-blue-50">
                        {{-- Ganti dengan gambar ilustrasi memasak/memberi --}}
                        <img src="{{ asset('images/target-giver.png') }}" alt="Pemberi" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-xl mb-4 text-gray-900">Untuk Mereka yang Ingin Memberi</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Bagi kamu yang memiliki pakaian layak pakai dan ingin menyalurkannya agar kembali bermanfaat bagi orang lain.
                    </p>
                </div>

                <div class="bg-white p-8 rounded-3xl border border-blue-500 flex flex-col items-center text-center hover:shadow-xl transition duration-300">
                    <div class="w-32 h-32 mb-6 rounded-full overflow-hidden border-4 border-blue-50">
                        {{-- Ganti dengan gambar orang bekerja/membutuhkan --}}
                        <img src="{{ asset('images/target-receiver.png') }}" alt="Penerima" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-xl mb-4 text-gray-900">Untuk Mereka yang Membutuhkan</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Bagi siapa pun yang membutuhkan bantuan pakaian, GiveIt menjadi jembatan agar kebutuhan itu bisa terpenuhi dengan mudah dan bermartabat.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center gap-12">
        <div class="md:w-1/2 space-y-8">
            <h2 class="text-4xl font-bold text-gray-900">Benefit Kami</h2>
            <div class="space-y-6">
                @foreach(['Menyalurkan bantuan tepat sasaran', 'Bangun kebiasaan berbagi', 'Mempermudah proses donasi baju', 'Edukasi singkat dan mudah diterapkan', 'Mendukung gaya hidup berkelanjutan'] as $benefit)
                <div class="flex items-center space-x-4">
                    <div class="flex-shrink-0 w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-gray-700 font-medium">{{ $benefit }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="md:w-1/2 flex justify-center">
            <img src="{{ asset('images/benefit-illustration.png') }}" alt="Benefit" class="w-full max-w-md drop-shadow-lg">
        </div>
    </section>

    <footer class="bg-white border-t py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col items-center">
            <div class="text-sm text-gray-500 mb-6 space-x-4">
                <a href="#" class="hover:text-blue-600">Tentang GiveFit</a> | 
                <a href="#" class="hover:text-blue-600">Syarat dan Ketentuan</a> | 
                <a href="#" class="hover:text-blue-600">Pusat Bantuan</a>
            </div>
            
            <div class="flex space-x-6 mb-8 text-gray-400">
                <a href="#" class="hover:text-blue-600"><svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/></svg></a> <a href="#" class="hover:text-pink-600"><svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4"/></svg></a> <a href="#" class="hover:text-blue-400"><svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.8 9.7l-2 9.5c-.1.6-.5.7-1 .4l-2.8-2.1-1.4 1.3c-.1.2-.3.3-.6.3l.2-2.8 5.1-4.6c.2-.2-.1-.3-.3-.2l-6.4 4-2.7-.9c-.6-.2-.6-.6.1-.9l10.6-4.1c.5-.2.9.1.8.8z"/></svg></a> </div>

            <p class="text-gray-400 text-xs">Copyright © 2025 GiveFit. All Rights Reserved</p>
        </div>
    </footer>
</body>
</html>