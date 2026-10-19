<!-- Admin CRUD Buku - Tambah Buku Baru -->
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="mb-4">
        <a href="index.php?c=buku&a=index" class="text-xs font-semibold text-gray-500 hover:text-gray-800 transition inline-flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Buku
        </a>
    </div>

    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xs space-y-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tambah Buku Koleksi Baru</h1>
            <p class="text-xs text-gray-500 mt-1">Masukkan informasi detail buku, kategori jurusan SMK / novel, serta jumlah stok fisik.</p>
        </div>

        <form action="index.php?c=buku&a=tambah" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Judul Buku <span class="text-red-500">*</span></label>
                <input type="text" name="judul" required placeholder="Contoh: Pemrograman Web & Perangkat Bergerak SMK Kelas XI" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Penulis / Pengarang <span class="text-red-500">*</span></label>
                    <input type="text" name="penulis" required placeholder="Contoh: Budi Raharjo" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Kategori / Jurusan <span class="text-red-500">*</span></label>
                    <select name="id_kategori" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                        <option value="">-- Pilih Kategori / Jurusan --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id_kategori'] ?>"><?= htmlspecialchars($cat['nama_kategori']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Penerbit</label>
                    <select name="id_penerbit" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] focus:ring-2 focus:ring-[#8FA89B]/20 outline-none text-gray-800 bg-gray-50 focus:bg-white">
                        <option value="">-- Pilih Penerbit --</option>
                        <?php foreach ($publishers as $pub): ?>
                            <option value="<?= $pub['id_penerbit'] ?>"><?= htmlspecialchars($pub['nama_penerbit']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" value="<?= date('Y') ?>" min="1950" max="<?= date('Y') + 1 ?>" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] outline-none text-gray-800 bg-gray-50 focus:bg-white">
                </div>

                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Jumlah Stok <span class="text-red-500">*</span></label>
                    <input type="number" name="stok" value="10" min="0" required class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#8FA89B] outline-none text-gray-800 bg-gray-50 focus:bg-white">
                </div>
            </div>

            <div class="space-y-1">
                <label class="font-semibold text-gray-700">Foto Cover Buku (Opsional)</label>
                <input type="file" name="gambar" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-gray-200 text-gray-500 bg-gray-50 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#8FA89B] file:text-white hover:file:bg-[#789687]">
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="index.php?c=buku&a=index" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 font-semibold text-xs transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-bold text-xs transition shadow-xs">
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>
