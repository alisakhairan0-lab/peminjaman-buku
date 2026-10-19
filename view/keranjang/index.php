<!-- Keranjang Peminjaman Buku (Multi-book Loan) -->
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Fitur Unggulan</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Keranjang Peminjaman Buku</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Kumpulkan beberapa buku favorit Anda dan ajukan peminjaman sekaligus dalam 1 nomor transaksi.
            </p>
        </div>

        <?php if (!empty($cartBooks)): ?>
            <a href="index.php?c=keranjang&a=kosongkan" onclick="return confirm('Kosongkan semua buku dari keranjang?');" class="px-4 py-2 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 text-xs font-semibold transition self-start sm:self-auto inline-flex items-center gap-1.5">
                <i class="fa-solid fa-trash-can"></i> Kosongkan Keranjang
            </a>
        <?php endif; ?>
    </div>

    <?php if (empty($cartBooks)): ?>
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-200 space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-[#FDF0ED] text-[#E8A598] flex items-center justify-center text-2xl mx-auto">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-800">Keranjang Peminjaman Masih Kosong</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                    Anda belum memilih buku untuk dipinjam. Buka katalog untuk mencari modul pelajaran SMK atau buku bacaan yang Anda butuhkan.
                </p>
            </div>
            <a href="index.php?c=katalog&a=index" class="inline-block px-5 py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-xs font-semibold transition shadow-xs">
                Jelajahi Katalog Buku
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Cart Items List -->
            <div class="lg:col-span-8 bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 text-sm">Daftar Buku Terpilih (<?= count($cartBooks) ?> Buku)</h3>
                    <span class="text-xs text-gray-500">Maksimal 3 buku per transaksi</span>
                </div>

                <div class="divide-y divide-gray-100">
                    <?php foreach ($cartBooks as $buku): ?>
                        <div class="p-4 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition">
                            <div class="w-14 h-20 bg-gradient-to-tr from-[#EAF0EC] to-[#FAF5E8] rounded-xl border border-gray-200 flex flex-col items-center justify-center p-1 text-center shrink-0">
                                <i class="fa-solid fa-book text-gray-400 text-lg"></i>
                                <span class="text-[8px] text-gray-500 font-bold block truncate w-full mt-1"><?= $buku['tahun_terbit'] ?></span>
                            </div>

                            <div class="flex-grow min-w-0">
                                <span class="text-[10px] font-semibold text-[#8FA89B] uppercase tracking-wider block">
                                    <?= htmlspecialchars($buku['nama_kategori'] ?? 'Umum') ?>
                                </span>
                                <h4 class="font-bold text-gray-900 text-sm truncate">
                                    <?= htmlspecialchars($buku['judul']) ?>
                                </h4>
                                <p class="text-xs text-gray-500 mt-0.5 truncate">
                                    Penulis: <?= htmlspecialchars($buku['penulis']) ?> • Penerbit: <?= htmlspecialchars($buku['nama_penerbit'] ?? '-') ?>
                                </p>
                                <span class="inline-block mt-1 text-[11px] font-medium text-emerald-600">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Tersedia (Stok: <?= $buku['stok'] ?>)
                                </span>
                            </div>

                            <a href="index.php?c=keranjang&a=hapus&id=<?= $buku['id_buku'] ?>" class="p-2 rounded-xl text-gray-400 hover:text-red-600 hover:bg-red-50 transition" title="Hapus buku dari keranjang">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <a href="index.php?c=katalog&a=index" class="text-xs font-semibold text-[#8FA89B] hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-plus text-[10px]"></i> Tambah Buku Lainnya
                    </a>
                    <span class="text-xs text-gray-500">Durasi Standar: <strong>7 Hari Pinjam</strong></span>
                </div>
            </div>

            <!-- Checkout Summary Box -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-3xl border border-gray-200 p-6 shadow-xs space-y-5">
                    <h3 class="font-bold text-gray-800 text-base border-b border-gray-100 pb-3">Ringkasan Peminjaman</h3>

                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between text-gray-600">
                            <span>Jumlah Buku:</span>
                            <strong class="text-gray-900"><?= count($cartBooks) ?> Judul</strong>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Durasi Peminjaman:</span>
                            <strong class="text-gray-900">7 Hari</strong>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Estimasi Batas Kembali:</span>
                            <strong class="text-gray-900"><?= date('d F Y', strtotime('+7 days')) ?></strong>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Peminjaman:</span>
                            <strong class="text-emerald-600 font-bold">GRATIS (Siswa)</strong>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-3 text-[11px] text-gray-500 space-y-1">
                        <p><i class="fa-solid fa-circle-info text-[#8FA89B] mr-1"></i> Peminjaman akan berstatus <strong>"Menunggu"</strong> sampai disetujui petugas perpustakaan.</p>
                        <p><i class="fa-solid fa-triangle-exclamation text-amber-500 mr-1"></i> Denda keterlambatan berlaku <strong>Rp 1.000 / hari / buku</strong> jika melewati batas kembali.</p>
                    </div>

                    <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'user'): ?>
                        <a href="index.php?c=keranjang&a=checkout" class="w-full block text-center py-3 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-xs font-bold transition shadow-xs">
                            Ajukan Peminjaman Sekarang
                        </a>
                    <?php elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin'): ?>
                        <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs text-center">
                            Anda login sebagai <strong>Admin</strong>. Pengajuan pinjam via keranjang ditujukan untuk akun Siswa.
                        </div>
                    <?php else: ?>
                        <div class="space-y-2">
                            <a href="index.php?c=auth&a=login" class="w-full block text-center py-3 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-xs font-bold transition shadow-xs">
                                Login Siswa untuk Meminjam
                            </a>
                            <p class="text-[11px] text-gray-400 text-center">
                                Belum punya akun? <a href="index.php?c=auth&a=register" class="text-[#8FA89B] font-semibold underline">Daftar Anggota</a>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
