<!-- Admin CRUD Buku - Index -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Manajemen Koleksi</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Kelola Data Buku</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Tambah buku baru, perbarui stok, ubah kategori kejuruan SMK / novel, atau hapus data buku.
            </p>
        </div>

        <a href="index.php?c=buku&a=tambah" class="px-4 py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs self-start sm:self-auto">
            <i class="fa-solid fa-plus"></i> Tambah Buku Baru
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        <form action="index.php" method="GET" class="flex-grow flex flex-col sm:flex-row items-center gap-3">
            <input type="hidden" name="c" value="buku">
            <input type="hidden" name="a" value="index">

            <div class="w-full sm:w-80 flex items-center px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 focus-within:bg-white focus-within:border-[#8FA89B] text-xs">
                <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Cari judul atau pengarang..." class="w-full bg-transparent border-none focus:outline-none">
            </div>

            <select name="kategori" onchange="this.form.submit()" class="w-full sm:w-auto px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 text-xs text-gray-700 focus:outline-none">
                <option value="">Semua Kategori</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id_kategori'] ?>" <?= ($selectedKategori == $cat['id_kategori']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nama_kategori']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold transition">
                Filter
            </button>
            <?php if (!empty($search) || !empty($selectedKategori)): ?>
                <a href="index.php?c=buku&a=index" class="text-xs text-gray-400 hover:text-red-500 transition">
                    Reset
                </a>
            <?php endif; ?>
        </form>

        <span class="text-xs text-gray-500 shrink-0">
            Total: <strong><?= count($books) ?></strong> buku
        </span>
    </div>

    <!-- Book Table -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3">ID</th>
                        <th class="px-5 py-3">Judul & Kategori</th>
                        <th class="px-5 py-3">Penulis</th>
                        <th class="px-5 py-3">Penerbit</th>
                        <th class="px-5 py-3">Tahun</th>
                        <th class="px-5 py-3 text-center">Stok</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($books)): ?>
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-gray-400">Tidak ada data buku yang sesuai.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($books as $b): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5 font-mono text-gray-400">#<?= $b['id_buku'] ?></td>
                                <td class="px-5 py-3.5">
                                    <strong class="text-gray-900 block text-xs"><?= htmlspecialchars($b['judul']) ?></strong>
                                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded bg-gray-100 text-gray-600 text-[10px]">
                                        <?= htmlspecialchars($b['nama_kategori'] ?? 'Umum') ?>
                                    </span>
                                </td>
                                <td class="px-5 py-3.5"><?= htmlspecialchars($b['penulis']) ?></td>
                                <td class="px-5 py-3.5"><?= htmlspecialchars($b['nama_penerbit'] ?? '-') ?></td>
                                <td class="px-5 py-3.5"><?= $b['tahun_terbit'] ?></td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold <?= $b['stok'] > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= $b['stok'] ?>
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-right space-x-1 whitespace-nowrap">
                                    <a href="index.php?c=buku&a=edit&id=<?= $b['id_buku'] ?>" class="p-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 transition" title="Edit Buku">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <a href="index.php?c=buku&a=hapus&id=<?= $b['id_buku'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?');" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="Hapus Buku">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
