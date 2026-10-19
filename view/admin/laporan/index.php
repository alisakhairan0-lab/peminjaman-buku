<!-- Laporan Perpustakaan & Ekspor Word/Excel -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Pusat Pelaporan & Dokumen</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Laporan Transaksi & Ekspor Dokumen</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Unduh rekapitulasi transaksi hari ini ke format Microsoft Word (.doc) dan Excel (.xls), serta kelola berkas arsip.
            </p>
        </div>

        <!-- Quick Export Buttons -->
        <div class="flex items-center gap-2">
            <a href="index.php?c=laporan&a=exportWord" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-file-word"></i> Ekspor ke MS Word (.doc)
            </a>
            <a href="index.php?c=laporan&a=exportExcel" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition flex items-center gap-2 shadow-xs">
                <i class="fa-solid fa-file-excel"></i> Ekspor ke MS Excel (.xls)
            </a>
        </div>
    </div>

    <!-- Upload & File Archiving Section -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Upload Form -->
        <div class="md:col-span-5 bg-white rounded-3xl p-6 border border-gray-200 shadow-xs space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#EAF0EC] text-[#557565] flex items-center justify-center font-bold text-lg">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Unggah Dokumen Laporan</h3>
                    <p class="text-xs text-gray-500">Simpan arsip laporan (.doc, .docx, .xls, .xlsx)</p>
                </div>
            </div>

            <form action="index.php?c=laporan&a=uploadLaporan" method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                <div class="space-y-1">
                    <label class="font-semibold text-gray-700">Pilih Berkas Laporan</label>
                    <input type="file" name="file_laporan" required accept=".doc,.docx,.xls,.xlsx" class="w-full px-3 py-2 rounded-xl border border-gray-200 bg-gray-50 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#8FA89B] file:text-white">
                    <span class="text-[10px] text-gray-400 block">Mendukung format Microsoft Word & Excel untuk data kategori atau rekap harian.</span>
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-bold text-xs transition shadow-xs">
                    <i class="fa-solid fa-upload mr-1"></i> Unggah & Arsipkan Dokumen
                </button>
            </form>
        </div>

        <!-- Category Summary Highlights -->
        <div class="md:col-span-7 bg-white rounded-3xl p-6 border border-gray-200 shadow-xs space-y-4">
            <h3 class="font-bold text-gray-900 text-sm border-b border-gray-100 pb-2">
                Distribusi Koleksi Berdasarkan Kategori yang Ditambahkan
            </h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 text-xs max-h-48 overflow-y-auto pr-1">
                <?php foreach ($categories as $cat): ?>
                    <div class="p-2.5 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-between">
                        <span class="font-medium text-gray-700 truncate mr-2" title="<?= htmlspecialchars($cat['nama_kategori']) ?>">
                            <?= htmlspecialchars($cat['nama_kategori']) ?>
                        </span>
                        <span class="px-1.5 py-0.5 rounded-md bg-white border border-gray-200 text-gray-600 text-[10px] font-bold shrink-0">
                            <?= $cat['total_buku'] ?> Judul
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Preview Table of Today's Transactions -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="p-5 sm:p-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="font-bold text-gray-900 text-base">Pratinjau Rekap Transaksi Hari Ini (<?= date('d F Y') ?>)</h3>
                <p class="text-xs text-gray-500">Data ini yang akan otomatis disertakan ke dalam berkas Word dan Excel saat diunduh.</p>
            </div>
            <span class="text-xs text-gray-500 font-semibold bg-gray-100 px-3 py-1 rounded-full self-start sm:self-auto">
                Total: <?= count($todayTransactions) ?> Transaksi
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3">No</th>
                        <th class="px-5 py-3">ID Trx</th>
                        <th class="px-5 py-3">Peminjam / NIS</th>
                        <th class="px-5 py-3">Buku yang Dipinjam</th>
                        <th class="px-5 py-3">Pengajuan</th>
                        <th class="px-5 py-3">Batas Kembali</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($todayTransactions)): ?>
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-gray-400">
                                Tidak ada aktivitas peminjaman atau pengembalian pada tanggal hari ini.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($todayTransactions as $t): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3 text-gray-400"><?= $no++ ?></td>
                                <td class="px-5 py-3 font-mono font-semibold text-gray-900">#<?= $t['id_transaksi'] ?></td>
                                <td class="px-5 py-3">
                                    <strong class="text-gray-900 block"><?= htmlspecialchars($t['nama_peminjam']) ?></strong>
                                    <span class="text-[10px] text-gray-400">NIS: <?= $t['nis'] ?></span>
                                </td>
                                <td class="px-5 py-3 max-w-xs">
                                    <span class="line-clamp-2"><?= htmlspecialchars($t['daftar_buku']) ?></span>
                                </td>
                                <td class="px-5 py-3"><?= $t['tgl_pengajuan'] ?></td>
                                <td class="px-5 py-3"><?= $t['batas_kembali'] ?: '-' ?></td>
                                <td class="px-5 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold <?= $t['status'] === 'menunggu' ? 'bg-amber-100 text-amber-800' : ($t['status'] === 'dipinjam' ? 'bg-sky-100 text-sky-800' : 'bg-emerald-100 text-emerald-800') ?>">
                                        <?= ucfirst($t['status']) ?>
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-right font-semibold text-rose-600">
                                    Rp <?= number_format($t['total_denda'], 0, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
