<!-- Admin CRUD Kategori Buku - Index & Inline Form -->
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div>
        <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Taksonomi Buku</span>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Kelola Kategori & Jurusan SMK</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1">
            Atur klasifikasi buku kejuruan (RPL, AKL, MPLB, Bisnis), novel fiksi, maupun kategori umum lainnya.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Add Category Form -->
        <div class="md:col-span-4">
            <div class="bg-white rounded-3xl p-6 border border-gray-200 shadow-xs space-y-4 sticky top-24">
                <h3 class="font-bold text-gray-800 text-sm">Tambah Kategori Baru</h3>

                <form action="index.php?c=kategori&a=tambah" method="POST" class="space-y-3 text-xs">
                    <div class="space-y-1">
                        <label class="font-semibold text-gray-700">Nama Kategori</label>
                        <input type="text" name="nama_kategori" required placeholder="Contoh: Novel - Horor & Supranatural" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-bold text-xs transition shadow-xs">
                        <i class="fa-solid fa-plus mr-1"></i> Simpan Kategori
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="md:col-span-8">
            <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
                <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 text-sm">Daftar Kategori Tersedia</h3>
                    <span class="text-xs text-gray-500">Total: <?= count($categories) ?> kategori</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600">
                        <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                            <tr>
                                <th class="px-5 py-3">ID</th>
                                <th class="px-5 py-3">Nama Kategori / Jurusan</th>
                                <th class="px-5 py-3 text-center">Buku</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($categories as $cat): ?>
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-5 py-3.5 font-mono text-gray-400">#<?= $cat['id_kategori'] ?></td>
                                    <td class="px-5 py-3.5">
                                        <form action="index.php?c=kategori&a=edit" method="POST" class="flex items-center gap-2">
                                            <input type="hidden" name="id_kategori" value="<?= $cat['id_kategori'] ?>">
                                            <input type="text" name="nama_kategori" value="<?= htmlspecialchars($cat['nama_kategori']) ?>" class="px-2.5 py-1 rounded-lg border border-gray-200 focus:border-[#8FA89B] text-xs text-gray-800 flex-grow">
                                            <button type="submit" class="p-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition" title="Simpan Perubahan">
                                                <i class="fa-solid fa-floppy-disk text-[11px]"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 text-[10px] font-semibold">
                                            <?= $cat['total_buku'] ?> Judul
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                        <a href="index.php?c=kategori&a=hapus&id=<?= $cat['id_kategori'] ?>" onclick="return confirm('Hapus kategori ini?');" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
