<!-- Admin CRUD Transaksi Peminjaman - Index -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Sirkulasi Perpustakaan</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Kelola Transaksi Peminjaman</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Persetujuan pengajuan pinjam, proses pengembalian buku, dan pencatatan denda keterlambatan.
            </p>
        </div>

        <a href="index.php?c=laporan&a=index" class="px-3.5 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold transition flex items-center gap-1.5 shadow-xs self-start sm:self-auto">
            <i class="fa-solid fa-file-word text-blue-600"></i> Laporan Hari Ini
        </a>
    </div>

    <!-- Filter Bar (Status, Rentang Tanggal, Pencarian) -->
    <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-xs">
        <form action="index.php" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">
            <input type="hidden" name="c" value="transaksi">
            <input type="hidden" name="a" value="index">

            <!-- Search -->
            <div class="flex items-center px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 focus-within:bg-white focus-within:border-[#8FA89B]">
                <i class="fa-solid fa-magnifying-glass text-gray-400 mr-2"></i>
                <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" placeholder="Cari nama / NIS / buku..." class="w-full bg-transparent border-none focus:outline-none">
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 focus:outline-none">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu" <?= ($selectedStatus === 'menunggu') ? 'selected' : '' ?>>Menunggu Konfirmasi</option>
                    <option value="dipinjam" <?= ($selectedStatus === 'dipinjam') ? 'selected' : '' ?>>Sedang Dipinjam</option>
                    <option value="dikembalikan" <?= ($selectedStatus === 'dikembalikan') ? 'selected' : '' ?>>Sudah Dikembalikan</option>
                    <option value="ditolak" <?= ($selectedStatus === 'ditolak') ? 'selected' : '' ?>>Ditolak</option>
                </select>
            </div>

            <!-- Date range -->
            <div>
                <input type="date" name="start_date" value="<?= htmlspecialchars($startDate) ?>" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 focus:outline-none" title="Tanggal Mulai">
            </div>
            <div>
                <input type="date" name="end_date" value="<?= htmlspecialchars($endDate) ?>" class="w-full px-3 py-2 rounded-xl bg-gray-50 border border-gray-200 text-gray-700 focus:outline-none" title="Tanggal Akhir">
            </div>

            <!-- Filter Button -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-grow py-2 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white font-bold transition">
                    Terapkan Filter
                </button>
                <a href="index.php?c=transaksi&a=index" class="p-2 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-500 text-center" title="Reset Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Transaksi Table -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3">ID Trx</th>
                        <th class="px-5 py-3">Peminjam</th>
                        <th class="px-5 py-3">Buku Dipinjam</th>
                        <th class="px-5 py-3">Petugas</th>
                        <th class="px-5 py-3">Tgl Pengajuan</th>
                        <th class="px-5 py-3">Tgl Pinjam / Batas</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Denda</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($transaksiList)): ?>
                        <tr>
                            <td colspan="9" class="px-5 py-8 text-center text-gray-400">Tidak ada data transaksi yang sesuai filter.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($transaksiList as $t): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5 font-mono font-semibold text-gray-900">#<?= $t['id_transaksi'] ?></td>
                                <td class="px-5 py-3.5">
                                    <?php if (!empty($t['nama_peminjam']) && $t['nama_peminjam'] !== 'Siswa (ID: )'): ?>
                                        <strong class="text-gray-900 block"><?= htmlspecialchars($t['nama_peminjam']) ?></strong>
                                        <span class="text-[10px] text-gray-400">NIS: <?= htmlspecialchars($t['nis'] ?? '-') ?></span>
                                    <?php else: ?>
                                        <strong class="text-amber-600 block italic">Peminjam tidak tercatat</strong>
                                        <span class="text-[10px] text-gray-400">ID Pengguna Kosong/Null</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3.5 max-w-xs">
                                    <span class="line-clamp-2" title="<?= htmlspecialchars($t['daftar_buku']) ?>">
                                        <?= htmlspecialchars($t['daftar_buku'] ?: 'Buku tidak tercatat') ?>
                                    </span>
                                </td>
                                <!-- Menampilkan Nama Petugas -->
                                <td class="px-5 py-3.5">
                                    <?php if (!empty($t['nama_admin'])): ?>
                                        <span class="font-medium text-gray-800"><?= htmlspecialchars($t['nama_admin']) ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">Belum diproses</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3.5"><?= $t['tgl_pengajuan'] ?></td>
                                <td class="px-5 py-3.5">
                                    <?php if (!empty($t['tgl_pinjam'])): ?>
                                        <span><?= $t['tgl_pinjam'] ?></span>
                                        <span class="block text-[10px] text-gray-400">s/d <?= $t['batas_kembali'] ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">Belum diproses</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $t['status'] === 'menunggu' ? 'bg-amber-100 text-amber-800' : ($t['status'] === 'dipinjam' ? 'bg-sky-100 text-sky-800' : ($t['status'] === 'dikembalikan' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800')) ?>">
                                        <?= ucfirst($t['status']) ?>
                                    </span>
                                </td>
                                <!-- PERBAIKAN: Menggunakan calculated_denda agar denda langsung muncul real-time -->
                                <td class="px-5 py-3.5 font-semibold <?= $t['calculated_denda'] > 0 ? 'text-rose-600' : 'text-gray-400' ?>">
                                    Rp <?= number_format($t['calculated_denda'], 0, ',', '.') ?>
                                </td>
                                <td class="px-5 py-3.5 text-right whitespace-nowrap space-x-1">
                                    <a href="index.php?c=transaksi&a=detail&id=<?= $t['id_transaksi'] ?>" class="px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition" title="Lihat detail dan proses">
                                        Detail / Proses
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
<!-- Admin CRUD Transaksi Peminjaman - Index -->