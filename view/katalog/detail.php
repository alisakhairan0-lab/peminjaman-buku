<!-- Detail Buku -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-6">
        <a href="index.php?c=katalog&a=index" class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Katalog Buku
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 p-6 sm:p-8">
            <!-- Book Visual Thumbnail Card -->
            <div class="md:col-span-4 flex flex-col items-center">
                <div class="w-full max-w-[220px] aspect-[2/3] bg-gradient-to-tr from-[#EAF0EC] to-[#FAF5E8] rounded-2xl p-4 border border-gray-200 shadow-md flex flex-col justify-between text-center relative">
                    <span class="text-[10px] font-bold text-[#8FA89B] uppercase tracking-wider block">
                        <?= htmlspecialchars($buku['nama_kategori'] ?? 'Kategori') ?>
                    </span>
                    <div class="my-auto space-y-2">
                        <i class="fa-solid fa-book-bookmark text-4xl text-[#8FA89B]"></i>
                        <h4 class="font-bold text-gray-800 text-sm leading-tight px-1">
                            <?= htmlspecialchars($buku['judul']) ?>
                        </h4>
                    </div>
                    <span class="text-xs text-gray-500">Tahun: <?= $buku['tahun_terbit'] ?></span>
                </div>

                <!-- Stock & Status -->
                <div class="mt-4 text-center">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-bold <?= $buku['stok'] > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' ?>">
                        <?= $buku['stok'] > 0 ? 'Tersedia: ' . $buku['stok'] . ' Eks' : 'Stok Kosong' ?>
                    </span>
                </div>
            </div>

            <!-- Book Metadata -->
            <div class="md:col-span-8 flex flex-col justify-between space-y-6">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-lg bg-[#EAF0EC] text-[#557565] text-xs font-semibold">
                            <?= htmlspecialchars($buku['nama_kategori'] ?? 'Koleksi Umum') ?>
                        </span>
                        <span class="text-xs text-gray-400">• ID: BUKU-<?= str_pad($buku['id_buku'], 4, '0', STR_PAD_LEFT) ?></span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-snug">
                        <?= htmlspecialchars($buku['judul']) ?>
                    </h1>

                    <p class="text-sm text-gray-600 mt-2 flex items-center gap-2">
                        <i class="fa-solid fa-pen-nib text-xs text-[#8FA89B]"></i>
                        <span>Penulis: <strong><?= htmlspecialchars($buku['penulis']) ?></strong></span>
                    </p>
                </div>

                <!-- Specifications Table -->
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-gray-400 block mb-0.5">Penerbit:</span>
                        <strong class="text-gray-800"><?= htmlspecialchars($buku['nama_penerbit'] ?? 'Penerbit Mandiri') ?></strong>
                    </div>
                    <div>
                        <span class="text-gray-400 block mb-0.5">Tahun Terbit:</span>
                        <strong class="text-gray-800"><?= htmlspecialchars($buku['tahun_terbit']) ?></strong>
                    </div>
                    <div>
                        <span class="text-gray-400 block mb-0.5">Kontak Penerbit:</span>
                        <span class="text-gray-700"><?= htmlspecialchars($buku['telp_penerbit'] ?? '-') ?></span>
                    </div>
                    <div>
                        <span class="text-gray-400 block mb-0.5">Alamat Penerbit:</span>
                        <span class="text-gray-700 truncate block"><?= htmlspecialchars($buku['alamat_penerbit'] ?? '-') ?></span>
                    </div>
                </div>

                <!-- Peminjaman Action Box -->
                <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center gap-3">
                    <?php if ($buku['stok'] > 0): ?>
                        <a href="index.php?c=keranjang&a=tambah&id=<?= $buku['id_buku'] ?>" class="w-full sm:w-auto flex-1 text-center py-3 px-6 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-semibold text-sm transition flex items-center justify-center gap-2 shadow-xs">
                            <i class="fa-solid fa-cart-plus"></i> Masukkan ke Keranjang Pinjam
                        </a>
                    <?php else: ?>
                        <button disabled class="w-full sm:w-auto flex-1 text-center py-3 px-6 rounded-xl bg-gray-200 text-gray-400 font-semibold text-sm cursor-not-allowed">
                            Stok Saat Ini Tidak Tersedia
                        </button>
                    <?php endif; ?>

                    <a href="index.php?c=katalog&a=index" class="w-full sm:w-auto py-3 px-5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 text-sm font-semibold transition text-center">
                        Lihat Buku Lainnya
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
