<!-- Landing Page - User Friendly & Pastel Palette -->
<div class="space-y-12 pb-16">
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-b from-[#EAF0EC] via-[#F4F7F5] to-[#F8F9FA] border-b border-gray-200">
        <!-- Subtle silhouette background decorative elements -->
        <div class="absolute inset-0 opacity-10 pointer-events-none flex justify-between items-center px-12">
            <i class="fa-solid fa-book-open text-9xl text-[#8FA89B]"></i>
            <i class="fa-solid fa-graduation-cap text-9xl text-[#A29BFE]"></i>
            <i class="fa-solid fa-feather-pointed text-9xl text-[#E8A598]"></i>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/80 border border-[#8FA89B]/30 text-xs font-semibold text-[#557565] shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Perpustakaan Digital Terintegrasi • SMK Bisa & Hebat
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-gray-900 leading-tight">
                        Akses Ribuan Buku & Modul <span class="text-[#557565] underline decoration-[#8FA89B]/40 decoration-wavy">Pelajaran Kejuruan</span> dengan Mudah
                    </h1>

                    <p class="text-base text-gray-600 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        Selamat datang di portal perpustakaan sekolah digital. Temukan koleksi buku produktif SMK (RPL, AKL, MPLB, Pemasaran), novel sastra, komik, hingga referensi umum dengan sistem peminjaman multi-buku berbasis keranjang.
                    </p>

                    <!-- Quick Search Bar -->
                    <form action="index.php" method="GET" class="max-w-xl mx-auto lg:mx-0">
                        <input type="hidden" name="c" value="katalog">
                        <input type="hidden" name="a" value="index">
                        <div class="flex items-center p-1.5 rounded-2xl bg-white border border-gray-200 shadow-sm focus-within:border-[#8FA89B] focus-within:ring-2 focus-within:ring-[#8FA89B]/20 transition">
                            <i class="fa-solid fa-magnifying-glass text-gray-400 ml-3 mr-2"></i>
                            <input type="text" name="q" placeholder="Cari judul buku, penulis, atau jurusan SMK..." class="w-full bg-transparent border-none text-sm text-gray-800 placeholder-gray-400 focus:outline-none py-2">
                            <button type="submit" class="px-5 py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-sm font-semibold transition shadow-xs flex items-center gap-1.5 shrink-0">
                                <span>Cari</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </form>

                    <!-- Quick Action Chips -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2 pt-1 text-xs text-gray-500">
                        <span class="font-medium text-gray-400">Pencarian Cepat:</span>
                        <a href="index.php?c=katalog&a=index&kategori=12" class="px-2.5 py-1 rounded-lg bg-white/70 border border-gray-200 hover:border-[#8FA89B] hover:text-[#557565] transition">💻 Rekayasa Perangkat Lunak</a>
                        <a href="index.php?c=katalog&a=index&kategori=13" class="px-2.5 py-1 rounded-lg bg-white/70 border border-gray-200 hover:border-[#8FA89B] hover:text-[#557565] transition">📊 Akuntansi (AKL)</a>
                        <a href="index.php?c=katalog&a=index&kategori=14" class="px-2.5 py-1 rounded-lg bg-white/70 border border-gray-200 hover:border-[#8FA89B] hover:text-[#557565] transition">📁 Manajemen Perkantoran</a>
                        <a href="index.php?c=katalog&a=index&kategori=16" class="px-2.5 py-1 rounded-lg bg-white/70 border border-gray-200 hover:border-[#8FA89B] hover:text-[#557565] transition">📖 Novel Romance</a>
                    </div>
                </div>

                <!-- Hero Graphic Card / Pastel Showcase -->
                <div class="lg:col-span-5">
                    <div class="relative bg-white/90 backdrop-blur-md rounded-3xl p-6 border border-gray-200 shadow-sm space-y-5">
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#EAF0EC] text-[#557565] flex items-center justify-center font-bold">
                                    <i class="fa-solid fa-bookmark"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm">Peminjaman Praktis</h4>
                                    <p class="text-xs text-gray-500">Pilih banyak buku ke keranjang</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-[#FDF0ED] text-[#E8A598] text-xs font-bold">
                                UKK RPL 2026
                            </span>
                        </div>

                        <!-- Mini Interactive Feature Highlights -->
                        <div class="space-y-3 text-xs">
                            <div class="p-3 rounded-2xl bg-[#F8F9FA] border border-gray-100 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#FDF0ED] text-[#E8A598] flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </div>
                                <div class="flex-grow">
                                    <span class="font-semibold text-gray-800 block">Fitur Keranjang Peminjaman</span>
                                    <span class="text-gray-500 text-[11px]">Pinjam lebih dari 1 buku sekaligus dalam 1 nomor transaksi.</span>
                                </div>
                            </div>

                            <div class="p-3 rounded-2xl bg-[#F8F9FA] border border-gray-100 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#F1F0FF] text-[#A29BFE] flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-file-word"></i>
                                </div>
                                <div class="flex-grow">
                                    <span class="font-semibold text-gray-800 block">Laporan Ekspor Word & Excel</span>
                                    <span class="text-gray-500 text-[11px]">Cetak laporan harian & unggah dokumen arsip resmi.</span>
                                </div>
                            </div>

                            <div class="p-3 rounded-2xl bg-[#F8F9FA] border border-gray-100 flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#EAF0EC] text-[#8FA89B] flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </div>
                                <div class="flex-grow">
                                    <span class="font-semibold text-gray-800 block">Kalkulasi Denda Otomatis</span>
                                    <span class="text-gray-500 text-[11px]">Perhitungan denda keterlambatan per hari transparan.</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 flex items-center justify-between">
                            <a href="index.php?c=katalog&a=index" class="w-full text-center py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-semibold text-xs transition">
                                Jelajahi Katalog Buku Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Library Stats Counter -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
            <div class="bg-white rounded-2xl p-5 border border-gray-200 flex items-center gap-4 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-[#EAF0EC] text-[#557565] flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold text-gray-900 block"><?= $totalBuku ?></span>
                    <span class="text-xs text-gray-500">Judul Buku Tersedia</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-200 flex items-center gap-4 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-[#FDF0ED] text-[#E8A598] flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold text-gray-900 block"><?= $totalKategori ?></span>
                    <span class="text-xs text-gray-500">Kategori & Jurusan</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-200 flex items-center gap-4 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-[#F1F0FF] text-[#A29BFE] flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold text-gray-900 block"><?= $totalAnggota ?></span>
                    <span class="text-xs text-gray-500">Anggota Siswa Terdaftar</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-200 flex items-center gap-4 shadow-xs">
                <div class="w-12 h-12 rounded-2xl bg-[#FAF5E8] text-[#D4A373] flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-arrow-right-arrow-left"></i>
                </div>
                <div>
                    <span class="text-2xl font-bold text-gray-900 block"><?= $totalTransaksi ?></span>
                    <span class="text-xs text-gray-500">Transaksi Tercatat</span>
                </div>
            </div>
        </div>
    </section>

    <!-- SMK Majors Category Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-2">
            <div>
                <span class="text-xs font-semibold text-[#557565] uppercase tracking-wider">Koleksi Kejuruan SMK</span>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Buku Pelajaran Produktif Jurusan</h2>
            </div>
            <a href="index.php?c=katalog&a=index" class="text-xs font-semibold text-[#557565] hover:underline flex items-center gap-1">
                Lihat Semua Jurusan <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- RPL -->
            <a href="index.php?c=katalog&a=index&kategori=12" class="group bg-white rounded-2xl p-5 border border-gray-200 hover:border-[#8FA89B] hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-[#EAF0EC] text-[#557565] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition">
                    <i class="fa-solid fa-code"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-base group-hover:text-[#557565] transition">Rekayasa Perangkat Lunak</h3>
                <p class="text-xs text-gray-500 mt-1 line-clamp-2">Pemrograman Web, Basis Data MySQL, OOP PHP/Java, Mobile App development.</p>
                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-[#557565] font-semibold">
                    <span>Buka Koleksi RPL</span>
                    <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <!-- Akuntansi AKL -->
            <a href="index.php?c=katalog&a=index&kategori=13" class="group bg-white rounded-2xl p-5 border border-gray-200 hover:border-[#E8A598] hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-[#FDF0ED] text-[#E8A598] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-base group-hover:text-[#E8A598] transition">Akuntansi & Keuangan (AKL)</h3>
                <p class="text-xs text-gray-500 mt-1 line-clamp-2">Praktikum Jasa & Dagang, MYOB Accounting, Spreadsheet, Administrasi Pajak.</p>
                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-[#E8A598] font-semibold">
                    <span>Buka Koleksi AKL</span>
                    <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <!-- Manajemen Perkantoran MPLB -->
            <a href="index.php?c=katalog&a=index&kategori=14" class="group bg-white rounded-2xl p-5 border border-gray-200 hover:border-[#A29BFE] hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-[#F1F0FF] text-[#A29BFE] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-base group-hover:text-[#A29BFE] transition">Manajemen Perkantoran (MPLB)</h3>
                <p class="text-xs text-gray-500 mt-1 line-clamp-2">Tata Kelola Kepegawaian, Kearsipan Digital, Humas, Komunikasi Bisnis.</p>
                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-[#A29BFE] font-semibold">
                    <span>Buka Koleksi MPLB</span>
                    <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition"></i>
                </div>
            </a>

            <!-- Bisnis & Pemasaran BDP -->
            <a href="index.php?c=katalog&a=index&kategori=15" class="group bg-white rounded-2xl p-5 border border-gray-200 hover:border-[#D4A373] hover:shadow-md transition">
                <div class="w-12 h-12 rounded-xl bg-[#FAF5E8] text-[#D4A373] flex items-center justify-center text-xl mb-4 group-hover:scale-105 transition">
                    <i class="fa-solid fa-store"></i>
                </div>
                <h3 class="font-bold text-gray-800 text-base group-hover:text-[#D4A373] transition">Bisnis & Pemasaran</h3>
                <p class="text-xs text-gray-500 mt-1 line-clamp-2">Digital Marketing, Bisnis Ritel Modern, Visual Merchandising, Kasir Elektronik.</p>
                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-[#D4A373] font-semibold">
                    <span>Buka Koleksi Pemasaran</span>
                    <i class="fa-solid fa-chevron-right text-[10px] group-hover:translate-x-1 transition"></i>
                </div>
            </a>
        </div>
    </section>

    <!-- Latest Books Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-6 gap-2">
            <div>
                <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Koleksi Terbaru</span>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Buku Rekomendasi & Terpopuler</h2>
            </div>
            <a href="index.php?c=katalog&a=index" class="text-xs font-semibold text-[#8FA89B] hover:underline flex items-center gap-1">
                Jelajahi Semua Buku <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            <?php foreach ($latestBooks as $buku): ?>
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition group">
                    <!-- Book Cover & Stock Status -->
                    <div class="relative bg-gradient-to-tr from-[#F8F9FA] to-[#EAF0EC] h-48 flex items-center justify-center p-4 border-b border-gray-100">
                        <div class="w-24 h-36 bg-white rounded-lg shadow-md border border-gray-200 flex flex-col justify-between p-2.5 transform group-hover:-translate-y-1 transition text-center">
                            <span class="text-[9px] font-bold text-[#8FA89B] uppercase tracking-tight truncate"><?= htmlspecialchars($buku['nama_kategori'] ?? 'Kategori') ?></span>
                            <div class="my-auto">
                                <i class="fa-solid fa-book text-2xl text-gray-400"></i>
                                <span class="text-[10px] font-semibold text-gray-700 line-clamp-2 block leading-tight mt-1"><?= htmlspecialchars($buku['judul']) ?></span>
                            </div>
                            <span class="text-[8px] text-gray-400"><?= $buku['tahun_terbit'] ?></span>
                        </div>

                        <!-- Stock Badge -->
                        <span class="absolute top-3 right-3 px-2 py-0.5 rounded-full text-[10px] font-bold <?= $buku['stok'] > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' ?>">
                            <?= $buku['stok'] > 0 ? 'Stok: ' . $buku['stok'] : 'Habis' ?>
                        </span>
                    </div>

                    <!-- Book Meta Info -->
                    <div class="p-4 flex-grow flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[11px] text-[#8FA89B] font-medium block mb-1">
                                <?= htmlspecialchars($buku['nama_kategori'] ?? 'Umum') ?>
                            </span>
                            <h3 class="font-bold text-gray-800 text-sm leading-snug line-clamp-2 group-hover:text-[#557565] transition">
                                <?= htmlspecialchars($buku['judul']) ?>
                            </h3>
                            <p class="text-xs text-gray-500 mt-1 truncate">
                                <i class="fa-solid fa-pen-nib text-[10px] text-gray-400 mr-1"></i><?= htmlspecialchars($buku['penulis']) ?>
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="pt-2 border-t border-gray-100 flex items-center gap-2">
                            <a href="index.php?c=katalog&a=detail&id=<?= $buku['id_buku'] ?>" class="flex-1 text-center py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">
                                Detail
                            </a>
                            <?php if ($buku['stok'] > 0): ?>
                                <a href="index.php?c=keranjang&a=tambah&id=<?= $buku['id_buku'] ?>" class="p-2 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-xs transition" title="Tambah ke Keranjang">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- SOP & Tata Tertib Peminjaman -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs">
            <div class="text-center max-w-2xl mx-auto mb-8">
                <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Panduan Pengguna</span>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mt-1">Alur Peminjaman Buku Digital (Flowmap)</h2>
                <p class="text-xs text-gray-500 mt-1">Sesuai dengan standar diagram alur kerja Uji Kompetensi Keahlian Paket 4</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="flex items-start gap-3 p-4 rounded-2xl bg-[#F8F9FA] border border-gray-100">
                    <div class="w-8 h-8 rounded-xl bg-[#8FA89B] text-white flex items-center justify-center text-sm font-bold shrink-0">1</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-xs">Pilih Buku & Keranjang</h4>
                        <p class="text-[11px] text-gray-500 mt-0.5">Cari buku melalui katalog atau filter kategori, lalu masukkan ke keranjang peminjaman.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 rounded-2xl bg-[#F8F9FA] border border-gray-100">
                    <div class="w-8 h-8 rounded-xl bg-[#E8A598] text-white flex items-center justify-center text-sm font-bold shrink-0">2</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-xs">Ajukan Peminjaman</h4>
                        <p class="text-[11px] text-gray-500 mt-0.5">Checkout keranjang secara kolektif untuk membuat nomor transaksi dengan status "Menunggu".</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 rounded-2xl bg-[#F8F9FA] border border-gray-100">
                    <div class="w-8 h-8 rounded-xl bg-[#A29BFE] text-white flex items-center justify-center text-sm font-bold shrink-0">3</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-xs">Konfirmasi Petugas</h4>
                        <p class="text-[11px] text-gray-500 mt-0.5">Admin menyetujui, mencatat tanggal pinjam & batas kembali (7 hari), serta mengurangi stok buku.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 p-4 rounded-2xl bg-[#F8F9FA] border border-gray-100">
                    <div class="w-8 h-8 rounded-xl bg-[#D4A373] text-white flex items-center justify-center text-sm font-bold shrink-0">4</div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-xs">Pengembalian & Denda</h4>
                        <p class="text-[11px] text-gray-500 mt-0.5">Buku dikembalikan ke perpustakaan. Sistem secara otomatis menghitung denda jika terlambat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
