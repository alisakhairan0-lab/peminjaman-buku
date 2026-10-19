<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="text-xs font-semibold text-[#8FA89B] uppercase tracking-wider">Arsip Transaksi Pribadi</span>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-1">Riwayat Peminjaman Buku</h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Catatan lengkap semua buku yang pernah dan sedang Anda pinjam di perpustakaan.
            </p>
        </div>

        <a href="index.php?c=katalog&a=index" class="px-4 py-2.5 rounded-xl bg-[#8FA89B] hover:bg-[#789687] text-white text-xs font-bold transition shadow-xs self-start sm:self-auto flex items-center gap-1.5">
            <i class="fa-solid fa-book-open"></i> Pinjam Buku Baru
        </a>
    </div>

    <!-- Riwayat Table -->
    <div class="bg-white rounded-3xl border border-gray-200 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-gray-600">
                <thead class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3">ID Trx</th>
                        <th class="px-5 py-3">Buku yang Dipinjam</th>
                        <th class="px-5 py-3">Tgl Pengajuan</th>
                        <th class="px-5 py-3">Tgl Pinjam / Batas</th>
                        <th class="px-5 py-3">Tgl Dikembalikan</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Denda</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($myTransactions)): ?>
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-gray-400">
                                Anda belum memiliki riwayat transaksi peminjaman.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($myTransactions as $r): ?>
                            <?php 
                                $statusR = trim($r['status'] ?? '');
                                if ($statusR === '') $statusR = 'dipinjam'; 
                            ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-5 py-3.5 font-mono font-semibold text-gray-900">#<?= $r['id_transaksi'] ?></td>
                                <td class="px-5 py-3.5 font-medium text-gray-900 max-w-sm">
                                    <?= htmlspecialchars($r['daftar_buku'] ?? '-') ?>
                                </td>
                                <td class="px-5 py-3.5"><?= $r['tgl_pengajuan'] ?? '-' ?></td>
                                <td class="px-5 py-3.5">
                                    <?php if (!empty($r['tgl_pinjam'])): ?>
                                        <span><?= $r['tgl_pinjam'] ?></span>
                                        <span class="block text-[10px] text-gray-400">Batas: <?= $r['batas_kembali'] ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">Menunggu</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-3.5">
                                    <?= $r['tgl_kembali'] ?: '-' ?>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $statusR === 'menunggu' ? 'bg-amber-100 text-amber-800' : ($statusR === 'dipinjam' ? 'bg-sky-100 text-sky-800' : ($statusR === 'menunggu_kembali' ? 'bg-purple-100 text-purple-800' : ($statusR === 'dikembalikan' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800'))) ?>">
                                        <?= $statusR === 'menunggu_kembali' ? 'Menunggu Konfirmasi' : ucfirst($statusR) ?>
                                    </span>
                                </td>
                                <!-- PERBAIKAN: Menggunakan calculated_denda agar denda real-time muncul -->
                                <td class="px-5 py-3.5 font-semibold <?= ($r['calculated_denda'] ?? 0) > 0 ? 'text-rose-600' : 'text-gray-400' ?>">
                                    Rp <?= number_format($r['calculated_denda'] ?? 0, 0, ',', '.') ?>
                                </td>
                                <!-- Kolom Aksi Pengembalian oleh Siswa -->
                                <td class="px-5 py-3.5 text-right whitespace-nowrap">
                                    <?php if ($statusR === 'dipinjam'): ?>
                                        <a href="index.php?c=user&a=ajukanKembali&id=<?= $r['id_transaksi'] ?>" 
                                           onclick="return confirm('Yakin ingin mengajukan pengembalian buku ini ke petugas?');"
                                           class="px-3 py-1.5 rounded-lg bg-[#8FA89B] hover:bg-[#789687] text-white text-[11px] font-semibold transition inline-block">
                                            Ajukan Kembali
                                        </a>
                                    <?php elseif ($statusR === 'menunggu_kembali'): ?>
                                        <span class="text-purple-600 font-semibold text-[11px]">Menunggu Konfirmasi</span>
                                    <?php else: ?>
                                        <span class="text-gray-300">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>