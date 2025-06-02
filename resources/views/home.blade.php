<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techfix - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        function toggleDropdown(event) {
            event.stopPropagation();
            document.getElementById("dropdown-menu").classList.toggle("hidden");
        }

        window.onclick = function(event) {
            if (!event.target.matches('#dropdown-button') && !event.target.closest('#dropdown-menu')) {
                document.getElementById("dropdown-menu").classList.add("hidden");
            }
        }
    </script>
</head>
<body class="bg-[#EAE6DF] min-h-screen flex flex-col justify-between">
    <!-- Navbar -->
    <nav class="bg-[#A89986] py-4 px-6 flex justify-between items-center relative">
        <h1 class="text-black text-2xl font-bold">Techfix</h1>
        <div class="flex space-x-6 items-center">
            <a href="{{ route('home') }}" class="text-black font-medium hover:text-white transition">Home</a>

            <!-- Dropdown Produk -->
            <div class="relative">
                <button id="dropdown-button" onclick="toggleDropdown(event)" class="text-black font-medium flex items-center hover:text-white transition">
                    Kami Menjual <span class="ml-1">▼</span>
                </button>
                <div id="dropdown-menu" class="absolute left-0 top-full mt-2 w-48 bg-white border border-gray-300 shadow-lg rounded-lg hidden z-50">
                    <a href="{{route('komputer')}}" class="block px-4 py-2 hover:bg-gray-200 flex items-center">
                        <img src="{{ asset('images/image1.png')}}" class="w-5 h-5 mr-2">Perlengkapan Komputer
                    </a>
                    <a href="{{route('laptop')}}" class="block px-4 py-2 hover:bg-gray-200 flex items-center">
                        <img src="{{ asset('images/image.png')}}" class="w-5 h-5 mr-2"> Laptop
                    </a>
                </div>
            </div>

            <a href="#services" class="text-black font-medium hover:text-white transition">Layanan</a>
            <a href="#team" class="text-black font-medium hover:text-white transition">Tim Kami</a>
            <a href="#about" class="text-black font-medium hover:text-white transition">Tentang Kami</a>
            <a href="{{ route('faq') }}" class="text-black font-medium hover:text-white transition">FAQ</a>
            <a href="https://wa.me/6287727377749?text=hallo%20dengan%20admin%20techfix%20disini%20ada%20yang%20bisa%20saya%20bantu%3F%3F" target="_blank" rel="noopener noreferrer" class="text-black font-medium hover:text-white transition">Kontak</a>
            <a href="{{ route('login') }}" class="bg-[#EAE6DF] text-black px-4 py-2 rounded-lg font-semibold shadow-md hover:bg-[#d1ccc5] transition">Masuk</a>
        </div>
    </nav>

    <!-- Header Section -->
    <div class="text-center py-16 max-w-4xl mx-auto w-full px-4">
        <h1 class="text-4xl font-bold text-black mb-4">
            TEKNISI ELEKTRONIK PROFESIONAL DI INDRAMAYU
        </h1>
        <p class="text-gray-700 mt-2 text-lg">
            Tim teknisi berpengalaman kami siap memperbaiki berbagai perangkat elektronik Anda.
            Gratis antar jemput, bergaransi, dan hanya bayar ketika unit sudah berfungsi sempurna.
        </p>
        <a href="#services" class="inline-block mt-6 bg-[#A89986] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#8a7b68] transition">
            Layanan Kami >
        </a>
    </div>

    <!-- Why Choose Us -->
    <div class="bg-[#f5f5f5] py-12 px-6">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-semibold text-center text-black mb-8">Mengapa Memilih Techfix?</h2>
            <p class="text-gray-700 text-center mb-8">
                Kami memiliki tim teknisi yang ahli di bidangnya dengan pengalaman bertahun-tahun.
                Setiap perbaikan dilakukan dengan teliti menggunakan peralatan profesional dan sparepart berkualitas.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4">
                    <h3 class="text-xl font-semibold mb-2">Garansi Resmi</h3>
                    <p class="text-gray-600">Setiap perbaikan dilengkapi dengan garansi resmi hingga 3 bulan</p>
                </div>
                <div class="text-center p-4">
                    <h3 class="text-xl font-semibold mb-2">Teknisi Bersertifikat</h3>
                    <p class="text-gray-600">Teknisi kami memiliki sertifikasi kompetensi di bidang elektronik</p>
                </div>
                <div class="text-center p-4">
                    <h3 class="text-xl font-semibold mb-2">Diagnosa Gratis</h3>
                    <p class="text-gray-600">Kami memberikan diagnosa kerusakan secara gratis tanpa biaya</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Layanan Kami -->
    <div class="py-12 px-6 bg-[#EAE6DF]" id="services">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-semibold text-center text-black mb-4">Layanan Kami</h2>
            <p class="text-gray-700 text-center mb-8">
                Berbagai jenis layanan perbaikan elektronik dengan kualitas terbaik
            </p>

            <div class="space-y-6">
                <!-- Service 1 -->
                <div class="bg-[#C2B4A8] p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-2">Perbaikan Laptop</h3>
                    <p class="text-gray-600 mb-4">
                        Mulai dari ganti LCD, keyboard, motherboard, hingga upgrade hardware.
                        Kami menangani semua merek laptop dengan sparepart original.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Ganti LCD</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Upgrade RAM/SSD</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Perbaikan Motherboard</span>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="bg-[#C2B4A8] p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-2">Perbaikan Handphone</h3>
                    <p class="text-gray-600 mb-4">
                        Ganti layar, baterai, port charging, dan berbagai masalah software.
                        Kami menggunakan sparepart berkualitas dengan harga terjangkau.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Ganti Layar</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Water Damage</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Unlock/Flash</span>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="bg-[#C2B4A8] p-6 rounded-lg shadow">
                    <h3 class="text-xl font-semibold mb-2">Perbaikan AC</h3>
                    <p class="text-gray-600 mb-4">
                        Servis berkala, isi freon, perbaikan elektronik, hingga pemasangan baru.
                        Teknisi AC kami sudah berpengalaman lebih dari 5 tahun.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Isi Freon</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Cuci AC</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Perbaikan PCB</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Perbaikan TV</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Perbaikan Kipas Angin</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Perbaikan Mesin Cuci</span>
                        <span class="bg-[#EAE6DF] px-3 py-1 rounded-full text-sm">Dan lain lain</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tim Teknisi -->
    <div class="py-12 px-6 bg-[#C2B4A8]" id="team">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-semibold text-center text-black mb-4">Tim Teknisi Kami</h2>
            <p class="text-gray-700 text-center mb-8">
                Tim profesional dengan pengalaman luas di bidang elektronik
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Teknisi 1 -->
                <div class="bg-[#f5f5f5] p-6 rounded-lg shadow flex items-start">
                    <img src="{{ asset('images/Lucas.jpg') }}" alt="Teknisi 1" class="w-24 h-24 rounded-full object-cover mr-4">
                    <div>
                        <h3 class="text-xl font-semibold">Ahmad Fauzi</h3>
                        <p class="text-[#A89986] mb-2">Spesialis Laptop & Komputer</p>
                        <p class="text-gray-600 mb-2">Pengalaman: 8 tahun</p>
                        <p class="text-gray-600">
                            Ahli dalam perbaikan motherboard dan data recovery.
                            Memiliki sertifikasi CompTIA A+ dan teknisi resmi Dell.
                        </p>
                    </div>
                </div>

                <!-- Teknisi 2 -->
                <div class="bg-[#f5f5f5] p-6 rounded-lg shadow flex items-start">
                    <img src="{{ asset('images/LucasCute.jpg') }}" alt="Teknisi 2" class="w-24 h-24 rounded-full object-cover mr-4">
                    <div>
                        <h3 class="text-xl font-semibold">Budi Santoso</h3>
                        <p class="text-[#A89986] mb-2">Spesialis AC & Kulkas</p>
                        <p class="text-gray-600 mb-2">Pengalaman: 10 tahun</p>
                        <p class="text-gray-600">
                            Spesialis perbaikan sistem pendingin.
                            Berpengalaman menangani berbagai merek AC dan kulkas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tentang Kami Section -->
    <div class="py-12 px-6 bg-[#EAE6DF]" id="about">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-2xl font-semibold text-center text-black mb-8">Tentang Kami</h2>
            <div class="bg-white p-8 rounded-lg shadow">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="md:w-1/2">
                        <h3 class="text-xl font-semibold mb-4">Visi Kami</h3>
                        <p class="text-gray-700 mb-6">
                            Menjadi penyedia jasa perbaikan elektronik terpercaya di Indramayu dengan layanan berkualitas tinggi dan harga terjangkau.
                        </p>

                        <h3 class="text-xl font-semibold mb-4">Misi Kami</h3>
                        <ul class="list-disc pl-5 text-gray-700 space-y-2">
                            <li>Memberikan solusi perbaikan elektronik yang cepat dan tepat</li>
                            <li>Menggunakan sparepart berkualitas dengan harga kompetitif</li>
                            <li>Memberikan pelayanan terbaik dengan garansi memuaskan</li>
                            <li>Mengembangkan SDM teknisi yang profesional dan bersertifikat</li>
                        </ul>
                    </div>
                    <div class="md:w-1/2">
                        <h3 class="text-xl font-semibold mb-4">Sejarah Techfix</h3>
                        <p class="text-gray-700 mb-4">
                            Techfix didirikan pada tahun 2015 oleh sekelompok teknisi elektronik yang berpengalaman.
                            Bermula dari bengkel kecil di Indramayu, kini kami telah berkembang menjadi salah satu
                            penyedia jasa perbaikan elektronik terbesar di wilayah ini.
                        </p>
                        <p class="text-gray-700">
                            Dengan lebih dari 10.000 perangkat yang telah diperbaiki, kami bangga menjadi mitra
                            terpercaya masyarakat Indramayu dalam merawat perangkat elektronik mereka.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimoni Pelanggan -->
    <div class="bg-[#F5F5F5] py-12 px-6">
        <h2 class="text-2xl font-semibold text-center text-black mb-8">Testimoni Pelanggan</h2>
        <div class="flex flex-wrap justify-center gap-6 mt-6 max-w-5xl mx-auto">
            @forelse($reviews as $review)
                <div class="bg-[#EAE6DF] p-6 rounded-lg shadow w-72 text-center border border-gray-300">
                    <div class="mb-2 text-yellow-500">
                        @for ($i = 0; $i < $review->rating; $i++)
                            ★
                        @endfor
                    </div>
                    <p class="text-gray-700 italic">"{{ $review->comment ?? 'Tidak ada komentar.' }}"</p>
                    <p class="mt-2 font-semibold text-[#004AAD]">- {{ $review->user->name }}</p>
                </div>
            @empty
                <p class="text-center text-white">Belum ada testimoni.</p>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#A89986] text-black py-10 px-6">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6 text-center md:text-left">
            <div>
                <h3 class="text-lg font-semibold">Techfix</h3>
                <p class="mt-2">Perusahaan Jasa Service Elektronik terbaik di Kota Indramayu</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Akun</h3>
                <ul class="mt-2">
                    <li><a href="{{ route('login') }}" class="hover:underline">Masuk</a></li>
                    <li><a href="{{ route('register') }}" class="hover:underline">Daftar</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Tentang Kami</h3>
                <ul class="mt-2">
                    <li><a href="#about" class="hover:underline">Profil</a></li>
                    <li><a href="#team" class="hover:underline">Tim Kami</a></li>
                    <li><a href="#" class="hover:underline">Karir</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold">Hubungi Kami</h3>
                <p class="mt-2">+6287727377749</p>
                <p>Jl. Terusan Blos Sukadedel, Indramayu</p>
            </div>
        </div>
        <div class="mt-10 py-4 text-center">
            <p class="text-sm">&copy; 2025 - All rights reserved - Techfix</p>
        </div>
    </footer>
</body>
</html>
