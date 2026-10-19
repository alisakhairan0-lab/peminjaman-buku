<!-- Katalog Buku - Filterable by Category / SMK Jurusan / Novel -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <!-- Header & Search -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Perpustakaan Digital</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Katalog Buku Perpustakaan</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Temukan koleksi modul kejuruan SMK, buku pelajaran umum, dan novel sastra.
            </p>
        </div>

        <form action="index.php" method="GET" class="w-full md:w-96">
            <input type="hidden" name="c" value="katalog">
            <input type="hidden" name="a" value="index">
            <?php if (!empty($selectedKategori)): ?>
                <input type="hidden" name="kategori" value="<?= htmlspecialchars($selectedKategori) ?>">
            <?php endif; ?>
            <div class="flex items-center p-1.5 rounded-2xl bg-gray-50 border border-gray-200 focus-within:bg-white focus-within:border-[#8FA89B] focus-within:ring-2 focus-within:ring-[#8FA89B]/20 transition">
                <i class="fa-solid fa-magnifying-glass text-gray-400 ml-3 mr-2"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Cari judul, pengarang, penerbit..." class="w-full bg-transparent border-none text-sm text-gray-800 focus:outline-none py-1.5">
                <?php if (!empty($search)): ?>
                    <a href="index.php?c=katalog&a=index<?= !empty($selectedKategori) ? '&kategori='.$selectedKategori : '' ?>" class="text-xs text-gray-400 hover:text-gray-600 px-2">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                <?php endif; ?>
                <button type="submit" class="px-4 py-2 rounded-xl bg-[#8FA89B] text-white text-xs font-semibold hover:bg-[#789687] transition shrink-0">
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Category Pills Navigation -->
    <div class="space-y-3">
        <span class="text-xs font-semibold text-gray-500 block uppercase tracking-wider">Pilih Berdasarkan Kategori & Jurusan:</span>
        <div class="flex flex-wrap items-center gap-2">
            <a href="index.php?c=katalog&a=index<?= !empty($search) ? '&q='.urlencode($search) : '' ?>" class="px-3.5 py-1.5 rounded-xl text-xs font-medium transition <?= empty($selectedKategori) ? 'bg-[#8FA89B] text-white font-semibold shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' ?>">
                Semua Koleksi
            </a>

            <?php foreach ($categories as $cat): ?>
                <?php 
                    $isSelected = ($selectedKategori == $cat['id_kategori']);
                    $isSMK = strpos($cat['nama_kategori'], 'SMK') !== false;
                    $isNovel = strpos($cat['nama_kategori'], 'Novel') !== false;
                ?>
                <a href="index.php?c=katalog&a=index&kategori=<?= $cat['id_kategori'] ?><?= !empty($search) ? '&q='.urlencode($search) : '' ?>" class="px-3 py-1.5 rounded-xl text-xs font-medium transition flex items-center gap-1.5 <?= $isSelected ? 'bg-[#8FA89B] text-white font-semibold shadow-xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' ?>">
                    <?php if ($isSMK): ?>
                        <i class="fa-solid fa-graduation-cap text-[10px] <?= $isSelected ? 'text-white' : 'text-[#8FA89B]' ?>"></i>
                    <?php elseif ($isNovel): ?>
                        <i class="fa-solid fa-book text-[10px] <?= $isSelected ? 'text-white' : 'text-[#E8A598]' ?>"></i>
                    <?php endif; ?>
                    <span><?= htmlspecialchars($cat['nama_kategori']) ?></span>
                    <span class="px-1.5 py-0.2 rounded-full text-[10px] <?= $isSelected ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-500' ?>">
                        <?= $cat['total_buku'] ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Books Grid -->
    <?php if (empty($books)): ?>
        <div class="bg-white rounded-3xl p-12 text-center border border-gray-200 space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center text-2xl mx-auto">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-gray-800">Tidak Ada Buku Ditemukan</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                    Koleksi buku dengan kata kunci atau kategori yang Anda pilih tidak tersedia. Silakan ganti kata kunci atau reset filter.
                </p>
            </div>
            <a href="index.php?c=katalog&a=index" class="inline-block px-4 py-2 rounded-xl bg-gray-100 text-gray-700 text-xs font-semibold hover:bg-gray-200 transition">
                Reset Semua Filter
            </a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            <?php foreach ($books as $buku): ?>
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition group">
                    <!-- Book Visual Thumbnail -->
                    <div class="relative bg-gradient-to-tr from-[#F8F9FA] to-[#EAF0EC] h-48 flex items-center justify-center p-4 border-b border-gray-100">
                        <div class="w-24 h-36 bg-white rounded-lg shadow-md border border-gray-200 flex flex-col justify-between p-2.5 transform group-hover:-translate-y-1 transition text-center">
                            <span class="text-[9px] font-bold text-[#8FA89B] uppercase tracking-tight truncate">
                                <?= htmlspecialchars($buku['nama_kategori'] ?? 'Kategori') ?>
                            </span>
                            <div class="my-auto">
                                <i class="fa-solid fa-book text-2xl text-gray-400"></i>
                                <span class="text-[10px] font-semibold text-gray-700 line-clamp-2 block leading-tight mt-1">
                                    <?= htmlspecialchars($buku['judul']) ?>
                                </span>
                            </div>
                            <span class="text-[8px] text-gray-400"><?= $buku['tahun_terbit'] ?></span>
                        </div>

                        <!-- Stock Badge -->
                        <span class="absolute top-3 right-3 px-2 py-0.5 rounded-full text-[10px] font-bold <?= $buku['stok'] > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' ?>">
                            <?= $buku['stok'] > 0 ? 'Tersedia: ' . $buku['stok'] : 'Habis' ?>
                        </span>
                    </div>

                    <!-- Book Information -->
                    <div class="p-4 flex-grow flex flex-col justify-between space-y-3">
                        <div>
                            <span class="text-[10px] uppercase font-semibold tracking-wider text-[#8FA89B] block mb-1">
                                <?= htmlspecialchars($buku['nama_kategori'] ?? 'Umum') ?>
                            </span>
                            <h3 class="font-bold text-gray-800 text-sm leading-snug line-clamp-2 group-hover:text-[#557565] transition">
                                <?= htmlspecialchars($buku['judul']) ?>
                            </h3>
                            <p class="text-xs text-gray-500 mt-1 truncate">
                                <i class="fa-solid fa-pen-nib text-[10px] text-gray-400 mr-1"></i><?= htmlspecialchars($buku['penulis']) ?>
                            </p>
                            <p class="text-[11px] text-gray-400 mt-0.5 truncate">
                                <i class="fa-solid fa-building text-[10px] text-gray-300 mr-1"></i><?= htmlspecialchars($buku['nama_penerbit'] ?? 'Penerbit Mandiri') ?>
                            </p>
                        </div>

                        <!-- Action Controls -->
                        <div class="pt-2 border-t border-gray-100 flex items-center gap-2">
                            <a href="index.php?c=katalog&a=detail&id=<?= $buku['id_buku'] ?>" class="flex-1 text-center py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">
                                Lihat Detail
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
    <?php endif; ?>
</div>
