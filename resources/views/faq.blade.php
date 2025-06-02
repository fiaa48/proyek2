<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techfix - FAQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Fungsi toggle FAQ
        function toggleFaq(index) {
            const answer = document.getElementById(`answer-${index}`);
            const symbol = document.getElementById(`symbol-${index}`);
            answer.classList.toggle('hidden');
            symbol.textContent = answer.classList.contains('hidden') ? '+' : '−';
        }

        // Fungsi dropdown navbar
        function toggleDropdown() {
            const menu = document.getElementById('dropdown-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-[#EAE6DF] min-h-screen flex flex-col">
    <!-- Navbar Khusus FAQ -->
    <nav class="bg-[#A89986] py-4 px-6 flex justify-between items-center sticky top-0 z-50 shadow-md">
        <a href="/" class="text-black text-2xl font-bold">Techfix</a>

        <div class="flex space-x-6 items-center">
            <a href="/" class="text-black font-medium hover:text-white transition">Home</a>

            <a href="/login" class="bg-[#EAE6DF] text-black px-4 py-2 rounded-lg font-semibold shadow-md hover:bg-[#d1ccc5] transition">Masuk</a>
        </div>
    </nav>

    <!-- Konten FAQ Utama -->
    <main class="flex-grow container mx-auto px-4 py-12">
        <h1 class="text-3xl font-bold text-center mb-8 text-black">Frequently Asked Questions</h1>

        <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- FAQ Item 1 -->
            <div class="bg-[#A89986] rounded-xl shadow-md overflow-hidden cursor-pointer" onclick="toggleFaq(1)">
                <div class="flex justify-between items-center px-6 py-4">
                    <h3 class="font-semibold text-lg">Berapa lama waktu pengecekan?</h3>
                    <span id="symbol-1" class="text-xl font-bold">+</span>
                </div>
                <div id="answer-1" class="hidden bg-white px-6 py-4 text-gray-800 border-t border-gray-200">
                    <p>Pengecekan biasanya 1 - 3 hari setelah penjemputan barang</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-[#A89986] rounded-xl shadow-md overflow-hidden cursor-pointer" onclick="toggleFaq(2)">
                <div class="flex justify-between items-center px-6 py-4">
                    <h3 class="font-semibold text-lg">Techfix Kita Menerima Service apa saja?</h3>
                    <span id="symbol-2" class="text-xl font-bold">+</span>
                </div>
                <div id="answer-2" class="hidden bg-white px-6 py-4 text-gray-800 border-t border-gray-200">
                    <p>Kami menerima service Laptop, komputer, dan printer baik hardware, software maupun elektronik lainnya</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-[#A89986] rounded-xl shadow-md overflow-hidden cursor-pointer" onclick="toggleFaq(3)">
                <div class="flex justify-between items-center px-6 py-4">
                    <h3 class="font-semibold text-lg">Bagaimana sistem garansi?</h3>
                    <span id="symbol-3" class="text-xl font-bold">+</span>
                </div>
                <div id="answer-3" class="hidden bg-white px-6 py-4 text-gray-800 border-t border-gray-200">
                    <p>Kami memberikan garansi 3 bulan untuk sparepart dan jasa perbaikan.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-[#A89986] rounded-xl shadow-md overflow-hidden cursor-pointer" onclick="toggleFaq(3)">
                <div class="flex justify-between items-center px-6 py-4">
                    <h3 class="font-semibold text-lg">Proses service bisa satu hari?</h3>
                    <span id="symbol-3" class="text-xl font-bold">+</span>
                </div>
                <div id="answer-3" class="hidden bg-white px-6 py-4 text-gray-800 border-t border-gray-200">
                    <p>Durasi perbaikan tergantung tingkat kerusakan. Akan diinformasikan saat pengecekan</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="bg-[#A89986] rounded-xl shadow-md overflow-hidden cursor-pointer" onclick="toggleFaq(3)">
                <div class="flex justify-between items-center px-6 py-4">
                    <h3 class="font-semibold text-lg">Bisa Service langsung ke tempatnya?</h3>
                    <span id="symbol-3" class="text-xl font-bold">+</span>
                </div>
                <div id="answer-3" class="hidden bg-white px-6 py-4 text-gray-800 border-t border-gray-200">
                    <p>Bisa, toko TechFix ada di Jl Terusan Blok sukadedel , Indramayu</p>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="bg-[#A89986] rounded-xl shadow-md overflow-hidden cursor-pointer" onclick="toggleFaq(4)">
                <div class="flex justify-between items-center px-6 py-4">
                    <h3 class="font-semibold text-lg">Apakah ada gratis antar-jemput?</h3>
                    <span id="symbol-4" class="text-xl font-bold">+</span>
                </div>
                <div id="answer-4" class="hidden bg-white px-6 py-4 text-gray-800 border-t border-gray-200">
                    <p>Ya, kami memberikan layanan gratis antar-jemput untuk wilayah Indramayu dalam radius 10 km.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-[#A89986] text-black py-0 px-6">
        <div class="mt-0 py-4 text-center">
            <p class="text-sm">&copy; 2025 - All rights reserved - Techfix</p>
        </div>
    </footer>

    <script>
        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#dropdown-button')) {
                document.getElementById('dropdown-menu').classList.add('hidden');
            }
        });
    </script>
</body>
</html>
